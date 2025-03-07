<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';

        // Liberar las variables
        unset($_myvar, $_7var, $myvar, $var7, $_element1);
    ?>

    <!-- Ejercicio 2 -->
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <p>$a = “ManejadorSQL”;</p>
    <p>$b = 'MySQL’;</p>
    <p>$c = &amp;$a;</p>
    <?php
        // Primera asignación de valores
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a; // $c es una referencia a $a

        echo '<h4>Valores iniciales:</h4>';
        echo '<ul>';
        echo '<li>$a: '; var_dump($a); echo '</li>';
        echo '<li>$b: '; var_dump($b); echo '</li>';
        echo '<li>$c: '; var_dump($c); echo '</li>';
        echo '</ul>';

        echo '<h4>Agrega al código las siguientes asignaciones:</h4>';
        echo '<p>$a = "PHP server";</p>';
        echo '<p>$b = &amp;$a;</p>';
        // Segunda asignación de valores
        $a = "PHP server";
        $b = &$a; // Ahora $b también referencia a $a

        echo '<h4>Valores después de la reasignación:</h4>';
        echo '<ul>';
        echo '<li>$a: '; var_dump($a); echo '</li>';
        echo '<li>$b: '; var_dump($b); echo '</li>';
        echo '<li>$c: '; var_dump($c); echo '</li>';
        echo '</ul>';

        // Explicación del comportamiento
        echo '<h4>Explicación:</h4>';
        echo '<p>Inicialmente, $c es una referencia a $a, lo que significa que cualquier cambio en $a también afectará a $c.</p>';
        echo '<p>Cuando reasignamos $a a "PHP server", tanto $a como $c reflejan el nuevo valor, ya que $c sigue siendo una referencia a $a.</p>';
        echo '<p>Luego, al hacer <code>$b = &amp;$a;</code>, ahora $b también es una referencia a $a, por lo que cualquier cambio en $a afectará también a $b y $c.</p>';

        // Liberar variables
        unset($a, $b, $c);
    ?>

    <!-- Ejercicio 3 -->
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación.</p>
    <?php
        // Primera asignación
        $a = "PHP5";
        echo '<h4>Después de <code>$a = "PHP5";</code></h4>';
        echo '<ul><li>$a: '; var_dump($a); echo '</li></ul>';

        // Asignación por referencia en un array
        $z[] = &$a;
        echo '<h4>Después de <code>$z[] = &amp;$a;</code></h4>';
        echo '<ul><li>$z: '; print_r($z); echo '</li></ul>';

        // Nueva asignación a $b
        $b = "5a version de PHP";
        echo '<h4>Después de <code>$b = "5a version de PHP";</code></h4>';
        echo '<ul><li>$b: '; var_dump($b); echo '</li></ul>';

        // Operación con $c (Se convierte $b a número antes de multiplicar para evitar error "A non-numeric value encountered")
        $c = intval($b) * 10;
        echo '<h4>Después de <code>$c = $b * 10;</code></h4>';
        echo '<ul><li>$c: '; var_dump($c); echo '</li></ul>';

        // Concatenación en $a
        $a .= $b;
        echo '<h4>Después de <code>$a .= $b;</code></h4>';
        echo '<ul><li>$a: '; var_dump($a); echo '</li>';
        echo '<li>$z: '; print_r($z); echo '</li></ul>';

        // Multiplicación en $b
        $b = intval($b) * $c;
        echo '<h4>Después de <code>$b *= $c;</code></h4>';
        echo '<ul><li>$b: '; var_dump($b); echo '</li></ul>';

        // Cambio en el array $z
        $z[0] = "MySQL";
        echo '<h4>Después de <code>$z[0] = "MySQL";</code></h4>';
        echo '<ul><li>$z: '; print_r($z); echo '</li>';
        echo '<li>$a: '; var_dump($a); echo '</li></ul>';

        // Explicación del comportamiento
        echo '<h4>Explicación:</h4>';
        echo '<p>1. $a = "PHP5";	Se asigna la cadena "PHP5" a $a.</p>';
        echo '<p>2. $z[] = &amp;$a;	$z[0] se vuelve una referencia a $a.</p>';
        echo '<p>3. $b = "5a version de PHP";	$b se convierte en una cadena de 17 caracteres.</p>';
        echo '<p>4. $c = $b * 10;	PHP extrae 5 de $b y hace 5 * 10 = 50.</p>';
        echo '<p>5. $a .= $b;	Se concatena $b a $a, cambiando también $z[0].</p>';
        echo '<p>6. $b *= $c;	PHP ya trata $b como 5, por lo que multiplica 5 * 50 = 250, y $b se convierte en un número entero (int).</p>';    
        echo '<p>7. $z[0] = "MySQL";	Como $z[0] es una referencia a $a, al cambiar $z[0] a "MySQL", $a también se actualiza automáticamente a "MySQL".</p>';  
        
        // EJERCICIO 4
        echo '<h2>Ejercicio 4 (Usando $GLOBALS)</h2>';
        echo '<h4>Valores de las variables usando $GLOBALS:</h4>';
        echo '<ul>';
        echo '<li>$a: '; var_dump($GLOBALS['a']); echo '</li>';
        echo '<li>$b: '; var_dump($GLOBALS['b']); echo '</li>';
        echo '<li>$c: '; var_dump($GLOBALS['c']); echo '</li>';
        echo '<li>$z: '; print_r($GLOBALS['z']); echo '</li>';
        echo '</ul>';

        // Liberar variables
        unset($a, $b, $c, $z);
    ?>

    <!-- Ejercicio 5 -->
    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <?php
        // Primera asignación
        $a = "7 personas";
        echo '<h4>Después de <code>$a = "7 personas";</code></h4>';
        echo '<ul><li>$a: '; var_dump($a); echo '</li></ul>';

        // Conversión a entero (integer cast)
        $b = (integer) $a;
        echo '<h4>Después de <code>$b = (integer) $a;</code></h4>';
        echo '<ul><li>$b: '; var_dump($b); echo '</li></ul>';

        // Nueva asignación a $a
        $a = "9E3";
        echo '<h4>Después de <code>$a = "9E3";</code></h4>';
        echo '<ul><li>$a: '; var_dump($a); echo '</li></ul>';

        // Conversión a número de punto flotante (double cast)
        $c = (double) $a;
        echo '<h4>Después de <code>$c = (double) $a;</code></h4>';
        echo '<ul><li>$c: '; var_dump($c); echo '</li></ul>';

        // Explicación del comportamiento
        echo '<h4>Explicación:</h4>';
        echo '<p>1. <code>$a = "7 personas";</code> Se asigna una cadena de texto.</p>';
        echo '<p>2. <code>$b = (integer) $a;</code> PHP extrae el primer número de la cadena y lo convierte en entero. $b = 7.</p>';
        echo '<p>3. <code>$a = "9E3";</code> Ahora $a contiene la notación científica de 9000.</p>';
        echo '<p>4. <code>$c = (double) $a;</code> Se convierte la cadena en un número flotante, obteniendo $c = 9000.0.</p>';

        // Liberar variables
        unset($a, $b, $c);
    ?>

    <!-- Ejercicio 6 -->
    <h2>Ejercicio 6</h2>
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas usando la función var_dump().</p>
    <?php
        // Declaración de variables
        $a = "0";       // Cadena "0"
        $b = "TRUE";    // Cadena "TRUE"
        $c = FALSE;     // Booleano falso
        $d = ($a OR $b); // OR entre "0" (falso) y "TRUE" (verdadero) -> TRUE
        $e = ($a AND $c); // AND entre "0" (falso) y FALSE (falso) -> FALSE
        $f = ($a XOR $b); // XOR entre "0" (falso) y "TRUE" (verdadero) -> TRUE

        // Mostrar valores con var_dump()
        echo "<h4>Valores booleanos</h4>";
        echo "<ul>";
        echo "<li>\$a: "; var_dump((bool)$a); echo "</li>";
        echo "<li>\$b: "; var_dump((bool)$b); echo "</li>";
        echo "<li>\$c: "; var_dump((bool)$c); echo "</li>";
        echo "<li>\$d: "; var_dump((bool)$d); echo "</li>";
        echo "<li>\$e: "; var_dump((bool)$e); echo "</li>";
        echo "<li>\$f: "; var_dump((bool)$f); echo "</li>";
        echo "</ul>";

        echo "<p>Después investiga una función de PHP que permita transformar el valor booleano de c y e en uno que se pueda mostrar con un echo:</p>";

        // Transformar los valores booleanos en algo que se pueda mostrar con echo
        echo "<h4>Transformación de valores booleanos</h4>";
        echo "<ul>";
        echo "<li>\$c: " . var_export($c, true) . "</li>";
        echo "<li>\$e: " . var_export($e, true) . "</li>";
        echo "</ul>";

        // Liberar variables
        unset($a, $b, $c, $d, $e, $f);
    ?>

    <!-- Ejercicio 7 -->
    <h2>Ejercicio 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina lo siguiente:</p>

    <?php
        echo "<h4>Información del Servidor y Cliente:</h4>";

        // a. Versión de Apache y PHP
        echo "<h4>a. Versión de Apache y PHP:</h4>";
        echo "<p>Apache: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
        echo "<p>PHP: " . phpversion() . "</p>";

        // b. Nombre del sistema operativo del servidor
        echo "<h4>b. Nombre del sistema operativo del servidor:</h4>";
        echo "<p>Sistema Operativo: " . PHP_OS . "</p>";

        // c. Idioma del navegador del cliente
        echo "<h4>c. Idioma del navegador del cliente:</h4>";
        echo "<p>Idioma: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "</p>";
    ?>

    <div>
        <p>
            <a href="https://validator.w3.org/markup/check?uri=referer"><img
            src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
        </p>
    </div>
</body>
</html>