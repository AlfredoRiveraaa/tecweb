<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase{
    private $data = NULL;

    public function __construct($user='root', $pass='eura12vl', $db='marketzone'){
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }

    public function getData(){
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

    public function list(){
        $this->data = array();

        if ( $result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")){
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)){
                foreach($rows as $num => $row){
                    foreach($row as $key => $value){
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        }
        else{
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function add($producto){
        // $producto = file_get_contents('php://input');
        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );
        if(!empty($producto)) {
            // SE TRANSFORMA EL STRING DEL JASON A OBJETO
            $jsonOBJ = json_decode($producto);
            // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);
            
            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if($this->conexion->query($sql)){
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
                }
            }

            $result->free();
            // Cierra la conexion
            $this->conexion->close();
        }
    }

    public function delete($id){
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
        if ( $this->conexion->query($sql) ) {
            $this->data['status'] =  "success";
            $this->data['message'] =  "Producto eliminado";
        } else {
            $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
        }
        $this->conexion->close();
    }

    public function edit($producto){
        if(!empty($producto)) {
            // SE TRANSFORMA EL STRING DEL JASON A OBJETO
            $jsonOBJ = json_decode($producto);

                $this->conexion->set_charset("utf8");
                $sql = "UPDATE productos SET nombre = '{$jsonOBJ->nombre}', marca = '{$jsonOBJ->marca}', modelo = '{$jsonOBJ->modelo}', 
                        precio = {$jsonOBJ->precio}, detalles = '{$jsonOBJ->detalles}', unidades = " . (float)$jsonOBJ->unidades . ", 
                        imagen = '{$jsonOBJ->imagen}' WHERE id = " . (int)$jsonOBJ->id;

                if($this->conexion->query($sql)){
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto Editado";
                } else {
                    $this->data['status'] = "error";
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
                }

            // Cierra la conexion
            $this->conexion->close();
        }
    }

    public function get($id){
        // $query = "SELECT * FROM productos WHERE id = $id";
        $result = $this->conexion->query("SELECT * FROM productos WHERE id = $id");

        if(!$result){
            die('Query Error: '.mysqli_error($this->conexion));
        }

        $this->data = array();
        while($row = mysqli_fetch_array($result)){
            $this->data[] = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'precio' => $row['precio'],
                'unidades' => $row['unidades'],
                'modelo' => $row['modelo'],
                'marca' => $row['marca'],
                'detalles' => $row['detalles'],
                'imagen' => $row['imagen']
            );
        }           
        $result->free();
        $this->conexion->close();
    }

    public function search($search){
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array();
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
        if ( $result = $this->conexion->query($sql) ) {
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
    }
}
?>