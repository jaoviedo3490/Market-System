
$(document).ready(function () {
    function main_menu() {
        $("#c").html("<div class='container-fluid' style='width:60%;'>"
            + "<h4>Crear Nuevo Producto</h4>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "<form method='POST' id='form-main'>"
            + "<div class='container'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "Nombre del Producto"
            + "<input class='form-control' id='Nombre-Producto' type='text'>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "<div class='container'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "Referencia del Producto"
            + "<input class='form-control' id='Referencia-Producto' type='text'>"
            + "</div>"
            + "</div>"
            + "</div><div class='container'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "Precio del Producto"
            + "<input class='form-control' id='Precio-Producto' type='number'>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "<div class='container'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "Stock del Producto"
            + "<input class='form-control'  id='stock-producto' type='number'>"
            + "</div>"
            + "<div class='container'>"
            + "<div class='row'>"
            + "<div  class='col'>"
            + "Categoria del Producto"
            + "<select  name='opciones' id='categoria' class='form-control' style='width:100%'>"
            + "<option selected='' hidden>Escoje la Categoria</option>"
            + "<option value='Limpieza Personal' id='new-product'>Productos de Aseo Personal</option>"
            + "<option value='Limpieza Hogar' id='update-product'>Productos de Limpieza del Hogar</option>"
            + "<option value='Granel' id='search'>Productos a Granel</option>"
            + "<option value='Fruver' id='search'>Productos Fruver</option>"
            + "<option value='Carnicos' id='search'>Productos Carnicos</option>"
            + "<option value='Lacteos' id='search'>Productos Lacteos</option>"
            + "<option value='Alimentos para Animales' id='search'>Alimentos para Animales</option>"
            + "<option value='Confituras' id='search'>Dulces y Confituras</option>"
            + "</select>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "<div class='container' hidden>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "Productos Vendidos"
            + "<input class='form-control' value='crear-producto' type='text'>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "<div class='container'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "<br>"
            + "<href='#' id='prueba' class='btn btn-outline-primary' style='width:100%;'>Crear Producto</a>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</form>"
            + "</div><div class='col'>"
            + "<div class='container-fluid'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "<p>Seleccionar Imagen<p><img width='60%' id='folder-image' src='../../resources/default_folder_opened_icon_130770.png' class='img-fluid' alt='non-image-empty'>"
            + "<div class='container'>"
            + "<div class='row'>"
            + "<div class='col'>"
            + "<form id='form-image' method='POST' enctype='multipart/form-data'><input type='file' accept='image/jpeg' id='image' class='form-control'  style='width:100%;' id='imagen'></form>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>"
            + "</div>");
    }


    $("#opciones").on("change", function () {
        var selectedOptions = $("#options").val();
        if (selectedOptions == "Crear-Producto") {
            main_menu();


            $("#widget-prod").remove();
            $("#bar-search").html('');
            $("#content-content").html('');

        } else if (selectedOptions == 'Editar/Eliminar-Products') {

            $("#options option:contains('Editar/Eliminar Producto')").prop("selected", true);
            $("#update-product").prop("selected", true);
            //lert('./'+directoryName+'/capa-negocios/Ajax-Products/Extract-products.php');

            let trigger = "active";
            try {
                let data = {
                    url: "http://localhost/Market-System/capa-negocios/Ajax-Products/Extract-products.php",
                    method: "POST",
                    data: { 'trigger': trigger },
                    type: "json",
                    Content: "application/x-www-form-urlencoded; charset=UTF-8",
                }
                GenericAjax(data, responseExtract_Products);
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: `Error: ${error}`,
                    icon: 'Error',
                    confirmButtonText: 'Aceptar'
                })

            }
            $("#busqueda").keypress(function (event) {

                if (event.keyCode == 32) {

                    $("#busqueda").keyup(function () {

                        let search = $("#busqueda").val();
                        if (search == '') {
                            alert("Aqui 1")
                            searchProduct(search, true);

                        } else {
                            searchProduct(search);
                        }
                    });
                } else {

                    $("#busqueda").keyup(function () {
                        let search = $("#busqueda").val();

                        if (search == '') {
                            alert("aqui 2")
                            searchProduct(search, true);

                        } else {
                            searchProduct(search);
                        }
                    });

                }
            })
        } else if ($("#options").val() == "Buscar palabra clave") {
            if (trigger_cashier == 15) {
                $("#options").text('selected');
                return confirm('¿Esta seguro que desea abandonar la pagina actual?, perdera todo el progreso actual.');

            }
        }
        $("#prueba").click(function () {
            if ($("#Nombre-Producto").val().length == 0 || $("#Referencia-Producto").val().length == 0
                || $("#stock-producto").val().length == 0) {
                Swal.fire({
                    title: 'Campos Vacios',
                    text: 'Error: Los campos no pueden estar vacios',
                    icon: 'Error',
                    confirmButtonText: 'Aceptar'
                })

            } else {

                let Nombre = $("#Nombre-Producto").val();
                let Referencia = $("#Referencia-Producto").val();
                let Stock = $("#stock-producto").val();
                let Precio = $("#Precio-Producto").val();
                let Categoria = $("#categoria").val();

                $.ajax({
                    url: "../../capa-negocios/Ajax-Products/Create-Product_ajax.php",
                    method: 'post',
                    data: {
                        "Nombre": Nombre,
                        "Referencia": Referencia,
                        "Stock": Stock,
                        "Precio": Precio,
                        "Categoria": Categoria
                    },
                    cache: false,
                    success: function (response) {
                        Swal.fire({
                            title: 'Producto Creado',
                            text: 'El producto se ha creado Exitosamente',
                            icon: 'Success',
                            confirmButtonText: 'Aceptar'
                        })

                        $("#Nombre-Producto").val('');
                        $("#Referencia-Producto").val('');
                        $("#stock-producto").val('');
                        $("#Precio-Producto").val('');
                        $("#categoria").val('');
                    }, error: function (response) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error: ' + response,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }

        });
    });
    $("#caja").click(function () {
        location.href = '../cash-process/main_cash.html';
    })

});

export const searchProduct = (search, clear = false) => {
    debugger;
    let data = {
        url: '../../capa-negocios/Ajax-Products/Extract-product-info.php',
        method: "POST",
        data: { search },
        type: "json",
        Content: "application/x-www-form-urlencoded; charset=UTF-8",
        isClear: clear
    }
    GenericAjax(data, responseSearch);
}

export const responseSearch = (response) => {
    debugger;
    console.log(response);
    switch (response.Producto.length) {
        case 0: debugger; break;
        default:
            try {
                debugger;

                if (response.responseText.isClear == null || response.responseText.isClear == undefined) {
                    console.log(response.Producto[0].ID)
                    for (let i = 0; i < response.Producto.length; i++) {
                        debugger;
                        $("#tabla").html(`<td class='col-sm-2'>${(response.Producto[0].ID)}</td>
                             <td class='col-sm-2'>${(response.Producto[0].Nombre)} </td>
                                <td class='col-sm-2'>${(response.Producto[0].Categoria)}</td>
                                <td><a style='margin-right:5%;' href='#' id='Edit-Product'><img style='width:20%;heigth:20%;' src='../../resources/editar.png'/></a>
                                <a style='margin-right:5%;' href='#' id='Delete'><img style='width:20%;heigth:20%;' onclick='delete_prod(${(response.Producto[0].ID)})' src='../../resources/delete.png'/></a>
                                </td>`);

                    }
                } else if (response.responseText.isClear != null && response.responseText.isClear != undefined) {
                    if (!response.responseText.isClear) {
                        console.log(response.Producto[0].ID)
                        for (let i = 0; i < response.Producto.length; i++) {
                            debugger;
                            $("#tabla").html(`<td class='col-sm-2 table-dark'>${(response.Producto[0].ID)}</td>
                             <td class='col-sm-2 table-dark'>${(response.Producto[0].Nombre)} </td>
                                <td class='col-sm-2 table-dark'>${(response.Producto[0].Categoria)}</td>
                                <td><a style='margin-right:5%;' href='#' id='Edit-Product'><img style='width:20%;heigth:20%;' src='../../resources/editar.png'/></a>
                                <a style='margin-right:5%;' href='#' id='Delete'><img style='width:20%;heigth:20%;' onclick='delete_prod(${(response.Producto[0].ID)})' src='../../resources/delete.png'/></a>
                                </td>`);

                        }
                    } else {
                        console.log(response.Producto[0].ID)
                        for (let i = 0; i < response.Producto.length; i++) {
                            debugger;
                            $("#tabla").html(`<td class='col-sm-2'>${(response.Producto[0].ID)}</td>
                             <td class='col-sm-2'>${(response.Producto[0].Nombre)} </td>
                                <td class='col-sm-2'>${(response.Producto[0].Categoria)}</td>
                                <td><a style='margin-right:5%;' href='#' id='Edit-Product'><img style='width:20%;heigth:20%;' src='../../resources/editar.png'/></a>
                                <a style='margin-right:5%;' href='#' id='Delete'><img style='width:20%;heigth:20%;' onclick='delete_prod(${(response.Producto[0].ID)})' src='../../resources/delete.png'/></a>
                                </td>`);

                        }
                    }
                }
            } catch (error) {
                debugger;
                console.log(`${error} |  ${response}`)
                const claves = Object.keys(response);
                for (let i of claves) {
                    console.log(response[claves]);
                }
                Swal.fire({
                    title: 'Error',
                    text: `Error: ${response.resposeText}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
            break;
    }
}


export const responseExtract_Products = (response) => {
    console.log(response)
    debugger;
    try {
        switch (response.StatusCode) {
            case 200:
                debugger;
                let arreglo = Object.keys(response);
                //alert(arreglo);

                location = 'http://localhost/Market-System/capa-presentacion/index/main_productos.php';
                for (let i = 0; i < arreglo.length; i++) {

                    $("#tabla").html(`<td>${arreglo[0]}</td>`
                        + `<td>${arreglo[1]}</td>`
                        + `<td>${arreglo[1]}</td>`
                        + "<td><style='margin-right:5%;' href='#' id='Edit-Product'><img src='../../resources/editar.png'/></a>"
                        + "</td><td><img src='../../resources/delete.png' style='margin-left:5%;' id='delete-prod'/>"
                        + "</td>");
                }
                break;
            case 400:
                Swal.fire({
                    title: 'Importante',
                    text: response.Message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 500:
                Swal.fire({
                    title: 'Importante',
                    text: response.Message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            default:
                Swal.fire({
                    title: 'Respuesta Incorrecta',
                    text: `Error en la respuesta del servidor - Codigo de Error: ${response.StatusCode}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
        }
    } catch (error) {

        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}



export const loadProducts = (url) => {
    try {
        debugger;
        let trigger = 'active';
        let data = {
            url: url,
            method: "POST",
            data: { 'trigger': trigger },
            type: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
        }
        GenericAjax(data, responseLoad_Productos);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        })
    }
}
export const responseLoad_Productos = (response) => {
    try {
        let jquery = "<br><br><table class='table table-bordered table-hover'>" +
            "<thead>" +
            "<tr class='table-active'>" +
            "<th class='col-sm-2'>ID</th>" +
            "<th class='col-sm-2'>Nombre</th>" +
            "<th class='col-sm-2'>Categorias</th>" +
            "<th class='col-sm-2'>Acciones</th>" +
            "</tr>" +
            "</thead>" +
            "<tbody>";

        console.log(response);
     
        for (let clave in response.Productos) {
            debugger;
            jquery += "<tr id='tabla'>";
            jquery += `<td class='col-sm-2'>${response.Productos[clave].ID}</td>`;
            jquery += `<td class='col-sm-2'>${response.Productos[clave].Nombre}</td>`;
            jquery += `<td class='col-sm-2'>${response.Productos[clave].Categoria}</td>`;
            jquery += `<td class='col-sm-2' data-value=' ${response.Productos[clave].ID}'>` +
                "<a style='margin-right:5px;'><img style='width:20%; onClick='edit_product()' height:20%;' src='../../resources/editar.png'/></a>" +
                `<img style='width:20%; height:20%;' id='delete-prod' onClick='delete_prod( ${response.Productos[clave].ID})' src='../../resources/delete.png'/></td>`;
            jquery += "</tr>";
        }

        jquery += "</tbody></table>";
        $("#content-content").html(jquery);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        })
    }
}

