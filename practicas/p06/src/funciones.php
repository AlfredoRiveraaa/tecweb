<?php

function es_multiplo7y5($num) {
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}

?>

<?php

function generar_secuencia() {
    $matriz = [];
    $iteraciones = 0;
    
    while (true) {
        $iteraciones++;
        $num1 = rand(100, 999);
        $num2 = rand(100, 999);
        $num3 = rand(100, 999);

        $matriz[] = [$num1, $num2, $num3];

        // Verificar si cumple con la secuencia impar-par-impar
        if ($num1 % 2 != 0 && $num2 % 2 == 0 && $num3 % 2 != 0) {
            break;
        }
    }

    // Contar la cantidad total de números generados
    $total_numeros = count($matriz) * 3;

    return [
        'matriz' => $matriz,
        'iteraciones' => $iteraciones,
        'total_numeros' => $total_numeros
    ];
}

?>

<?php

function encontrar_multiplo_while($multiplo) {
    if (!is_numeric($multiplo) || $multiplo <= 0) {
        return "Por favor, proporciona un número válido mayor que 0.";
    }

    $contador = 0;
    $numero = 0;

    while (true) {
        $contador++;
        $numero = rand(100, 999);
        if ($numero % $multiplo == 0) {
            break;
        }
    }

    return "Primer múltiplo de $multiplo encontrado con WHILE: $numero en $contador intentos.";
}

function encontrar_multiplo_dowhile($multiplo) {
    if (!is_numeric($multiplo) || $multiplo <= 0) {
        return "Por favor, proporciona un número válido mayor que 0.";
    }

    $contador = 0;
    $numero = 0;

    do {
        $contador++;
        $numero = rand(100, 999);
    } while ($numero % $multiplo != 0);

    return "Primer múltiplo de $multiplo encontrado con DO-WHILE: $numero en $contador intentos.";
}

?>

<?php

function generar_arreglo_ascii() {
    $arreglo = [];

    // Generar arreglo con índices ASCII del 97 al 122
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }

    return $arreglo;
}

function mostrar_tabla_ascii() {
    $arreglo = generar_arreglo_ascii();

    echo "<table border='1'>";
    echo "<tr><th>Índice ASCII</th><th>Letra</th></tr>";

    foreach ($arreglo as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>";
    }

    echo "</table>";
}

?>

<?php

function validar_usuario($edad, $sexo) {
    if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
        echo "<h3>Bienvenida, usted está en el rango de edad permitido.</h3>";
    } else {
        echo "<h3>Error: No cumple con los requisitos de edad y/o sexo.</h3>";
    }
}

?>

