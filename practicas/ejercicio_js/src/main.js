// Función original
function getDatos() {
    var nombre = prompt("Nombre: ", "");
    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: ' + nombre + '</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: ' + edad + '</h3>';
}

// Ejemplo 1: Hola Mundo
function ejemplo1() {
    document.getElementById("output1").innerHTML = "Hola Mundo";
}

// Ejemplo 2: Variables en JavaScript
function ejemplo2() {
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;

    var output = "Nombre: " + nombre + "<br>" +
                 "Edad: " + edad + "<br>" +
                 "Altura: " + altura + "m<br>" +
                 "Casado: " + casado;

    document.getElementById("output2").innerHTML = output;
}

// Ejemplo 3: Entrada de usuario con prompt
function ejemplo3() {
    var nombre = prompt("Ingresa tu nombre:", "");
    var edad = prompt("Ingresa tu edad:", "");

    var output = "Hola " + nombre + ", así que tienes " + edad + " años.";

    document.getElementById("output3").innerHTML = output;
}

// Ejemplo 4: Suma y producto de dos números
function ejemplo4() {
    var valor1 = prompt("Introducir primer número:", "");
    var valor2 = prompt("Introducir segundo número:", "");

    var suma = parseInt(valor1) + parseInt(valor2);
    var producto = parseInt(valor1) * parseInt(valor2);

    var output = "La suma es " + suma + "<br>" +
                 "El producto es " + producto;

    document.getElementById("output4").innerHTML = output;
}

// Ejemplo 5: Verificación de nota aprobatoria
function ejemplo5() {
    var nombre = prompt("Ingresa tu nombre:", "");
    var nota = prompt("Ingresa tu nota:", "");

    if (parseFloat(nota) >= 4) {
        var output = nombre + " está aprobado con un " + nota;
        document.getElementById("output5").innerHTML = output;
    } else {
        document.getElementById("output5").innerHTML = nombre + " no aprobó.";
    }
}

// Ejemplo 6: Determinar el número mayor
function ejemplo6() {
    var num1 = prompt("Ingresa el primer número:", "");
    var num2 = prompt("Ingresa el segundo número:", "");

    num1 = parseInt(num1);
    num2 = parseInt(num2);

    if (num1 > num2) {
        document.getElementById("output6").innerHTML = "El mayor es " + num1;
    } else if (num1 < num2) {
        document.getElementById("output6").innerHTML = "El mayor es " + num2;
    } else {
        document.getElementById("output6").innerHTML = "Ambos números son iguales.";
    }
}

// Ejemplo 7: Promedio de notas y clasificación
function ejemplo7() {
    var nota1 = prompt("Ingresa la 1ra nota:", "");
    var nota2 = prompt("Ingresa la 2da nota:", "");
    var nota3 = prompt("Ingresa la 3ra nota:", "");

    // Convertir a números enteros
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    // Calcular promedio
    var promedio = (nota1 + nota2 + nota3) / 3;
    var resultado;

    if (promedio >= 7) {
        resultado = "Aprobado";
    } else if (promedio >= 4) {
        resultado = "Regular";
    } else {
        resultado = "Reprobado";
    }

    document.getElementById("output7").innerHTML = "Promedio: " + promedio.toFixed(2) + "<br>" + resultado;
}

// Ejemplo 8: Convertir número a texto usando switch
function ejemplo8() {
    var valor = prompt("Ingresar un valor comprendido entre 1 y 5:", "");
    
    // Convertimos a entero
    valor = parseInt(valor);
    
    var resultado;
    switch (valor) {
        case 1: resultado = "Uno"; break;
        case 2: resultado = "Dos"; break;
        case 3: resultado = "Tres"; break;
        case 4: resultado = "Cuatro"; break;
        case 5: resultado = "Cinco"; break;
        default: resultado = "Debe ingresar un valor entre 1 y 5.";
    }
    
    document.getElementById("output8").innerHTML = resultado;
}

// Ejemplo 9: Cambiar el color de fondo de la página
function ejemplo9() {
    var col = prompt("Ingresa el color con que quieres pintar el fondo de la ventana (rojo, verde, azul):", "");

    // Convertimos el texto a minúsculas para evitar errores con mayúsculas
    col = col.toLowerCase();

    switch (col) {
        case "rojo": document.body.style.backgroundColor = "#ff0000"; break;
        case "verde": document.body.style.backgroundColor = "#00ff00"; break;
        case "azul": document.body.style.backgroundColor = "#0000ff"; break;
        default: alert("Color no válido. Usa rojo, verde o azul.");
    }
}

// Ejemplo 10: Imprimir números del 1 al 100 con while
function ejemplo10() {
    var x = 1;
    var resultado = "";

    while (x <= 100) {
        resultado += x + "<br>";
        x++;
    }

    // Insertamos el resultado en un div en lugar de usar document.write()
    document.getElementById("output10").innerHTML = resultado;
}

