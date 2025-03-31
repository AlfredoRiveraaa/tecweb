<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = NULL;
    public function __construct($db = 'marketzone', $user = 'root', $pass = 'eura12vl') {
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }

    public function list() {
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array();
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            // SE OBTIENEN LOS RESULTADOS
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
        return $this;
    }

    public function single($id) {
        // SE INICIALIZA EL ARREGLO
        $this->data = array();
        // SE PREPARA LA QUERY CON PARÁMETROS
        if ($stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id = ? AND eliminado = 0")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // SE OBTIENE EL RESULTADO
                $row = $result->fetch_assoc();
                foreach($row as $key => $value) {
                    $this->data[$key] = utf8_encode($value);
                }
            } else {
                $this->data = array('status' => 'error', 'message' => 'Producto no encontrado');
            }
            $stmt->close();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
        return $this;
    }

    public function singleByName($name) {
        // SE INICIALIZA EL ARREGLO
        $this->data = array();
        // SE PREPARA LA QUERY CON PARÁMETROS
        if ($stmt = $this->conexion->prepare("SELECT * FROM productos WHERE nombre LIKE ? AND eliminado = 0")) {
            $searchName = "%{$name}%";
            $stmt->bind_param("s", $searchName);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            } else {
                $this->data = array('status' => 'error', 'message' => 'Producto no encontrado');
            }
            $stmt->close();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
        return $this;
    }

    public function search($searchTerm) {
        // SE INICIALIZA EL ARREGLO
        $this->data = array();
        // SE PREPARA LA QUERY CON BÚSQUEDA EN MÚLTIPLES CAMPOS
        $sql = "SELECT * FROM productos WHERE (id = ? OR nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) AND eliminado = 0";
        if ($stmt = $this->conexion->prepare($sql)) {
            $searchParam = "%{$searchTerm}%";
            $stmt->bind_param("isss", $searchTerm, $searchParam, $searchParam, $searchParam);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // SE OBTIENEN Y PROCESAN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $stmt->close();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
        return $this;
    }

    public function checkName($name) {
        // SE INICIALIZA EL ARREGLO DE RESPUESTA
        $this->data = array('exists' => false, 'coincidencias' => array());
        // SE PREPARA LA QUERY PARA VERIFICAR NOMBRES EXISTENTES
        if ($stmt = $this->conexion->prepare("SELECT nombre FROM productos WHERE nombre LIKE ? AND eliminado = 0")) {
            $searchName = "%{$name}%";
            $stmt->bind_param("s", $searchName);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // SE REGISTRAN LAS COINCIDENCIAS ENCONTRADAS
                $this->data['exists'] = true;
                while ($row = $result->fetch_assoc()) {
                    $this->data['coincidencias'][] = $row['nombre'];
                }
            }
            $stmt->close();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
        return $this;
    }

    public function insert($data) {
        // SE INICIALIZA EL ARREGLO CON RESPUESTA POR DEFECTO
        $this->data = array('status' => 'error', 'message' => 'Ya existe un producto con ese nombre');
        
        // PRIMERO SE VERIFICA SI EL NOMBRE YA EXISTE
        $check = $this->checkName($data['nombre']);
        if (!$check->data['exists']) {
            // SE PREPARA LA QUERY DE INSERCIÓN CON TODOS LOS CAMPOS
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
            if ($stmt = $this->conexion->prepare($sql)) {
                $stmt->bind_param("sssdsss", 
                    $data['nombre'],
                    $data['marca'],
                    $data['modelo'],
                    $data['precio'],
                    $data['detalles'],
                    $data['unidades'],
                    $data['imagen']
                );
                
                if ($stmt->execute()) {
                    // RESPUESTA DE ÉXITO SI SE INSERTA CORRECTAMENTE
                    $this->data = array(
                        'status' => 'success',
                        'message' => 'Producto agregado',
                        'id' => $stmt->insert_id
                    );
                } else {
                    $this->data['message'] = "ERROR: No se pudo insertar el producto. " . $stmt->error;
                }
                $stmt->close();
            }
        }
        $this->conexion->close();
        return $this;
    }

    public function update($id, $data) {
        // SE INICIALIZA EL ARREGLO CON RESPUESTA POR DEFECTO
        $this->data = array('status' => 'error', 'message' => 'Error al actualizar');
        // SE PREPARA LA QUERY DE ACTUALIZACIÓN CON TODOS LOS CAMPOS
        $sql = "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, detalles = ?, unidades = ?, imagen = ? WHERE id = ?";
        if ($stmt = $this->conexion->prepare($sql)) {
            $stmt->bind_param("sssdsssi", 
                $data['nombre'],
                $data['marca'],
                $data['modelo'],
                $data['precio'],
                $data['detalles'],
                $data['unidades'],
                $data['imagen'],
                $id
            );
            
            if ($stmt->execute()) {
                // RESPUESTA DE ÉXITO SI SE ACTUALIZA CORRECTAMENTE
                $this->data = array(
                    'status' => 'success',
                    'message' => 'Producto actualizado',
                    'affected_rows' => $stmt->affected_rows
                );
            } else {
                $this->data['message'] = "ERROR: No se pudo actualizar el producto. " . $stmt->error;
            }
            $stmt->close();
        }
        $this->conexion->close();
        return $this;
    }

    public function delete($id) {
        // SE INICIALIZA EL ARREGLO CON RESPUESTA POR DEFECTO
        $this->data = array('status' => 'error', 'message' => 'Error al eliminar');
        // SE PREPARA LA QUERY DE ELIMINACIÓN LÓGICA
        if ($stmt = $this->conexion->prepare("UPDATE productos SET eliminado = 1 WHERE id = ?")) {
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                // RESPUESTA DE ÉXITO SI SE ELIMINA CORRECTAMENTE
                $this->data = array(
                    'status' => 'success',
                    'message' => 'Producto eliminado',
                    'affected_rows' => $stmt->affected_rows
                );
            } else {
                $this->data['message'] = "ERROR: No se pudo eliminar el producto. " . $stmt->error;
            }
            $stmt->close();
        }
        $this->conexion->close();
        return $this;
    }

    public function getData() {
        // SE HACE LA CONVERSIÓN DE ARRAY A JSON
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>