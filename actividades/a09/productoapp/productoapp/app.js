// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: "http://localhost/actividades/a09/productoapp/backend/products",
            type: 'GET',
            success: function(response) {
                console.log(response);
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: `http://localhost/actividades/a09/productoapp/backend/products/${search}`,
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
            listarProductos();
        }
    });


    $('#product-form').submit(e => {
        e.preventDefault();

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        let postData = JSON.parse( $('#description').val() );
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        let valid = true;
        let errorMessage = "";

        if (postData['nombre'].length > 100 || postData['nombre'].length == 0) {
            valid = false;
            errorMessage += "El nombre del producto no puede estar vacío o ser mayor a 100 caracteres\n";
        }

        if (!["Logitech", "Nvidia", "HyperX", "NZXT"].includes(postData['marca'])) {
            valid = false;
            errorMessage += "La marca del producto no es válida\n";
        }

        if(postData['modelo'].length> 25 || postData['modelo'].match(/^[a-zA-Z0-9]+$/)){
            valid = false;
            errorMessage += "El modelo es requerido, debe ser alfanumérico y tener 25 caracteres o menos.\n";
        }

        if (isNaN(postData['precio']) || postData['precio'] <= 99.99) {
            valid = false;
            errorMessage += "El precio del producto no es válido (debe ser número y mayor a 99.99)\n";
        }

        if(postData['detalles'].length> 250){
            valid = false;
            errorMessage += "Los detalles del producto no pueden ser mayores a 250 caracteres\n";
        }

        if (isNaN(postData['unidades']) || postData['unidades'] <= 0) {
            valid = false;
            errorMessage += "Las unidades del producto no son válidas (debe ser número y mayor a 0)\n";
        }

        if(postData['imagen'].length > 50 || !postData['imagen'].startsWith('img/')){
            valid = false;
            errorMessage += "La URL de la imagen del producto no puede ser mayor a 50 caracteres y debe comenzar con 'img/'\n";
        }
        // Si es valido, se inserta el producto
        if(!valid){
            alert(errorMessage);
            return;
        } else {
            const url = edit === false
                ? 'http://localhost/actividades/a09/productoapp/backend/product'
                : `http://localhost/actividades/a09/productoapp/backend/product/${postData['id']}`;
            const method = edit === false ? 'POST' : 'PUT';

            $.ajax({
                url: url,
                type: method,
                data: JSON.stringify(postData),
                contentType: 'application/json',
                success: function(response) {
                    let respuesta = JSON.parse(response);
                    let template_bar = `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                    $('#name').val('');
                    $('#description').val(JsonString);
                    $('#product-result').show();
                    $('#container').html(template_bar);
                    listarProductos();
                    edit = false;
                }
            });
        }
        $('#boton1').html("Agregar Producto");
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.ajax({
                url: `http://localhost/actividades/a09/productoapp/backend/product/${id}`,
                type: 'DELETE',
                success: function(response) {
                    $('#product-result').hide();
                    listarProductos();
                    response = JSON.parse(response);
                    let message = response.status === "success" ? "Producto Eliminado" : "No se pudo eliminar el producto";
                    $('#container').html(`<li>${message}</li>`);
                    $('#product-result').show();
                }
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        console.log("editando" + id);
        $.ajax({
            url: `http://localhost/actividades/a09/productoapp/backend/product/${id}`,
            type: 'GET',
            success: function(response) {
                let product = JSON.parse(response);
                $('#name').val(product.nombre);
                $('#productId').val(product.id);
                delete product.nombre;
                delete product.eliminado;
                delete product.id;
                let JsonString = JSON.stringify(product, null, 2);
                $('#description').val(JsonString);
                edit = true;
            }
        });
        $('#boton1').html("Actualizar Producto");
        e.preventDefault();
    });
});