// Ejemplo 11: Sumar 5 valores ingresados por el usuario
function ejemplo11() {
    var x = 1;
    var suma = 0;
    var resultado = "";

    while (x <= 5) {
        var valor = prompt("Ingresa el valor:", "");
        valor = parseInt(valor);

        if (!isNaN(valor)) {
            suma += valor;
        } else {
            resultado += "Entrada inválida, se ignoró.<br>";
        }

        x++;
    }

    resultado += "La suma de los valores es: " + suma + "<br>";
    
    // Insertamos el resultado en un div en lugar de usar document.write()
    document.getElementById("output11").innerHTML = resultado;
}

// Ejemplo 12: Validar la cantidad de dígitos de un valor ingresado
function ejemplo12() {
    var valor = prompt('Ingresa un valor entre 0 y 999:');
    valor = parseInt(valor); // Convertir el valor a número

    // Validamos que el valor esté dentro del rango 0-999
    if (isNaN(valor) || valor < 0 || valor > 999) {
        document.getElementById("output12").innerHTML = "Por favor ingrese un valor válido entre 0 y 999.";
        return; // Termina la función si el valor no es válido
    }

    var resultado = "El valor " + valor + " tiene ";

    // Validación de los dígitos según el valor
    if (valor < 10) {
        resultado += "1 dígito";
    } else if (valor < 100) {
        resultado += "2 dígitos";
    } else {
        resultado += "3 dígitos";
    }

    // Mostrar el resultado en el div con id "output12"
    document.getElementById("output12").innerHTML = resultado;
}

// Ejemplo 13: Imprimir números del 1 al 10
function ejemplo13() {
    var resultado = "";

    for (var f = 1; f <= 10; f++) {
        resultado += f + " ";
    }

    // Insertamos el resultado en un div en lugar de usar document.write()
    document.getElementById("output13").innerHTML = resultado;
}

// Ejemplo 14: Mensajes repetidos en pantalla
function ejemplo14() {
    var mensaje = "Cuidado<br>Ingresa tu documento correctamente<br>";
    var resultado = mensaje.repeat(3);  // Repite el mensaje 3 veces

    // Insertamos el resultado en un div
    document.getElementById("output14").innerHTML = resultado;
}

// Ejemplo 15: Función que muestra el mensaje repetidamente
function mostrarMensaje() {
    var mensaje = "Cuidado<br>Ingresa tu documento correctamente<br>";
    document.getElementById("output15").innerHTML += mensaje;
}

// Llamada para mostrar el mensaje tres veces
function ejecutarMensaje() {
    mostrarMensaje();
    mostrarMensaje();
    mostrarMensaje();
}

// Ejemplo 16: Función para mostrar un rango de números
function mostrarRango(x1, x2) {
    var resultado = ""; // Usamos una variable para almacenar el resultado
    for (var inicio = x1; inicio <= x2; inicio++) {
        resultado += inicio + " "; // Acumulamos los números en la variable
    }
    document.getElementById("output16").innerHTML = resultado; // Muestra el resultado en un div
}

// Función para manejar la entrada de valores
function ejecutarRango() {
    var valor1 = prompt('Ingresa el valor inferior:', '');
    valor1 = parseInt(valor1);
    var valor2 = prompt('Ingresa el valor superior:', '');
    valor2 = parseInt(valor2);
    mostrarRango(valor1, valor2); // Llama a la función para mostrar el rango
}

// Ejemplo 17: Convertir número a palabra en castellano
function convertirCastellano(x) {
    switch(x) {
        case 1: return "uno";
        case 2: return "dos";
        case 3: return "tres";
        case 4: return "cuatro";
        case 5: return "cinco";
        default: return "valor incorrecto";
    }
}

// Función para manejar la entrada de valores
function convertirNumero() {
    var valor = prompt("Ingresa un valor entre 1 y 5", "");
    valor = parseInt(valor);
    var r = convertirCastellano(valor);
    document.getElementById("output17").innerHTML = r; // Muestra el resultado en un div
}

// Ejemplo 18: Convertir número a palabra en castellano
function convertirCastellano2(x) {
    switch(x) {
        case 1: return "uno";
        case 2: return "dos";
        case 3: return "tres";
        case 4: return "cuatro";
        case 5: return "cinco";
        default: return "valor incorrecto";
    }
}

// Función para manejar la entrada de valores
function convertirNumero() {
    var valor = prompt("Ingresa un valor entre 1 y 5", "");
    valor = parseInt(valor);
    var r = convertirCastellano2(valor);
    document.getElementById("output18").innerHTML = r; // Muestra el resultado en un div
}