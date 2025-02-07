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

<?php

$parqueVehicular = [
    "UBN6338" => [
        "Auto" => ["marca" => "HONDA", "modelo" => 2020, "tipo" => "camioneta"],
        "Propietario" => ["nombre" => "Alfonzo Esparza", "ciudad" => "Puebla, Pue.", "direccion" => "C.U., Jardines de San Manuel"]
    ],
    "UBN6339" => [
        "Auto" => ["marca" => "MAZDA", "modelo" => 2019, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Ma. del Consuelo Molina", "ciudad" => "Puebla, Pue.", "direccion" => "97 oriente"]
    ],
    "XYZ1234" => [
        "Auto" => ["marca" => "TOYOTA", "modelo" => 2021, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Luis Hernández", "ciudad" => "Monterrey, NL", "direccion" => "Av. Revolución 123"]
    ],
    "ABC5678" => [
        "Auto" => ["marca" => "FORD", "modelo" => 2018, "tipo" => "pickup"],
        "Propietario" => ["nombre" => "José Martínez", "ciudad" => "Guadalajara, JAL", "direccion" => "Calle 5 de Mayo"]
    ],
    "DEF9101" => [
        "Auto" => ["marca" => "CHEVROLET", "modelo" => 2017, "tipo" => "SUV"],
        "Propietario" => ["nombre" => "María González", "ciudad" => "CDMX", "direccion" => "Insurgentes Sur 890"]
    ],
    "GHI1123" => [
        "Auto" => ["marca" => "VOLKSWAGEN", "modelo" => 2022, "tipo" => "hatchback"],
        "Propietario" => ["nombre" => "Carlos Ramírez", "ciudad" => "Toluca, MEX", "direccion" => "Av. Morelos 300"]
    ],
    "JKL4567" => [
        "Auto" => ["marca" => "NISSAN", "modelo" => 2020, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Laura Fernández", "ciudad" => "Veracruz, VER", "direccion" => "Malecón del Río"]
    ],
    "MNO8910" => [
        "Auto" => ["marca" => "HYUNDAI", "modelo" => 2021, "tipo" => "crossover"],
        "Propietario" => ["nombre" => "Ricardo Torres", "ciudad" => "Mérida, YUC", "direccion" => "Calle 60 Centro"]
    ],
    "PQR3456" => [
        "Auto" => ["marca" => "KIA", "modelo" => 2019, "tipo" => "compacto"],
        "Propietario" => ["nombre" => "Diana López", "ciudad" => "Tijuana, BC", "direccion" => "Blvd. Agua Caliente"]
    ],
    "STU7891" => [
        "Auto" => ["marca" => "BMW", "modelo" => 2023, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Fernando Castillo", "ciudad" => "Monterrey, NL", "direccion" => "San Pedro Garza García"]
    ],
    "VWX2345" => [
        "Auto" => ["marca" => "MERCEDES", "modelo" => 2022, "tipo" => "coupe"],
        "Propietario" => ["nombre" => "Andrea Pérez", "ciudad" => "Querétaro, QRO", "direccion" => "Av. Constituyentes"]
    ],
    "YZA6789" => [
        "Auto" => ["marca" => "AUDI", "modelo" => 2021, "tipo" => "SUV"],
        "Propietario" => ["nombre" => "Juan Robles", "ciudad" => "León, GTO", "direccion" => "Calle Madero"]
    ],
    "BCD1234" => [
        "Auto" => ["marca" => "TESLA", "modelo" => 2023, "tipo" => "eléctrico"],
        "Propietario" => ["nombre" => "Silvia Navarro", "ciudad" => "San Luis Potosí, SLP", "direccion" => "Plaza de Armas"]
    ],
    "EFG5678" => [
        "Auto" => ["marca" => "SUBARU", "modelo" => 2020, "tipo" => "SUV"],
        "Propietario" => ["nombre" => "Ernesto Salgado", "ciudad" => "Chihuahua, CHIH", "direccion" => "Av. Tecnológico"]
    ],
    "HIJ9101" => [
        "Auto" => ["marca" => "DODGE", "modelo" => 2018, "tipo" => "pickup"],
        "Propietario" => ["nombre" => "Mónica Ríos", "ciudad" => "Hermosillo, SON", "direccion" => "Blvd. Kino"]
    ]
];

function mostrar_todos_los_vehiculos() {
    global $parqueVehicular;
    echo "<pre>";
    print_r($parqueVehicular);
    echo "</pre>";
}

function buscar_vehiculo_por_matricula($matricula) {
    global $parqueVehicular;
    if (isset($parqueVehicular[$matricula])) {
        $resultado = [
            $matricula => $parqueVehicular[$matricula] // Incluye la matrícula como clave
        ];
        
        echo "<pre>";
        print_r($resultado);
        echo "</pre>";
    } else {
        echo "<p>No se encontró un auto con la matrícula $matricula.</p>";
    }
}

?>

