<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Lista de Productos Vigentes</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    </head>
    <body>
        <h3>LISTA DE PRODUCTOS VIGENTES</h3>
        <br/>
        <?php
        if(isset($_GET['tope'])) {
            $tope = $_GET['tope'];
        } else {
            die('<script>alert("Parámetro \"tope\" no detectado...");</script>');
        }

        if (!empty($tope)) {
            @$link = new mysqli('localhost', 'root', 'eura12vl', 'marketzone');
            
            if ($link->connect_errno) {
                die('<script>alert("Falló la conexión: '.$link->connect_error.'");</script>');
            }

            // Modificamos la consulta para seleccionar solo productos no eliminados (eliminado = 0)
            $query = "SELECT * FROM productos WHERE unidades <= $tope AND eliminado = 0";
            
            if ($result = $link->query($query)) {
                echo '<table class="table">';
                echo '<thead class="thead-dark">';
                echo '<tr><th>#</th><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Precio</th><th>Unidades</th><th>Detalles</th><th>Imagen</th></tr>';
                echo '</thead><tbody>';
                
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr>';
                    echo '<th scope="row">'.$row['id'].'</th>';
                    echo '<td>'.$row['nombre'].'</td>';
                    echo '<td>'.$row['marca'].'</td>';
                    echo '<td>'.$row['modelo'].'</td>';
                    echo '<td>'.$row['precio'].'</td>';
                    echo '<td>'.$row['unidades'].'</td>';
                    echo '<td>'.$row['detalles'].'</td>';
                    echo '<td><img src="'.$row['imagen'].'" width="100"/></td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                $result->free();
            } else {
                echo '<script>alert("No se encontraron productos con ese criterio.");</script>';
            }
            
            $link->close();
        }
        ?>
    </body>
</html>
