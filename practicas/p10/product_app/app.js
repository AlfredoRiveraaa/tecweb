// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar por ID"
function buscarID(e) {
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value.trim();

    // SI EL CAMPO ESTÁ VACÍO, NO SE HACE NADA
    if (id === "") return;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);

            let producto = JSON.parse(client.responseText);

            if (Object.keys(producto).length > 0) {
                mostrarProductos([producto]); // LLAMADA A FUNCIÓN DE RENDERIZADO
            } else {
                alert("No se encontró ningún producto con el ID proporcionado.");
            }
        }
    };
    client.send("id=" + encodeURIComponent(id));
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar Producto"
function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL TÉRMINO DE BÚSQUEDA
    var query = document.getElementById('search').value.trim();

    // SI EL CAMPO ESTÁ VACÍO, NO SE HACE NADA
    if (query === "") return;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);

            let productos = JSON.parse(client.responseText);

            if (productos.length > 0) {
                mostrarProductos(productos); // LLAMADA A FUNCIÓN DE RENDERIZADO
            } else {
                alert("No se encontraron productos con esa búsqueda.");
            }
        }
    };
    client.send("query=" + encodeURIComponent(query));
}

// FUNCIÓN PARA MOSTRAR RESULTADOS EN LA TABLA
function mostrarProductos(productos) {
    let template = '';
    
    productos.forEach(producto => {
        let descripcion = `
            <li>Precio: ${producto.precio}</li>
            <li>Unidades: ${producto.unidades}</li>
            <li>Modelo: ${producto.modelo}</li>
            <li>Marca: ${producto.marca}</li>
            <li>Detalles: ${producto.detalles}</li>
        `;

        template += `
            <tr>
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td><ul>${descripcion}</ul></td>
            </tr>
        `;
    });

    document.getElementById("productos").innerHTML = template;
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    var productoJsonString = document.getElementById('description').value;
    var finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = document.getElementById('name').value;
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}