export const delete_prod = (id) => {

    try {
        Swal.fire({
            title: "¿Desea eliminar este producto?",
            text: "Toda la información con relación a este producto será eliminada. ¿Desea continuar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'No, cancelar',
            dangerMode: true
        }).then((result) => {
            if (result.isConfirmed) {
                let data = {
                    url: "http://localhost/Market-System/capa-negocios/Ajax-Products/ajax_Actions/delete_product.php",
                    method: "POST",
                    data: { id },
                    type: "json",
                    Content: "application/x-www-form-urlencoded; charset=UTF-8",
                }
                GenericAjax(data, responseDelete);
            }
        });

    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}
export const responseDelete = (response) => {
    let trigger = 1;
    try {
        switch (response.StatusCode) {
            case 200:
                Swal.fire({
                    title: "Producto Eliminado",
                    text: "El producto ha sido eliminado exitosamente.",
                    icon: "success",
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    loadProducts("http://localhost/Market-System/capa-negocios/Ajax-Products/Extract-products.php");
                });
                break;
            case 400:
                Swal.fire({
                    title: "Importante",
                    text: `Se ha recibido una respuesta erronea -  ${response.Message}`,
                    icon: "warning",
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 500:
                Swal.fire({
                    title: "Importante",
                    text: `Error interno del servidor - ${response.Message}`,
                    icon: "error",
                    confirmButtonText: 'Aceptar'
                });
                break;
            default:
                Swal.fire({
                    title: "Importante",
                    text: `Opcion no encontrada -  ${response.Message}`,
                    icon: "info",
                    confirmButtonText: 'Aceptar'
                });
                break;
        }
    } catch (error) {

        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        })

    }
}
export const loadCategories = (active) => {
    $.ajax({
        url: "http://localhost/Market-System/capa-negocios/Ajax-Products/Extract-Category.php",
        method: 'post',
        data: active,
        dataType: 'json',
        success: function (response) {
            Swal.fire({
                title: 'Importante',
                text: "Me presento soy la mera v3rga",
                icon: 'info',
                confirmButtonText: 'Aceptar'
            })
        },
        error: function (response) {
            Swal.fire({
                title: 'Importante - Error',
                text: `Error: ${response.responseText}`,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            })
        }

    })
}

export const sesion2 = (Object) => {
    //alert(Object.pageRedirect);
    if (Object.pageRedirect != undefined || Object.pageRedirect != null) {
        debugger;
        let dato = {
            url: "http://localhost/Market-System/capa-negocios/Ajax-User/Init-sesion.php",
            method: "POST",
            data: { nombre: Object.nombre, contraseña: Object.contraseña },
            type: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
            pageRedirect: true
        }
        GenericAjax(dato, responseServer);
    } else {
        debugger;
        let dato = {
            url: "http://localhost/Market-System/capa-negocios/Ajax-User/Init-sesion.php",
            method: "POST",
            data: { nombre: Object.nombre, contraseña: Object.contraseña },
            type: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8"
        }
        GenericAjax(dato, responseServer);
    }

}


export const StatusCodeClass = (response) => {
    console.log(response);
    switch (response.StatusCode) {
        case 200:
            window.location.href = response.RedirectURL;
            break;
        case 400:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'info',
                confirmButtonText: 'Aceptar'
            })
            break;
        case 401:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'info',
                confirmButtonText: 'Aceptar'
            })
            break;
        case 403: Swal.fire({
            title: 'Importante',
            text: response.Message,
            icon: 'info',
            confirmButtonText: 'Aceptar'
        })
            break;
        case 404: Swal.fire({
            title: 'Importante',
            text: response.Message,
            icon: 'info',
            confirmButtonText: 'Aceptar'
        })
            break;
        case 500:
            //alert()
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'info',
                confirmButtonText: 'Aceptar'
            })
            break;
        case 501:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'info',
                confirmButtonText: 'Aceptar'
            })
            break;
        default:
            Swal.fire({
                title: 'Respuesta Incorrecta',
                text: `Error en la respuesta del servidor - Codigo de Error:  ${response.StatusCode}`,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            })
            break;
    }
}

