const tblPendientes = document.querySelector('#tblPendientes');

document.addEventListener('DOMContentLoaded', function () {
    const tableLista = document.querySelector('#tableListaProductos tbody');
    if (tableLista) {
        getListaProductos(tableLista);
    }
    //Cargar datos pendientes con DataTables
    $('#tblPendientes').DataTable({
        ajax: {
            url: base_url + 'clientes/listarPendientes',
            dataSrc: ''
        },
        columns: [
            { data: 'id_transaccion' },
            {
                data: 'precio',
                render: function (data, type, row) {
                    // Convertir el precio de dólares a pesos colombianos
                    var precioEnPesos = parseFloat(data) * 4400;

                    // Devolver el precio formateado en pesos colombianos
                    return precioEnPesos.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
                }
            },
            { data: 'fechaCompra' },
            { data: 'accion' }
        ],
        language,
        dom,
        buttons
    });

});

function getListaProductos(tableLista) {
    const url = base_url + 'principal/listaProductos';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.setRequestHeader('Content-Type', 'application/json');
    http.send(JSON.stringify(listaCarrito));

    http.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let res;
                try {
                    res = JSON.parse(this.responseText);
                    if (res.totalPaypal > 0) {
                        if (Array.isArray(res.productos)) {
                            let html = '';
                            res.productos.forEach(producto => {
                                html += `<tr>
                                            <td>
                                                <img class="img-thumbnail rounded-circle" src="/tienda-virtual/ventas/archivos/procesos/${producto.imagen}" alt="" width="75">
                                            </td>
                                            <td>${producto.nombre}</td>
                                            <td>
                                                <span class="badge bg-success">${res.moneda + ' ' + producto.precio}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">${producto.cantidad}</span>
                                            </td>
                                            <td>${producto.subTotal}</td>
                                         </tr>`;
                            });
                            tableLista.innerHTML = html;
                            document.querySelector('#totalProducto').textContent = 'TOTAL A PAGAR: ' + res.moneda + ' ' + res.total;
                            // Llama a las funciones de botón de pago
                            botonPaypal(res.totalPaypal);
                        } else {
                            console.error('res.productos no es un array:', res.productos);
                        }
                    } else {
                        tableLista.innerHTML = `<tr>
                        <td colspan="5" class="text-center">NO HAY PRODUCTOS AGREGADOS</td>
                    </tr>`;
                        document.querySelector('#totalProducto').textContent = 'TOTAL A PAGAR: ' + res.moneda + ' 0';
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

function botonPaypal(totalCOP) {
    const resultMessageElement = document.getElementById('resultMessage');

    function resultMessage(message) {
        if (resultMessageElement) {
            resultMessageElement.innerHTML = message;
        } else {
            //console.error('Elemento con ID resultMessage no encontrado');
        }
    }

    const paypalContainer = document.getElementById('paypal-button-container');
    if (!paypalContainer) {
        console.error('Elemento con ID paypal-button-container no encontrado');
        return;
    }

    // Tasa de cambio de COP a USD
    const tasaCambio = 4400;

    // Conversión de COP a USD
    const totalUSD = (totalCOP / tasaCambio).toFixed(2);

    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalUSD
                    }
                }]
            }).then(function (orderId) {
                return orderId;
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (orderData) {
                registrarPedido(orderData);
                resultMessage(`Transacción completada por ${orderData.payer.name.given}`);

            });
        },
        onError: function (err) {
            resultMessage('Error en la transacción: ' + err.message);
            console.error(err);
        }
    }).render(paypalContainer);
}


function registrarPedido(datos) {
    const url = base_url + 'clientes/resgistrarPedido';
    const http = new XMLHttpRequest();
    http.open('POST', url, true);
    http.setRequestHeader('Content-Type', 'application/json');
    http.send(JSON.stringify({
        datos: datos,
        productos: listaCarrito
    }));

    http.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                Swal.fire('Aviso', res.msg, res.icono);
                if (res.icono == 'success') {
                    localStorage.removeItem('listaCarrito');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            }
        }
    };
}

