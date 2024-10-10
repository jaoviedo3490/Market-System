/*$(document).ready(function () {
    let val = 0;
    if(val == 5){
        $(document).onbeforeunload(confirm('¿Esta seguro que desea abandonar la pagina actual? , Perdera todo su progreso actual'));
    } 
    $("#product-name").focus();
    $("#product-name").keyup(function (event) {
       let search = $("#product-name").val();
       alert(search);
        $.ajax({
            url: '../../capa-negocios/Ajax-Products/Extract-Products.php',
            method: 'post',
            success: function(response){
                alert(response);
                    const json = JSON.parse(JSON.stringify(response));
                    const str = json;
                    const new_str_json = JSON.parse(str);
                    Object.values(new_str_json).forEach(element_ =>{
                       $("#product-name").text(element_.nombre);
                    });
            }
        })
        if (event.which == 13) {
            let content_product = $("#product-name");
        if (content_product.val().length > 0) {
            val = 5;
            let products = new Array();
            

products.push(content_product);
            let $html_product = '<ul><table class="table table-hover"><tr><td class="col-sm-2">' + content_product.val() + '</td><td class="col-sm-2"><a id="price-product" style="margin-left:50%">' +
                '2000$</a></td><td class="col-sm-2"><img style="width:20%;heigth:20%;margin-left:15%;cursor:pointer;" onclick="delete_cashier()"' +
                ' src="../../resources/delete.png"/></td></tr></ul>';
            $("#list-product").append($html_product);
            content_product.val('');
            content_product.focus();
        } else swal({
            text: 'Para poder registrar un producto este debe digitarlo mediante codigo de barras o el nombre',
            button: 'Aceptar',
        })
        $("#content-content").html('');
        $("#bar-search").html('');
        }
    })
    $("#add-product").click(function () {
        let content_product = $("#product-name");
        if (content_product.val().length > 0) {
            val = 5;
            let $html_product = '<ul><table class="table table-hover"><tr><td class="col-sm-2">' + content_product.val() + '</td><td class="col-sm-2"><a id="price-product" style="margin-left:50%">' +
                '2000$</a></td><td class="col-sm-2"><img style="width:20%;heigth:20%;margin-left:15%;cursor:pointer;" onclick="delete_cashier()"' +
                ' src="../../resources/delete.png"/></td></tr></ul>';
            $("#list-product").append($html_product);
            let precio = 0;
            precio += parseInt($("#price-product").text());
            $("#total").html(precio);
            content_product.val('');
            content_product.focus();
        } else swal({
            text: 'Para poder registrar un producto este debe digitarlo mediante codigo de barras o el nombre',
            button: 'Aceptar',
        })

    })
    $("#content-content").html('');
    $("#bar-search").html('');
    $("#redirect-page").click(function(){
        return confirm('¿Desea abandonar la pagina actual? Perdera todo su progreso actual.')
    })
})
function delete_cashier() {
    swal({
        title: '¿Eliminar Producto?',
        text: 'Ingrese el codigo del supervisor para eliminar el producto,' +
            ' ATENCION !Todas sus unidades seran eliminadas¡',
        icon: 'warning',
        content: 'input',
        button: { text: 'Validar Codigo' },
    }).then((value) => {
        if (value == 'admin') {

        } else {
            swal('El producto no pudo ser eliminado', {
                title: '¡Codigo invalido!',
                icon: 'error'
            }
            )
        }
    })
}*/












$(document).ready(function () {
    let val = 0;

    // Mensaje de advertencia si intenta salir de la página
    if(val == 5){
        $(window).on('beforeunload', function() {
            return '¿Está seguro que desea abandonar la página actual? Perderá todo su progreso.';
        });
    }

    // Foco inicial en el input
    $("#product-name").focus();

    // Evento keyup para detectar escritura en el input
    $("#product-name").keyup(function (event) {
        let search = $("#product-name").val(); // Obtener el valor del input
        console.log(search);  // O usa alert(search) para depurar

        // Llamada AJAX
        $.ajax({
            url: '../../capa-negocios/Ajax-Products/Extract-Product-info.php',
            method: 'POST',
            data: {search},
            success: function(response) {
                alert(response);  // Mostrar respuesta para verificar
                const json = JSON.parse(response);  // Parsear JSON
                Object.values(json).forEach(element_ => {
                    $("#product-name").val(element_.nombre);  // Asignar valor al input correctamente
                });
            }
        });

        // Si se presiona Enter (código 13), agregar el producto
        if (event.which == 13) {
            let content_product = $("#product-name");
            if (content_product.val().length > 0) {
                val = 5;
                let products = [];
                products.push(content_product.val()); // Agregar producto

                let $html_product = `
                    <ul>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-sm-2">${content_product.val()}</td>
                                <td class="col-sm-2">
                                    <a class="price-product" style="margin-left:50%">2000$</a>
                                </td>
                                <td class="col-sm-2">
                                    <img style="width:20%;height:20%;margin-left:15%;cursor:pointer;" onclick="delete_cashier()" src="../../resources/delete.png"/>
                                </td>
                            </tr>
                        </table>
                    </ul>`;

                $("#list-product").append($html_product);
                content_product.val('');  // Limpiar el campo de entrada
                content_product.focus();  // Devolver el foco al input
            } else {
                swal({
                    text: 'Debe ingresar un nombre o código de barras para registrar un producto.',
                    button: 'Aceptar'
                });
            }
        }
    });

    // Botón para agregar producto manualmente
    $("#add-product").click(function () {
        let content_product = $("#product-name");
        if (content_product.val().length > 0) {
            val = 5;
            let $html_product = `
                <ul>
                    <table class="table table-hover">
                        <tr>
                            <td class="col-sm-2">${content_product.val()}</td>
                            <td class="col-sm-2">
                                <a class="price-product" style="margin-left:50%">2000$</a>
                            </td>
                            <td class="col-sm-2">
                                <img style="width:20%;height:20%;margin-left:15%;cursor:pointer;" onclick="delete_cashier()" src="../../resources/delete.png"/>
                            </td>
                        </tr>
                    </table>
                </ul>`;

            $("#list-product").append($html_product);

            // Actualizar el total del precio sumando los productos
            let precioTotal = 0;
            $(".price-product").each(function() {
                let precio = parseInt($(this).text().replace('$', ''));
                precioTotal += precio;
            });
            $("#total").html(precioTotal + '$');  // Actualiza el total

            content_product.val('');  // Limpiar el input
            content_product.focus();  // Devolver el foco al input
        } else {
            swal({
                text: 'Debe ingresar un nombre o código de barras para registrar un producto.',
                button: 'Aceptar'
            });
        }
    });

    // Confirmar antes de abandonar la página
    $("#redirect-page").click(function(){
        return confirm('¿Desea abandonar la página actual? Perderá todo su progreso.');
    });
});

// Función para eliminar un producto
function delete_cashier() {
    swal({
        title: '¿Eliminar Producto?',
        text: 'Ingrese el código del supervisor para eliminar el producto. ¡Atención! Todas las unidades serán eliminadas.',
        icon: 'warning',
        content: 'input',
        button: { text: 'Validar Código' }
    }).then((value) => {
        if (value === 'admin') {
            // Lógica para eliminar el producto
        } else {
            swal('El producto no pudo ser eliminado', {
                title: '¡Código inválido!',
                icon: 'error'
            });
        }
    });
}