export const responseServer = (response) => {
    //console.log(`deberia ser true: ${response.responseText.pageRedirect}`);
    debugger;
    switch (response.StatusCode) {
        case 200:
            let data = {
                url: "http://localhost/Market-System/capa-presentacion/Index/User-Route.php",
                method: "POST",
                data: "",
                type: "json",
                content: "application/x-www-form-urlencoded; charset=UTF-8",
            }
            GenericAjax(data, StatusCodeClass);
            break;
        case 400:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        case 404:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then(isConfirmed => {
                //console.log(response.pageRedirect);
                if (isConfirmed && (response.responseText.pageRedirect != undefined
                    || response.responseText.pageRedirect != null)) {
                    RenewCrentials();
                }
            });
            break;
        case 500:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            break;
        case 401:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then(isConfirmed => {
                if (isConfirmed && (response.responseText.pageRedirect != undefined
                    || response.responseText.pageRedirect != null)) {
                    RenewCrentials();
                }
            });
            break;
        default:
            Swal.fire({
                title: 'Importante',
                text: response.Message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            break;
    }
}
export const GenericAjax = (data, successCallBack = null) => {
    debugger;
    $.ajax({
        url: data.url,
        method: data.method,
        data: data.data || null,
        contentType: data.Content || "application/json; charset=utf-8",
        dataType: data.type || 'json',
        success: function (response) {

            if (typeof successCallBack === "function") {

                if (data.pageRedirect != undefined && data.pageRedirect != null) {
                    //(response)
                    response.responseText = data;
                    successCallBack(response);
                } else if (data.isClear != undefined && data.isClear != null) {
                    response.responseText = data;
                    successCallBack(response);

                } else {
                    successCallBack(response);
                }
            }
        },

        error: function (response) {
            debugger;
            console.log(response);
            Swal.fire({
                title: 'Importante - Error',
                text: `Error: ${response.responseText}`,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            })
        }
    });
}

export const RenewCrentials = () => {
    // Mostrar/ocultar la contraseña


    swal.fire({
        title: "Renovar Creedenciales",
        html: '<div class="form-group">' +
            +'<label class="form-label-input">Nombre</label>'
            + '<input class="form-control" type="text" id="nombre_" name="nombre" required>'
            + '<input type="hidden" value="INIT-SESION" name="oculto">'
            + '</div>'
            + '<div class="form-group">'
            + '<label class="form-label-input">Contraseña</label>'
            + '<input class="form-control" type="password" id="contraseña_" name="contraseña" required>'
            + '</div>'

            + '<div class="form-group">'
            + '<input class="form-check-input" type="checkbox" id="pass_">'
            + ' <label class="form-label-input">Mostrar Contraseña</label>'
            + '</div></div><script>' +
            '$("#pass_").click(function () {' +
            'let v = $("#pass_").is(":checked");' +
            '$("#contraseña").attr("type", v ? "text" : "password");' +
            '});</script>',
        showCancelButton: true,
        confirmButtonText: 'Ok',
        cancelButtonText: 'Salir e Iniciar sesion Nuevamente',
        focusConfirm: false,
        preConfirm: () => {
            let nombre = document.getElementById("nombre_").value;
            console.log(nombre);
            let contraseña = document.getElementById("contraseña_").value;
            console.log(nombre);

            if (!nombre || !contraseña) {
                Swal.showValidationMessage("Por favor complete los campos para poder continuar");
                return false;
            } else {
                let InitObject = {
                    nombre: nombre,
                    contraseña: contraseña,
                    pageRedirect: true
                }
                sesion2(InitObject);
            };
        }
    }).then((result => {
        if (result.isConfirmed) {
            console.log(result.value);
        } else {
            let delete_session = 1;
            let data = {
                pageRedirect: true,
                url: 'http://localhost/Market-System/capa-negocios/closed_session.php',
                method: "POST",
                data: { 'delete': delete_session },
                type: "json",
                Content: "application/x-www-form-urlencoded; charset=UTF-8",
            }
            GenericAjax(data, responseClosed_session);
        }
    }));
    $("#pass_").click(function () {
        let v = $("#pass_").is(':checked');
        $("#contraseña").attr('type', v ? 'text' : 'password');
    });
}

export function responseClosed_session(response) {
    debugger;
    try {
        switch (response.StatusCode) {
            case 200:
                location.href = 'http://localhost/Market-System/index.php';
                break;
            case 500:
                Swal.fire({
                    title: 'Importante',
                    text: `Error en la respuesta del servidor - Codigo de Error:  ${response.StatusCode}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            default:
                Swal.fire({
                    title: 'Respuesta Incorrecta',
                    text: `Error en la respuesta del servidor - Codigo de Error: ${response.StatusCode}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
        }
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

export const closed_session = () => {
    try {
        debugger;
        let data = {
            url: "http://localhost/Market-System/capa-negocios/closed_session.php",
            method: "POST",
            data: { 'delete': 2 },
            type: "json",
            content: "application/x-www-form-urlencoded; charset=UTF-8",
        }
        GenericAjax(data, responseClosed_session);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

export const edit_product = (id) => {
    const edit = new Edit_Product();
    edit.setCustomContent("Editar Producto");
}



export const to_User_Route = () => {
    try {
        let data = {
            url: "http://localhost/Market-System/capa-presentacion/Index/User-Route.php",
            method: "POST",
            data: "",
            type: "json",
            content: "application/x-www-form-urlencoded; charset=UTF-8",
        }
        GenericAjax(data, StatusCodeClass);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}
window.delete_prod = delete_prod;
window.loadProducts = loadProducts;
window.loadCategories = loadCategories;
window.GenericAjax = GenericAjax;
window.responseServer = responseServer;
window.StatusCodeClass = StatusCodeClass;
window.responseExtract_Products = responseExtract_Products
window.responseDelete = responseDelete;
window.responseLoad_Productos = responseLoad_Productos;
window.RenewCrentials = RenewCrentials;
window.responseClosed_session = responseClosed_session;
window.closed_session = closed_session;
window.searchProduct = searchProduct;
window.responseSearch = responseSearch;
window.edit_product = edit_product;
window.to_User_Route = to_User_Route;