function verPedido(idPedido) {
    // Inicializar el modal con el ID correspondiente
    const mPedido = new bootstrap.Modal(document.getElementById('modalPedido'));

    const url = base_url + 'clientes/verPedido/' + idPedido; // Asegúrate de que la URL sea correcta
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.setRequestHeader('Content-Type', 'application/json');
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.productos.forEach(row => {
                html += `<tr>
                            <td class="">${row.producto}</td>
                            <td>
                            <span class="badge bg-success">${res.moneda + ' ' + row.precio}</span></td>
                            <td><span class="badge bg-primary">${row.cantidad}</span></td>
                            <td class="">${parseFloat(row.precio) * parseInt(row.cantidad)}</td>
                         </tr>`;
            });

            // Rellenar la tabla
            const tableBody = document.querySelector('#tablaPedidos tbody');
            tableBody.innerHTML = html;

            // Destruir cualquier instancia previa de DataTable para evitar conflictos
            if ($.fn.dataTable.isDataTable('#tablaPedidos')) {
                $('#tablaPedidos').DataTable().destroy(); // Destruir la tabla anterior
            }

            // Mostrar el modal
            mPedido.show();

            // Evento para generar PDF
            document.getElementById('btnDescargarPDF').addEventListener('click', function () {
                generarPDF(res);
            });
        }
    };
}

// Función para generar el PDF
function generarPDF(res) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Nombre de la empresa centrado y grande
    doc.setFontSize(24);
    doc.text('National Liquor', doc.internal.pageSize.width / 2, 15, { align: 'center' });

    // Espaciado entre el nombre de la empresa y el resto del contenido
    doc.text('', 20, 25);  // Deja un espacio de 10 unidades

    // Línea de división debajo del nombre de la empresa
    doc.setLineWidth(0.5);
    doc.line(10, 28, doc.internal.pageSize.width - 10, 28);  // Línea horizontal debajo del nombre

    // Título del documento
    doc.setFontSize(16);
    doc.text('Detalles del Pedido', 20, 40);

    // Línea de división debajo del título
    doc.setLineWidth(0.5);
    doc.line(10, 45, doc.internal.pageSize.width - 10, 45); // Línea horizontal debajo del título

    // Cabeceras de la tabla
    const headers = [['Producto', 'Precio', 'Cantidad', 'Subtotal']];
    const productos = res.productos.map(row => [
        row.producto,
        res.moneda + ' ' + row.precio,
        row.cantidad,
        parseFloat(row.precio) * parseInt(row.cantidad)
    ]);

    // Dibujar la tabla con color de fondo amarillo y texto blanco en la cabecera
    doc.autoTable({
        head: headers,
        body: productos,
        startY: 50,  // Comienza más abajo para que haya más espacio
        margin: { horizontal: 10 },
        theme: 'grid',
        headStyles: {
            fillColor: [255, 204, 0],  // Color de fondo amarillo
            textColor: [255, 255, 255], // Color de texto blanco
            fontSize: 12,
            fontStyle: 'bold'
        },
        styles: {
            fontSize: 10,
            cellPadding: 4  // Aumenta el espacio entre celdas
        }
    });

    // Calcular el subtotal
    const subtotal = productos.reduce((acc, row) => acc + row[3], 0);

    // Agregar el subtotal al pie de página en negrita y con un tamaño de fuente más grande
    doc.setFontSize(16);
    doc.setFont('helvetica', 'bold');
    doc.text(`Subtotal: ${res.moneda} ${subtotal.toFixed(2)}`, 20, doc.internal.pageSize.height - 20);

    // Descargar el archivo PDF con el nombre "Reporte"
    doc.save('Reporte.pdf');
}




document.getElementById('efecty-button').onclick = function () {
    Swal.fire({
        icon: 'warning',
        title: 'Función Próximamente',
        text: 'Pronto añadiremos esta función.',
        confirmButtonText: 'Aceptar'
    });
};

document.getElementById('bancolombia-button').onclick = function () {
    Swal.fire({
        icon: 'warning',
        title: 'Función Próximamente',
        text: 'estamos trabajando para brindarte la mejor experiencia',
        confirmButtonText: 'Aceptar'
    });
};

document.getElementById('bbva-button').onclick = function () {
    Swal.fire({
        icon: 'warning',
        title: 'Función Próximamente',
        text: 'estamos trabajando para brindarte la mejor experiencia',
        confirmButtonText: 'Aceptar'
    });
};


