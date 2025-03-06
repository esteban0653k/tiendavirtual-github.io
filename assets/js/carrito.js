let listaDeseo = cargarLista('listaDeseo');
let listaCarrito = cargarLista('listaCarrito');
const btnAddCarrito = document.querySelectorAll('.btnAddCarrito');
const btnDesdeo = document.querySelector('#btnCantidadDesdeo'); // Aquí se captura el elemento
const btnCarrito = document.querySelector('#btnCantidadCarrito');
const verCarrito = document.querySelector('#verCarrito');
const tableListaCarrito = document.querySelector('#tableListaCarrito tbody');

// Ver carrito
const myModal = new bootstrap.Modal(document.getElementById('myModal'));

document.addEventListener('DOMContentLoaded', function () {
    // Verificar que el botón 'btnCantidadDesdeo' exista antes de asignarle el valor
    if (btnDesdeo) {
        const btnAddDeseo = document.querySelectorAll('.btnAddDeseo');
    
        btnAddDeseo.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault(); // Evita la recarga de la página
                let idProducto = this.getAttribute('prod');
                agregarDeseo(idProducto);
            });
        });
        
        btnAddCarrito.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault(); // Evita la recarga de la página
                let idProducto = this.getAttribute('prod');
                agregarCarrito(idProducto, 1);
            });
        });

        cantidadDeseo(); // Asegura que se actualice la cantidad al cargar

        cantidadCarrito(); // Asegura que se actualice la cantidad del carrito

        verCarrito.addEventListener('click', function () {
            getListaCarrito(tableListaCarrito); // Asegúrate de pasar la tabla correctamente
            myModal.show();
        });
    } else {
        console.error('El elemento #btnCantidadDesdeo no se encontró en el DOM');
    }
});

// Cargar lista desde localStorage
function cargarLista(key) {
    const lista = localStorage.getItem(key);
    return lista ? JSON.parse(lista) : [];
}

// Agrega a la lista de deseos
function agregarDeseo(idProducto) {
    if (!listaDeseo.some(item => item.idProducto == idProducto)) {
        listaDeseo.push({ "idProducto": idProducto, "cantidad": 1 });
        localStorage.setItem('listaDeseo', JSON.stringify(listaDeseo));
        Swal.fire({
            title: "Aviso",
            text: "PRODUCTO AGREGADO A LA LISTA DE DESEOS",
            icon: "success"
        });
    } else {
        Swal.fire({
            title: "Aviso",
            text: "EL PRODUCTO YA ESTA AGREGADO",
            icon: "warning"
        });
    }
    cantidadDeseo();
}

// Actualiza la cantidad de deseos
function cantidadDeseo() {
    let listas = cargarLista('listaDeseo');
    if (btnDesdeo) { // Verifica que btnDesdeo exista antes de actualizar el texto
        btnDesdeo.textContent = listas.length;
    }
}

// Agrega productos al carrito
function agregarCarrito(idProducto, cantidad) {
    if (!listaCarrito.some(item => item.idProducto == idProducto)) {
        listaCarrito.push({ "idProducto": idProducto, "cantidad": cantidad });
        localStorage.setItem('listaCarrito', JSON.stringify(listaCarrito));
        Swal.fire({
            title: "Aviso",
            text: "PRODUCTO AGREGADO AL CARRITO",
            icon: "success"
        });
    } else {
        Swal.fire({
            title: "Aviso",
            text: "EL PRODUCTO YA ESTA AGREGADO",
            icon: "warning"
        });
    }
    cantidadCarrito();
}

// Actualiza la cantidad en el carrito
function cantidadCarrito() {
    let listas = cargarLista('listaCarrito');
    if (btnCarrito) { // Verifica que btnCarrito exista antes de actualizar el texto
        btnCarrito.textContent = listas.length;
    }
}

// Ver carrito
function getListaCarrito(tableLista) {
    const url = base_url + 'principal/listaProductos';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.setRequestHeader('Content-Type', 'application/json');
    http.send(JSON.stringify(listaCarrito));

    http.onreadystatechange = function() {
        if (this.readyState === 4) { // Para depurar

            if (this.status === 200) {
                let res; // Declara res aquí
                try {
                    res = JSON.parse(this.responseText);
                    if (Array.isArray(res.productos)) {
                        let html = '';
                        res.productos.forEach(producto => {
                            html += `<tr>
                                        <td>
                                        <img class="img-thumbnail rounded-circle" src="/tienda-virtual/ventas/archivos/procesos/${producto.imagen}" alt="" width="75">
                                        </td>
                                        <td class="mondongo">${producto.nombre}</td>
                                        <td>
                                        <span class="badge bg-success">${res.moneda + ' ' + producto.precio}</span></td>
                                        <td><span class="badge bg-primary">${producto.cantidad}</span></td>
                                        <td class="mondongo">${producto.subTotal}</td>
                                        <td>
                                        <button class="btn btn-danger btnDeletecart" type="button" prod="${producto.id}"><i class="fas fa-times-circle"></i></button>
                                        </td>
                                     </tr>`;
                        });
                        tableLista.innerHTML = html;
                        document.querySelector('#totalGeneral').textContent = res.total;
                        btnEliminarCarrito();
                    } else {
                        console.error('res.productos no es un array:', res.productos);
                    }
                } catch (error) {
                    console.error('Error al parsear JSON:', error);
                }
            } else {
                console.error('Error en la respuesta del servidor:', this.status);
            }
        }
    };
}

// Eliminar del carrito
function btnEliminarCarrito() {
    let listaEliminar = document.querySelectorAll('.btnDeletecart');
    listaEliminar.forEach(btn => {
        btn.addEventListener('click', function() {
            let idProducto = btn.getAttribute('prod');
            eliminarListaCarrito(idProducto, btn.closest('tr')); // Obtener el <tr> más cercano
        });
    });
}

function eliminarListaCarrito(idProducto, elementoDOM) {
    listaCarrito = listaCarrito.filter(item => item.idProducto != idProducto);
    localStorage.setItem('listaCarrito', JSON.stringify(listaCarrito));
    
    // Eliminar el elemento del DOM
    elementoDOM.remove(); // Eliminar el <tr> correspondiente
    cantidadCarrito();
    Swal.fire({
        title: "Aviso",
        text: "PRODUCTO ELIMINADO DEL CARRO",
        icon: "success"
    });
    getListaCarrito(tableListaCarrito); // Actualiza la tabla del carrito
}
