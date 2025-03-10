// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    // Convierte el JSON a string para poder mostrarlo
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $("#description").val(JsonString);

    // Listar productos al cargar la página
    listarProductos();

    // Evento para el campo de búsqueda (búsqueda en tiempo real)
    $("#search").on("input", function () {
        buscarProducto();
    });

    // Evento para el formulario de agregar producto
    $("#product-form").on("submit", function (e) {
        e.preventDefault();
        agregarProducto();
    });

    // Evento para eliminar producto
    $(document).on("click", ".product-delete", function () {
        eliminarProducto($(this).closest("tr").attr("productId"));
    });
}

function listarProductos() {
    $.ajax({
        url: "./backend/product-list.php",
        method: "GET",
        success: function (response) {
            let productos = JSON.parse(response);
            if (Object.keys(productos).length > 0) {
                let template = '';
                productos.forEach(producto => {
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>
                    `;
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
                $("#products").html(template);
            }
        }
    });
}

function buscarProducto() {
    let search = $("#search").val().trim(); // Obtener el valor del campo de búsqueda

    // Si el campo de búsqueda está vacío, ocultar el recuadro de sugerencias
    if (search === "") {
        $("#product-result").addClass("d-none").removeClass("d-block"); // Ocultar el recuadro
        return;
    }

    // Realizar la búsqueda si el campo no está vacío
    $.ajax({
        url: "./backend/product-search.php?search=" + search,
        method: "GET",
        success: function (response) {
            let productos = JSON.parse(response);

            // Si hay coincidencias, mostrar el recuadro de sugerencias
            if (Object.keys(productos).length > 0) {
                let template_bar = '';

                productos.forEach(producto => {
                    template_bar += `<li>${producto.nombre}</li>`; // Agregar nombres al recuadro de sugerencias
                });

                // Mostrar el recuadro de sugerencias
                $("#product-result").removeClass("d-none").addClass("d-block");
                $("#container").html(template_bar);
            } else {
                // Si no hay coincidencias, ocultar el recuadro de sugerencias
                $("#product-result").addClass("d-none").removeClass("d-block");
            }
        }
    });
}

function agregarProducto() {
    // Obtener los valores del formulario
    let nombre = $("#name").val().trim();
    let jsonString = $("#description").val().trim();

    // Validar que el nombre no esté vacío
    if (nombre === "" || nombre.length > 100) {
        alert("El nombre es obligatorio y debe tener 100 caracteres o menos.");
        return;
    }

    // Validar que el JSON no esté vacío
    if (jsonString === "") {
        alert("El JSON del producto es obligatorio.");
        return;
    }

    // Intentar parsear el JSON
    let productoJson;
    try {
        productoJson = JSON.parse(jsonString);
    } catch (error) {
        alert("El JSON ingresado no es válido. Por favor, revisa el formato.");
        return;
    }

    // Validar que el JSON tenga la estructura esperada
    if (
        !productoJson.precio ||
        !productoJson.unidades ||
        !productoJson.modelo ||
        !productoJson.marca ||
        !productoJson.detalles ||
        !productoJson.imagen
    ) {
        alert("El JSON debe contener los campos: precio, unidades, modelo, marca, detalles e imagen.");
        return;
    }

    // Validar el precio (debe ser un número mayor a 99.99)
    if (isNaN(productoJson.precio) || productoJson.precio <= 99.99) {
        alert("El precio debe ser un número mayor a 99.99.");
        return;
    }

    // Validar las unidades (debe ser un número mayor o igual a 0)
    if (isNaN(productoJson.unidades) || productoJson.unidades < 0) {
        alert("Las unidades deben ser un número mayor o igual a 0.");
        return;
    }

    // Validar el modelo (debe ser alfanumérico y tener 25 caracteres o menos)
    if (
        !/^[a-zA-Z0-9 ]+$/.test(productoJson.modelo) ||
        productoJson.modelo.length > 25
    ) {
        alert("El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos.");
        return;
    }

    // Validar los detalles (debe tener 250 caracteres o menos)
    if (productoJson.detalles.length > 250) {
        alert("Los detalles deben tener 250 caracteres o menos.");
        return;
    }

    // Si no se ha ingresado una imagen, asignar la imagen por defecto
    if (productoJson.imagen === "") {
        productoJson.imagen = "img/default.png";
    }

    // Agregar el nombre del producto al JSON
    productoJson.nombre = nombre;

    // Enviar los datos al servidor
    $.ajax({
        url: "./backend/product-add.php",
        method: "POST",
        contentType: "application/json;charset=UTF-8",
        data: JSON.stringify(productoJson),
        success: function (response) {
            let respuesta = JSON.parse(response);
            if (respuesta.status === "error") {
                alert(respuesta.message); // Mensaje de error
            } else {
                alert(respuesta.message); // Mensaje de éxito
                listarProductos(); // Actualizar la lista de productos
                $("#product-form").trigger("reset"); // Resetear el formulario
                $("#description").val(JSON.stringify(baseJSON, null, 2)); // Restaurar el JSON por defecto
            }
        },
        error: function (xhr, status, error) {
            alert("Error al agregar el producto: " + error); // Manejo de errores de red
        }
    });
}

function eliminarProducto(id) {
    if (confirm("De verdad deseas eliminar el Producto")) {
        $.ajax({
            url: "./backend/product-delete.php?id=" + id,
            method: "GET",
            success: function (response) {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $("#product-result").removeClass("d-none").addClass("d-block");
                $("#container").html(template_bar);
                listarProductos();
            }
        });
    }
}