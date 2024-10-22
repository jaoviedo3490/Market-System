
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
                    title: 'Excepcion encontrada',
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
                            //alert("Aqui 1")
                            searchProduct(search, true);

                        } else {
                            searchProduct(search);
                        }
                    });
                } else {

                    $("#busqueda").keyup(function () {
                        let search = $("#busqueda").val();

                        if (search == '') {
                            //("aqui 2")
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
        location.href = '../../../cash-process/main_cash.html';
    })

});

window.MyApp = Window.MyApp || {}



export const searchProduct = (search, clear = false, origin = 1) => {
    debugger;
    let data = {
        url: '../../capa-negocios/Ajax-Products/Extract-product-info.php',
        method: "POST",
        data: { search },
        type: "json",
        Content: "application/x-www-form-urlencoded; charset=UTF-8",
        isClear: clear,
        origin: origin
    }
    GenericAjax(data, responseSearch);
}

export const responseSearch = (response) => {
    debugger;
    console.log(response);
    switch (response.Producto.length) {
        case 0:
            debugger; break;
        default:
            let json = JSON.stringify(response);
            let html;
            if (response.origin !== '' && response.origin !== 1) {
                try {
                    for (let i = 0; i < response.Producto.length; i++) {
                        const Producto = response.Producto[i];
                        debugger;
                        html += `<a href='#' class='dropdown-item' style='padding-right:20%' onClick='on_click_cash(${JSON.stringify(Producto)})' 
                            id='${Producto.Nombre}_${Producto.ID}'>${Producto.Nombre}</a>`;
                    }
                    //alert(response.respuesta);
                    let action = (response.respuesta !== ' ' && response.respuesta !== '') ? $("#ajax-items").html(html).show()
                        : $("#ajax-items").html(html).hide();

                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: `Error ${error}`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }

            } else {
                try {
                    debugger;

                    if (response.responseText.isClear == null || response.responseText.isClear == undefined) {
                        console.log(response.Producto[0].ID)
                        for (let i = 0; i < response.Producto.length; i++) {
                            debugger;
                            $("#tabla").html(`<td class='col-sm-2'>${(response.Producto[0].ID)}</td>
                                 <td class='col-sm-2'>${(response.Producto[0].Nombre)} </td>
                                    <td class='col-sm-2'>${(response.Producto[0].Categoria)}</td>
                                    <td><a style='margin-right:5%;' href='#' id='Edit-Product' onClick = 'Extract_product_info(${(response.Producto[0].ID)})' ><img style='width:20%;heigth:20%;' src='../../resources/editar.png'/></a>
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
                                    <td><a style='margin-right:5%;' href='#' id='Edit-Product' onClick = 'Extract_product_info(${(response.Producto[0].ID)})' ><img style='width:20%;heigth:20%;' src='../../resources/editar.png'/></a>
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
                                    <td><a style='margin-right:5%;' href='#' id='Edit-Product' onClick = 'Extract_product_info(${(response.Producto[0].ID)})'><img style='width:20%;heigth:20%;' src='../../resources/editar.png'/></a>
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
            }

            break;
    }
}


export const responseExtract_Products = (response) => {
    //console.log("nose weon "+JSON.stringify(response))

    try {
        switch (response.StatusCode) {
            case 200:
                debugger;
                let arreglo = Object.keys(response);
                //alert(JSON.stringify(arreglo));
                //alert(response.Productos[0]);


                arreglo.forEach((elemento, i) => {
                    //alert(response.Productos[i]);
                    $("#tabla").html(`<td>${elemento}</td>`
                        + `<td>${elemento}</td>`
                        + `<td>${elemento}</td>`
                        + `<td><style='margin-right:5%;' href='#' id='Edit-Product' onClick = 'Extract_product_info(${(response.Productos[i])})'><img src='../../resources/editar.png'/></a>`
                        + "</td><td><img src='../../resources/delete.png' style='margin-left:5%;' id='delete-prod'/>"
                        + "</td>");
                })
                location = 'http://localhost/Market-System/capa-presentacion/index/main_productos.php';
                break;
            case 400:
            case 404: location = 'http://localhost/Market-System/capa-presentacion/index/main_productos.php'; break

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
        debugger;
        alert(response + " | " + error);
        Swal.fire({
            title: 'Excepcion encontrada 1',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}



export const loadProducts = (url) => {
    try {
        //debugger;
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
            //debugger;
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
        // debugger;
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
        //debugger;
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
    //debugger;
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
        contentType: data.Content || "application/x-www-form-urlencoded; UTF-8",
        dataType: data.type || 'json',
        success: function (response) {

            if (typeof successCallBack === "function") {
                debugger;
                console.log("Desde genericAjax:" + data);
                if (data.pageRedirect != undefined && data.pageRedirect != null) {
                    response.responseText = data;
                    successCallBack(response);
                } else if (data.isClear != undefined && data.isClear != null) {
                    response.responseText = data;
                    successCallBack(response);

                } else if (data.dataPage != undefined && data.dataPage != null) {
                    debugger;
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
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
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

export const edit_product = (response) => {
    let object = {}
    object = response[0];
    //debugger;
    try {
        const edit = new Edit_Product(object);
        edit.openModal(object);
        //edit.closeModal();
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }

}



export const to_User_Route = () => {
    try {
        let data = {
            url: "http://localhost/Market-System/capa-presentacion/Index/User-Route.php",
            method: "POST",
            data: "",
            type: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
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
export const Extract_product_info = (id, page = 1) => {
    debugger;
    try {
        let data = {
            url: "http://localhost/Market-System/capa-negocios/Ajax-Products/Extract-all-product-info.php",
            method: "POST",
            data: { Producto: id },
            dataType: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
            dataPage: page
        }
        console.log(data);
        debugger;
        GenericAjax(data, Extract_Response);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

export const Extract_Response = (response) => {
    debugger;

    try {
        console.log(response);
        switch (response.StatusCode) {
            case 200:
                //  debugger;
                console.log(response.Producto);
                switch (response.responseText.dataPage) {
                    case 1: edit_product(response.Producto); break;
                    default: Print_Unit_Product(response.Producto); break;
                }

                break;
            case 400:
                Swal.fire({
                    title: 'Importante',
                    text: `Respuesta del servidor no valida: ${response.StatusCode}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 404:
                Swal.fire({
                    title: 'Importante',
                    text: `No se encontraron productos: ${response.StatusCode}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 500:
                Swal.fire({
                    title: 'Importante',
                    text: `Problema interno del Servidor: ${response.StatusCode}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            default:
                Swal.fire({
                    title: 'Error',
                    text: `Error al clasificar el codigo de estado: ${response.StatusCode}`,
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


export const Extract_Suspended_Accounts = () => {
    debugger;
    try {
        let data = {
            url: "http://localhost/Market-System/capa-negocios/Ajax-Products/ajax_actions/user_actions/Extract-Accounts.php",
            method: "POST",
            data: { Estado: 'Suspendida' },
            dataType: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
        }

        GenericAjax(data, Response_Suspended_Accounts);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

export const Response_Suspended_Accounts = (response) => {
    debugger;
    try {
        switch (response.StatusCode) {
            case 200:
                console.log(response.Cuentas.length);
                let html = "";
                if (response.Cuentas.length < 1) {
                    html = '<br><h3 class="display-3" style="text-align:center">Sin cuentas suspendidas</h3>';
                    $("#table---").html(html);
                } else {
                    html += `<table id='tb' class='table table-striped table-bordered'>
                                <tr>
                                    <td>ID</td>
                                    <td>Nombre</td>
                                    <td>Privilegios</td>
                                    <td>Estado</td>
                                    <td>Acciónes</td>
                                </tr>`;

                    for (let i = 0; i < response.Cuentas.length; i++) {
                        html += `<tr>`;

                        // Rellenar las celdas con la información de cada cuenta
                        for (const key of Object.keys(response.Cuentas[i])) {
                            html += `<td ud='id_'>${response.Cuentas[i][key]}</td>`;
                        }

                        const accountId = response.Cuentas[i].ID; // Usar el ID correcto para cada cuenta
                        html += `<td>
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" onClick="Activation_Account(${accountId})" role="switch" id="flexSwitchCheckSuspended_${accountId}">
                                            <label class="form-check-label" for="flexSwitchCheckSuspended_${accountId}">Reactivar</label>
                                        </div>
                                    </div>
                                </td>
                                <td id="id_user" hidden>${accountId}</td>
                            </tr>`;
                    }
                    html += "</table>";
                    $("#table---").html(html);
                }
                break;
            case 400:
                alert('Nonas mi rey respuesta incorrecta');
                break;
            case 404:
                alert('Nonas mi rey No se encontraron cuentas suspendidas');
                break;
            case 500:
                alert('Nonas mi rey Error interno del servidor');
                break;
            default:
                Swal.fire({
                    title: 'Importante - Error',
                    text: `: ${error}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
        }
    } catch (error) {

    }
};





export const Activation_Account = (id) => {
    const Switch = document.getElementById(`flexSwitchCheckSuspended_${id}`);
    //alert(Switch);
    Swal.fire({
        title: 'Importante',
        text: `¿Desea Activar la cuenta selecconada? , puede volver a suspender la cuenta en la pestaña cuentas Activas`,
        icon: 'info',
        confirmButtonText: 'Si, Activar',
        showCancelButton: "Cancelar"
    }).then((result) => {
        Switch.disabled = false;
        if (result.isConfirmed) {
            debugger;

            try {
                let data = {
                    url: "http://localhost/Market-System/capa-negocios/Ajax-User/Active-user.php",
                    method: "POST",
                    data: { Active: id },
                    dataType: 'json',
                    Content: "application/x-www-form-urlencoded; charset=UTF-8"
                }
                GenericAjax(data, Response_Activation_Account);
            } catch (error) {
                Swal.fire({
                    title: 'Excepcion encontrada',
                    text: `Codigo de Error: ${error}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        } else {
            Switch.checked = false;
        }
    })
}

export const Response_Activation_Account = (response) => {
    debugger;
    console.log(response);
    try {
        switch (response.StatusCode) {
            case 200:
                Swal.fire({
                    title: 'Importante',
                    text: `Cuenta Activada , revisa la cuenta en la pestaña Cuentas suspendidas`,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(function () {
                    Extract_Suspended_Accounts();
                    window.location.reload(true);

                    Extract_Active_Accounts();
                    window.location.reload(true);

                });
                break;
            case 400:
                Swal.fire({
                    title: 'Importante',
                    text: `El servidor respondio erroneamente`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 404:
                Swal.fire({
                    title: 'Importante',
                    text: `Usuario no encontrado!`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 500:
                Swal.fire({
                    title: 'Importante',
                    text: `Error interno del servidor`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            default:
                Swal.fire({
                    title: 'Importante',
                    text: `El servidor respondio erroneamente`,
                    icon: 'warning',
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
export const Extract_Active_Accounts = () => {
    debugger;
    try {
        let data = {
            url: "http://localhost/Market-System/capa-negocios/Ajax-Products/ajax_actions/user_actions/Extract-Accounts.php",
            method: "POST",
            data: { Estado: 'Activa' },
            dataType: "json",
            Content: "application/x-www-form-urlencoded; charset=UTF-8",
        }

        GenericAjax(data, Response_Active_Accounts);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}
export const Response_Active_Accounts = (response) => {
    debugger;
    try {
        switch (response.StatusCode) {
            case 200:
                console.log(response.Cuentas.length);
                let html = "";
                if (response.Cuentas.length < 1) {
                    html = '<br><h3 class="display-3" style="text-align:center">Sin cuentas registradas</h3>';
                    $("#table---").html(html);
                } else {
                    html += `<table id='tb' class='table table-striped table-bordered'>
                                <tr>
                                    <td>ID</td>
                                    <td>Nombre</td>
                                    <td>Privilegios</td>
                                    <td>Estado</td>
                                    <td>Acciónes</td>
                                </tr>`;

                    for (let i = 0; i < response.Cuentas.length; i++) {
                        html += `<tr>`;

                        // Rellenar las celdas con la información de cada cuenta
                        for (const key of Object.keys(response.Cuentas[i])) {
                            html += `<td ud='id_'>${response.Cuentas[i][key]}</td>`;
                        }

                        const accountId = response.Cuentas[i].ID; // Usar el ID correcto para cada cuenta
                        html += `<td>
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" onClick="Suspend_Account(${accountId})" role="switch" id="flexSwitchCheckChecked_${accountId}" checked>
                                            <label class="form-check-label" for="flexSwitchCheckChecked_${accountId}">Suspender</label>
                                        </div>
                                    </div>
                                </td>
                                <td id="id_user" hidden>${accountId}</td>
                            </tr>`;
                    }
                    html += "</table>";
                    $("#table---").html(html);
                }
                break;
            case 400:
                alert('Nonas mi rey respuesta incorrecta');
                break;
            case 404:
                alert('Nonas mi rey No se encontraron cuentas');
                break;
            case 500:
                alert('Nonas mi rey Error interno del servidor');
                break;
            default:
                Swal.fire({
                    title: 'Importante - Error',
                    text: `: ${error}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
        }
    } catch (error) {
        Swal.fire({
            title: 'Excepción encontrada',
            text: `Código de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
};

let PrecioTotal = 0;
let mercado = new Array();
export const on_click_cash = (param) => {
    $("#ajax-items").hide();
    $("#product-name").val("");
    $("#product-name").focus();
    try {
        debugger;
        let json = JSON.parse(JSON.stringify(param));
        let index = mercado.findIndex(fila => fila[0] === json.Nombre); // Asegúrate de que compares el nombre correctamente
        
        console.log(mercado);
        // Aumentar cantidad o agregar nuevo producto
        index !== -1
            ? mercado[index][mercado[index].length - 1] += 1 // Aumenta la cantidad del producto
            : mercado.push([json.Nombre, json.Precio, 1]); // Agrega nuevo producto
            console.log(mercado);


        //alert(index);
        debugger;

        // Generar el HTML solo una vez
        let html_product = '';
        for (let producto of mercado) {
            debugger;
            let PrecioProd = producto[1] * producto[2];
            html_product += `
                <ul id='${producto[0].replaceAll(" ", "_")}'>
                    <table class='table table-hover'>
                        <tr>
                            <td class='col-sm-2'>${producto[0]}</td>
                            <td class='col-sm-2'>${producto[1]}</td>
                            <td class='col-sm-2'>${producto[2]}</td>
                            <td class='col-sm-2'>
                                <img style='width:20%; height:20%; margin-left:15%; cursor:pointer' onclick='deleteCashProduct("${producto[0]}")' src="../../resources/delete.png"/>
                            </td>
                        </tr>
                    </table>
                </ul>`;
        }

        // Reemplaza el contenido del contenedor
        $("#list-product").html(html_product); // Reemplaza todo el HTML en lugar de append o replaceWith

        // Actualiza el total
        PrecioTotal = mercado.reduce((total, producto) => total + (producto[1] * producto[2]), 0);
        $('#total').html(`${PrecioTotal} $`);

    } catch (error) {
        Swal.fire({
            title: 'Excepción encontrada',
            text: `Código de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}



export const Create_Account = () => {
    try {
        const create = new Create_Accounts();
        create.openModal();
        //edit.closeModal();
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }

}




export const Suspend_Account = (id) => {
    const Switch = document.getElementById(`flexSwitchCheckChecked_${id}`);
    Switch.disabled = true;
    Swal.fire({
        title: 'Importante',
        text: `¿Desea suspender esta cuenta? , el usuario asociado no podra acceder al sistema ,
            para activar la cuenta debera buscar la cuenta asociada y activarla.`,
        icon: 'info',
        confirmButtonText: 'Si, Suspender',
        showCancelButton: 'Cancelar'
    }).then((result) => {
        Switch.disabled = false;
        if (result.isConfirmed) {
            debugger;
            try {
                let data = {
                    url: "http://localhost/Market-System/capa-negocios/Ajax-User/Suspend-user.php",
                    method: "POST",
                    data: { Suspend: id },
                    dataType: 'json',
                    Content: "application/x-www-form-urlencoded; charset=UTF-8"
                }
                GenericAjax(data, Response_Activation_Account);
            } catch (error) {
                Swal.fire({
                    title: 'Excepcion encontrada',
                    text: `Codigo de Error: ${error}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        } else {
            Switch.checked = true;
        }
    })

}

export const Response_Suspend_Account = (response) => {
    debugger;

    console.log(response);
    try {
        switch (response.StatusCode) {
            case 200:
                Swal.fire({
                    title: 'Importante',
                    text: `Cuenta Suspendida , revisa la cuenta en la pestaña Cuentas Suspendidas`,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(function () {

                    Extract_Suspended_Accounts();
                    window.location = "../User-Folders/Management_accounts/main_accounts";
                    Extract_Active_Accounts();

                    window.location = "../User-Folders/Management_accounts/main_accounts";
                })

                break;
            case 400:
                Swal.fire({
                    title: 'Importante',
                    text: `El servidor respondio erroneamente`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 404:
                Swal.fire({
                    title: 'Importante',
                    text: `Usuario no encontrado!`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 500:
                Swal.fire({
                    title: 'Importante',
                    text: `Error interno del servidor`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                break;
            default:
                Swal.fire({
                    title: 'Importante',
                    text: `El servidor respondio erroneamente`,
                    icon: 'warning',
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
export const Print_Unit_Product = (response) => {
    debugger;
    let producto = {};
    producto = response;
    console.log(producto)
    try {

        $("#nombre-producto").text(producto[0].Nombre);
        $("#referencia-producto").html(producto[0].Referencia);
        $("#precio-producto").html(producto[0].Precio);
        $("#stock-producto").html(producto[0].Stock);
        $("#vendidas-producto").html(producto[0].Vendidos);
        $("#categoria-producto").html(producto[0].Categoria);


    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

const response_UpdateProduct = (response) => {
    try {
        console.log(response);
        switch (response.StatusCode) {
            case 200: break;
            case 400:
                Swal.fire({
                    title: 'Importante',
                    text: `El servidor devolvio una respuesta erronea: ${response.Message}`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 403:
                Swal.fire({
                    title: 'Importante',
                    text: `${response.Message} , ${response.Repetidos}`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                break;
            case 404:
                Swal.fire({
                    title: 'Importante',
                    text: `${response.Message}`,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }); break;
            case 500:
                Swal.fire({
                    title: 'Importante',
                    text: `${response.Message}`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }); break;
                break;
            default:
                Swal.fire({
                    title: 'Importante',
                    text: `El servidor devolvio una respuesta erronea: ${response.Message}`,
                    icon: 'warning',
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

const cashSearchProduct = (param) => {
    try {
        searchProduct(param);
    } catch (error) {
        Swal.fire({
            title: 'Excepcion encontrada',
            text: `Codigo de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}
const deleteCashProduct = (nameProduct) => {
    try {
        let index = 0;
        let nCantidad;

        if (Array.isArray(mercado) && Array.isArray(mercado[0])) {
            index = mercado.findIndex(fila => fila[0] === nameProduct);
            console.log(index);

            if (index !== -1) {
                nCantidad = mercado[index][2]; 

           
                if (nCantidad === 1) {
                    mercado.splice(index, 1); 
                } else {
                    mercado[index][2] -= 1; 
                }
            }
        } else if (Array.isArray(mercado) && !Array.isArray(mercado[0])) {
         
            alert("Un arreglo de una dimensión, lo cual no debería suceder.");
        }

      
        let html_product = '';
        for (let producto of mercado) {
            html_product += `
                <ul id='${producto[0].replaceAll(" ", "_")}'>
                    <table class='table table-hover'>
                        <tr>
                            <td class='col-sm-2'>${producto[0]}</td>
                            <td class='col-sm-2'>${producto[1]}</td>
                            <td class='col-sm-2'>${producto[2]}</td>
                            <td class='col-sm-2'>
                                <img style='width:20%; height:20%; margin-left:15%; cursor:pointer' onclick='deleteCashProduct("${producto[0]}")' src="../../resources/delete.png"/>
                            </td>
                        </tr>
                    </table>
                </ul>`;
        }

       
        $("#list-product").html(html_product); 

    
        const PrecioTotal = mercado.reduce((total, producto) => total + (Number(producto[1]) * Number(producto[2])), 0);
        $('#total').html(`${PrecioTotal} $`);

    } catch (error) {
        Swal.fire({
            title: 'Excepción encontrada',
            text: `Código de Error: ${error}`,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

const GeneratorInvoices = () => {
    try {
        if (mercado.length > 0) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFont("helvetica", "bold");
            doc.setFontSize(18);
            doc.text("Factura Comercial", 105, 20, { align: 'center' });

            doc.setFontSize(12);
            doc.text("Número de Factura: 12345", 20, 30);
            doc.text("Fecha: 2024-10-20", 150, 30);

            doc.setLineWidth(0.5);
            doc.line(20, 35, 190, 35);

            // Tabla
            doc.autoTable({
                startY: 40,
                head: [['Producto', 'Cantidad', 'Precio Unitario', 'Total']],
                body: mercado.map(productos => [
                    productos[0], 
                    productos[2], 
                    productos[1], 
                    (productos[1] * productos[2]).toFixed(2), // Total
                ]),
                theme: 'grid'
            });

            // Precio Total
            let PrecioTotal = mercado.reduce((total, productos) => total + (Number(productos[2]) * Number(productos[1])), 0);
            doc.setFontSize(14);
            doc.text(`Total a Pagar: $${PrecioTotal.toFixed(2)}`, 150, doc.lastAutoTable.finalY + 10);

            // Guardar PDF
            doc.save("Factura.pdf");
        } else {
            Swal.fire({
                title: 'Importante',
                text: `Debe agregar productos para poder generar la factura`,
                icon: 'info',
                confirmButtonText: 'Aceptar'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Excepción encontrada',
            text: `Código de Error: ${error}`,
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
window.Extract_product_info = Extract_product_info;
window.Extract_Suspended_Accounts = Extract_Suspended_Accounts;
window.Response_Suspended_Accounts = Response_Suspended_Accounts;
window.Response_Active_Accounts = Response_Active_Accounts;
window.Extract_Active_Accounts = Extract_Active_Accounts;
window.Create_Account = Create_Account;
window.Activation_Account = Activation_Account;
window.Response_Activation_Account = Response_Activation_Account;
window.Suspend_Account = Suspend_Account;
window.Print_Unit_Product = Print_Unit_Product;
window.response_UpdateProduct = response_UpdateProduct;
window.cashSearchProduct = cashSearchProduct;
window.on_click_cash = on_click_cash;
window.deleteCashProduct = deleteCashProduct;
window.GeneratorInvoices = GeneratorInvoices;