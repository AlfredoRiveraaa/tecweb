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
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
    
    // SE LISTAN TODOS LOS PRODUCTOS
    // listarProductos();
}

$(document).ready(function(){
    console.log("Jquery is ready!");
    $('#product-result').hide(); //ocultamos caja de estado
    let edit = false;
    let editId = null;

    // Función para listar todos los productos
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',

            success: function(response){
                console.log(response);
                let products = JSON.parse(response);

                let template = '';

                products.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+product.precio+'</li>';
                    descripcion += '<li>unidades: '+product.unidades+'</li>';
                    descripcion += '<li>modelo: '+product.modelo+'</li>';
                    descripcion += '<li>marca: '+product.marca+'</li>';
                    descripcion += '<li>detalles: '+product.detalles+'</li>';

                    template += `
                    <tr productId="${product.id}">
                        <td>${product.id}</td>
                        <td><a href="#" class="product-edit">${product.nombre}</a></td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    `
                });

                $('#products').html(template);
            }
        });
    }

    // Llamar a listarProductos al cargar la página
    listarProductos();

// Función para buscar productos
$('#search').keyup(function() {
    buscarProducto();
});

// Nueva función para buscar productos
function buscarProducto() {
    let search = $("#search").val().trim(); // Obtener el valor del campo de búsqueda

    // Si el campo de búsqueda está vacío, ocultar el recuadro de sugerencias y mostrar todos los productos
    if (search === "") {
        $("#product-result").addClass("d-none").removeClass("d-block"); // Ocultar el recuadro
        listarProductos(); // Mostrar todos los productos
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
                
                // Mostrar los productos en la tabla
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
                $("#products").html(template); // Actualizar la tabla con los productos encontrados
            } else {
                // Si no hay coincidencias, ocultar el recuadro de sugerencias y la tabla
                $("#product-result").addClass("d-none").removeClass("d-block");
                $("#products").html(''); // Limpiar la tabla si no hay resultados
            }
        }
    });
}

    // Función para eliminar un producto
    $(document).on('click', '.product-delete', function(){
        if(confirm('¿Estás seguro de querer eliminar el producto?')){
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId');
            console.log("deleting id: "+id);
            $.get('./backend/product-delete.php', {id}, function(response){
                console.log(response);
                listarProductos();

                response = JSON.parse(response);
                if(response.status == "success"){
                    $('#container').html(`
                                <li>Producto Eliminado</li>
                            `);
                    $('#product-result').show();
                }
                else{
                    $('#container').html(`
                                <li>No se pudo eliminar el producto</li>
                            `);
                    $('#product-result').show();
                }
            });
        }
    });

// Función para agregar un producto
$('#product-form').submit(function(e){
    e.preventDefault();
    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;

    console.log(finalJSON);
    
    // Si estamos editando, agregamos el ID al JSON
    if (edit) {
        finalJSON['id'] = editId;
    }

    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    //validaciones correspondientes (sustituidas de la segunda función)
    let valid = true;
    let errorMessage = "";

    let nombre = finalJSON['nombre'].trim();
    let marca = finalJSON['marca'];
    let modelo = finalJSON['modelo'].trim();
    let precio = parseFloat(finalJSON['precio']);
    let detalles = finalJSON['detalles'].trim();
    let unidades = parseInt(finalJSON['unidades']);
    let imagen = finalJSON['imagen'].trim();
    let imagenPorDefecto = "img/default.png";

    if (nombre === "" || nombre.length > 100) {
        valid = false;
        errorMessage += "El nombre es obligatorio y debe tener 100 caracteres o menos.\n";
    }

    if (marca === "") {
        valid = false;
        errorMessage += "Debe seleccionar una marca.\n";
    }

    if (modelo === "" || modelo.length > 25 || !/^[a-zA-Z0-9 ]+$/.test(modelo)) {
        valid = false;
        errorMessage += "El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos.\n";
    }

    if (isNaN(precio) || precio <= 99.99) {
        valid = false;
        errorMessage += "El precio es obligatorio y debe ser mayor a 99.99.\n";
    }

    if (detalles.length > 250) {
        valid = false;
        errorMessage += "Los detalles deben tener 250 caracteres o menos.\n";
    }

    if (isNaN(unidades) || unidades < 0) {
        valid = false;
        errorMessage += "Las unidades deben ser un número mayor o igual a 0.\n";
    }

    if (imagen === "") {
        imagen = imagenPorDefecto;
    } else if (imagen.length > 50 || !imagen.startsWith('img/')) {
        valid = false;
        errorMessage += "La URL de la imagen del producto no puede ser mayor a 50 caracteres y debe comenzar con 'img/'.\n";
    }

    // Si no es válido, mostramos el mensaje de error y detenemos el proceso
    if (!valid) {
        alert(errorMessage);
        return;
    }

    // Si es valido, se inserta el producto
    let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
    
    $.post(url, productoJsonString, function(response){
        console.log(response);
        listarProductos();
        
        response = JSON.parse(response);
        $('#container').html(`
            <li>${response.status}, ${response.message}</li>
        `);
        $('#product-result').show();

        // Limpiar campos
        edit = false;
        editId = null;
        $('#product-form').trigger('reset');
        document.getElementById("description").value = JSON.stringify(baseJSON, null, 2); // Restablece el JSON
    });
});


    //Función para editar productos
    $(document).on('click', '.product-edit', function(){
        edit = true;

        // console.log("editando. . .");
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        editId = id;
        console.log("editing id: "+id);
        $.get('./backend/product-get.php', {id}, function(response){
            // console.log(response);
            let product = JSON.parse(response);
            console.log(product);

            let productoEditando = JSON.parse(JSON.stringify(baseJSON));
            productoEditando["precio"] = parseFloat(product.precio);
            productoEditando["unidades"] = parseFloat(product.unidades);
            productoEditando["modelo"] = product.modelo;
            productoEditando["marca"] = product.marca;
            productoEditando["detalles"] = product.detalles;
            productoEditando["imagen"] = product.imagen;

            // //mostrar datos en formulario
            document.getElementById('name').value = product.nombre;
            document.getElementById('description').value = JSON.stringify(productoEditando,null,2);
            $('#product-result').hide();
        });
    });
});
