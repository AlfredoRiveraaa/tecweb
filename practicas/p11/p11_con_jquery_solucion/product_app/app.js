$(document).ready(function () {
    let edit = false;
    const imagenPorDefecto = 'img/default.png'; // Imagen por defecto

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function (response) {
                const productos = JSON.parse(response);

                if (Object.keys(productos).length > 0) {
                    let template = '';

                    productos.forEach(producto => {
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
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + $('#search').val(),
                data: { search },
                type: 'GET',
                success: function (response) {
                    if (!response.error) {
                        const productos = JSON.parse(response);

                        if (Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
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

                                template_bar += `<li>${producto.nombre}</il>`;
                            });

                            $('#product-result').show();
                            $('#container').html(template_bar);
                            $('#products').html(template);
                        }
                    }
                }
            });
        } else {
            $('#product-result').hide();
        }
    });

    // Validar campos al perder el foco
    $('#name, #marca, #modelo, #precio, #detalles, #unidades, #imagen').blur(function () {
        validateField($(this));
    });

    // Función para validar un campo específico
    function validateField(field) {
        let errorMessage = '';
        let valid = true;

        const nombre = $('#name').val().trim();
        const marca = $('#marca').val().trim();
        const modelo = $('#modelo').val().trim();
        const precio = parseFloat($('#precio').val());
        const detalles = $('#detalles').val().trim();
        const unidades = parseInt($('#unidades').val());
        const imagen = $('#imagen').val().trim();

        if (field.attr('id') === 'name' && (nombre === "" || nombre.length > 100)) {
            valid = false;
            errorMessage += "El nombre es obligatorio y debe tener 100 caracteres o menos.\n";
        }

        if (field.attr('id') === 'marca' && marca === "") {
            valid = false;
            errorMessage += "Debe seleccionar una marca.\n";
        }

        if (field.attr('id') === 'modelo' && (modelo === "" || modelo.length > 25 || !/^[a-zA-Z0-9 ]+$/.test(modelo))) {
            valid = false;
            errorMessage += "El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos.\n";
        }

        if (field.attr('id') === 'precio' && (isNaN(precio) || precio <= 99.99)) {
            valid = false;
            errorMessage += "El precio es obligatorio y debe ser mayor a 99.99.\n";
        }

        if (field.attr('id') === 'detalles' && detalles.length > 250) {
            valid = false;
            errorMessage += "Los detalles deben tener 250 caracteres o menos.\n";
        }

        if (field.attr('id') === 'unidades' && (isNaN(unidades) || unidades < 0)) {
            valid = false;
            errorMessage += "Las unidades deben ser un número mayor o igual a 0.\n";
        }

        if (field.attr('id') === 'imagen' && (imagen.length > 50 || (imagen !== "" && !imagen.startsWith('img/')))) {
            valid = false;
            errorMessage += "La URL de la imagen no puede ser mayor a 50 caracteres y debe comenzar con 'img/'.\n";
        }

        if (!valid) {
            field.addClass('is-invalid');
            $('#product-result').show();
            $('#container').html('<li style="list-style: none;">' + errorMessage + '</li>');
        } else {
            field.removeClass('is-invalid');
            $('#product-result').hide();
        }
    }

    // Validar formulario antes de enviar
    $('#product-form').submit(e => {
        e.preventDefault();

        let errorMessage = '';
        let valid = true;

        const nombre = $('#name').val().trim();
        const marca = $('#marca').val().trim();
        const modelo = $('#modelo').val().trim();
        const precio = parseFloat($('#precio').val());
        const detalles = $('#detalles').val().trim();
        const unidades = parseInt($('#unidades').val());
        let imagen = $('#imagen').val().trim();

        // Aplicar validaciones
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
            errorMessage += "La URL de la imagen no puede ser mayor a 50 caracteres y debe comenzar con 'img/'.\n";
        }

        if (!valid) {
            $('#product-result').show();
            $('#container').html('<li style="list-style: none;">' + errorMessage + '</li>');
            return;
        }

        // Si todo es válido, enviar el formulario
        let postData = {
            nombre: nombre,
            marca: marca,
            modelo: modelo,
            precio: precio,
            detalles: detalles,
            unidades: unidades,
            imagen: imagen,
            id: $('#productId').val()
        };

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
            $('#name').val('');
            $('#marca').val('');
            $('#modelo').val('');
            $('#precio').val('');
            $('#detalles').val('');
            $('#unidades').val('');
            $('#imagen').val('');
            $('#product-result').show();
            $('#container').html(template_bar);
            listarProductos();

            // Cambiar el texto del botón a "Agregar Producto"
            $('button.btn-primary').text("Agregar Producto");

            edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', { id }, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', { id }, (response) => {
            let product = JSON.parse(response);
            $('#name').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#detalles').val(product.detalles);
            $('#unidades').val(product.unidades);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);

            // Cambiar el texto del botón a "Modificar Producto"
            $('button.btn-primary').text("Modificar Producto");

            edit = true;
        });
        e.preventDefault();
    });

    $('#name').keyup(function () {
        let nombre = $(this).val().trim(); // Obtener el valor del campo de nombre
    
        if (nombre !== '') {
            // Realizar una solicitud AJAX al servidor
            $.ajax({
                url: './backend/product-check.php', // URL del script PHP
                type: 'GET', // Método de la solicitud
                data: { nombre: nombre }, // Datos enviados al servidor
                success: function (response) {
                    let respuesta = JSON.parse(response); // Convertir la respuesta a un objeto JavaScript
    
                    if (respuesta.error) {
                        // Si hay un error, mostrar el mensaje de error
                        $('#suggestions').hide(); // Ocultar el recuadro de sugerencias
                        $('#product-result').show();
                        $('#container').html('<li style="list-style: none;">' + respuesta.message + '</li>');
                    } else if (respuesta.exists) {
                        // Si hay coincidencias, mostrarlas en el recuadro
                        let sugerenciasHTML = '';
                        respuesta.coincidencias.forEach(coincidencia => {
                            sugerenciasHTML += `<div style="padding: 5px; cursor: pointer;" class="sugerencia-item">${coincidencia}</div>`;
                        });
                        $('#suggestions').html(sugerenciasHTML).show(); // Mostrar el recuadro con las coincidencias
                    } else {
                        // Si no hay coincidencias, ocultar el recuadro
                        $('#suggestions').hide();
                    }
                },
                error: function () {
                    // Manejar errores de la solicitud AJAX
                    $('#suggestions').hide(); // Ocultar el recuadro de sugerencias
                    $('#product-result').show();
                    $('#container').html('<li style="list-style: none;">Error al verificar el nombre del producto.</li>');
                }
            });
        } else {
            // Si el campo está vacío, ocultar el recuadro de sugerencias
            $('#suggestions').hide();
        }
    });
    
    // Manejar clic en una sugerencia
    $(document).on('click', '.sugerencia-item', function () {
        let nombreSeleccionado = $(this).text(); // Obtener el nombre seleccionado
        $('#name').val(nombreSeleccionado); // Poner el nombre seleccionado en el campo de nombre
        $('#suggestions').hide(); // Ocultar el recuadro de sugerencias
    });
});