/*const modal = `<div id="modal-window" class="window-modal" style="pointer-events:none;">
    <div class="wnd-popup">
        <a href="#" id="close-popup" style="text-decoration:none;"><h5>X</h5></a>
        <h2>Nuevo Usuario</h2>
        <hr>
        <form>
            <label>Nombre:</label>
            <input type="text" class="form-control">
            
            <label>Contraseña:</label>
            <a id="pass-generated" href="#" style="margin: 0 0 0 49%;">Generar Contraseña</a>
            <input id="contrasena" type="password" class="form-control" disabled>
            
            <label style="margin: 2% 0 0 0">Tipo de Rol:</label>
            <div style="margin:-5% 0 0 50%;" class="form-check">
                <input type="radio" class="form-check-input" name="user-permissions">Administrador
            </div>
            <div style="margin: -5% 0 0 80%;" class="form-check">
                <input type="radio" class="form-check-input" name="user-permissions">Empleado
            </div>
        </form>
    </div>
</div>
`
*/

//import { GenericAjax } from "../main.js";

class Modal {
    constructor() {
        this.modalElement = this.createModalElement();
        document.body.appendChild(this.modalElement);
    }

    createModalElement() {
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.tabIndex = -1;
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" data-title>Esto esta fallando ,no olvides corregirlo</h5>
                        <button id = '' type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Cuerpo del modal.</p>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>-->
                    </div>
                </div>
            </div>
        `;
        return modal;
    }

    setContent(content) {
        this.modalElement.querySelector('.modal-body').innerHTML = content;
    }

    show() {
        const modal = new bootstrap.Modal(this.modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    }
}


class Create_Accounts extends Modal {
    constructor() {
        try {
            super();
        } catch (error) {
            alert(error);
        }
    }

    openModal() {
        this.setCustomContent();
        this.addCreateAccountsEvent();
    }
    setCustomContent() {
        try {
            // Aquí defines el contenido específico para el modal de crear producto
            const customContent = `<div class="wnd-popup">
    <a href="#" id="close-popup" style="text-decoration:none;">
        <h5>X</h5>
    </a>
    <h2>Nuevo Usuario</h2>
    <hr>
    <form>
        <label>Nombre:</label>
        <input type="text" class="form-control">

        <label>Contraseña:</label>
        <a id="pass-generated" href="#" style="margin: 0 0 0 49%;">Generar Contraseña</a>
        <input id="contrasena" type="password" class="form-control" disabled>

        <label style="margin: 2% 0 0 0">Tipo de Rol:</label>
        <div style="margin:-5% 0 0 50%;" class="form-check">
            <input type="radio" class="form-check-input" name="user-permissions" value="administrador">
            Administrador
        </div>
        <div style="margin: -5% 0 0 80%;" class="form-check">
            <input type="radio" class="form-check-input" name="user-permissions" value="empleado">
            Empleado
        </div>
    </form>
</div>
`;

            this.setContent(customContent); // Establece el contenido del modal

            this.addCreateAccountsEvent();// Añade el evento para manejar la creación del producto

            this.show(); // Muestra el modal
        } catch (error) {
            alert(error);
        }
    }
    addCreateAccountsEvent(){
        alert("todo bien papucho")
    }
}



class Edit_Product extends Modal {
    #json_information_product;
    constructor(object) {
        try {

            super(); // Llama al constructor de la clase padre Modal
            this.#json_information_product = {}
            this.#json_information_product = object;
            console.log(object);

            alert("aqui? " + this.#json_information_product);
        } catch (error) {
            alert(error);
        }
    }
    openModal(content) {
        this.#json_information_product = content;
        this.setCustomContent();
        this.addEditProductEvent(this.#json_information_product.ID);

    }
    setCustomContent() {
        try {
            // Aquí defines el contenido específico para el modal de crear producto
            const customContent = `<div class="container">
            <div class='container-fluid' style='width:90%;'>
                        <form method='POST' id='form-main'>
                            <div class='container-fluid'>
                            <div class='row' hidden>
                                    <div class='col'>
                                        Nombre del Producto
                                        <input class='form-control' data-product-name="" id='id-Producto'
                                            type='text' required>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col'>
                                        Nombre del Producto
                                        <input class='form-control' data-product-name="" id='Nombre-Producto'
                                            type='text' required>
                                    </div>
                                </div>
                            </div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col'>
                                        Referencia del Producto
                                        <input class='form-control' data-reference="" id='Referencia-Producto'
                                            type='text' required>
                                    </div>
                                </div>
                            </div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col'>
                                        Precio del Producto
                                        <input class='form-control' data-precio="" id='Precio-Producto'
                                            type='number' required>
                                    </div>
                                </div>
                            </div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col'>
                                        Stock del Producto
                                        <input class='form-control' data-stock="" id='Stock-Producto'
                                            type='number' required>
                                    </div>
                                </div>
                            </div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col'>
                                        Categoria del Producto
                                        <input class='form-control' data-stock="" id='Categoria'
                                            type='text' disabled>
                                    </div>
                                </div>
                            </div>
                            <div class='container' hidden>
                                <div class='row'>
                                    <div class='col'>
                                        Productos Vendidos
                                        <input class='form-control' value='crear-producto'
                                            type='text'>
                                    </div>
                                </div>
                            </div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col'>
                                        <br>
                                        <a href='#' id='update' class='btn btn-outline-primary'
                                            style='width:100%;'>Editar Producto</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

        </div>`;

            this.setContent(customContent); // Establece el contenido del modal

            this.addEditProductEvent();// Añade el evento para manejar la creación del producto

            this.show(); // Muestra el modal
        } catch (error) {
            Swal.fire({
                title: 'Excepcion encontrada',
                text: `${error}`,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }

    addEditProductEvent(id) {
        const form = this.modalElement.querySelector('#form-main');

        if (form) {
            this.clearValues();
            this.setValues();


            const update = document.getElementById('update');
            update.addEventListener("click", function () {
                //alert("desde aqui");
                const Nombre_Producto = document.getElementById('Nombre-Producto');
                const Referencia_Producto = document.getElementById('Referencia-Producto');
                const Precio_Producto = document.getElementById("Precio-Producto");
                const Stock_Producto = document.getElementById('Stock-Producto');

                if (Nombre_Producto.value.trim() === ''
                    || Referencia_Producto.value.trim() === ''
                    || Precio_Producto.value.trim() === ''
                    || Stock_Producto.value.trim() === '') {

                    if (Nombre_Producto.value.trim() === '') {
                        Nombre_Producto.classList.add('is-invalid');
                    }
                    if (Referencia_Producto.value.trim() === '') {
                        Referencia_Producto.classList.add('is-invalid');
                    }
                    if (Precio_Producto.value.trim() === '') {
                        Precio_Producto.classList.add('is-invalid');
                    }
                    if (Stock_Producto.value.trim() === '') {
                        Stock_Producto.classList.add('is-invalid');
                    }

                } else if (Nombre_Producto.value.trim() !== ''
                    && Referencia_Producto.value.trim() !== ''
                    && Precio_Producto.value.trim() !== ''
                    && Stock_Producto.value.trim() !== '') {

                    Nombre_Producto.classList.remove('is-invalid');
                    Referencia_Producto.classList.remove('is-invalid');
                    Precio_Producto.classList.remove('is-invalid');
                    Stock_Producto.classList.remove('is-invalid');

                    Nombre_Producto.classList.add('is-valid');
                    Referencia_Producto.classList.add('is-valid');
                    Precio_Producto.classList.add('is-valid');
                    Stock_Producto.classList.add('is-valid');

                    debugger;
                    let Productos = {
                        Nombre: Nombre_Producto.value,
                        Referencia: Referencia_Producto.value,
                        Precio: Precio_Producto.value,
                        Codigo_de_barras: 'NO DISPONIBLE'
                    }
                    const formParams = new FormData();
                    //alert(Productos);
                    formParams.append('Producto', JSON.stringify({ id: id, Productos }));

                    fetch("http://localhost/Market-System/capa-negocios/Ajax-Products/Update-Product.php", {
                        method: "POST",
                        body: formParams
                    }).then(response => {
                        if (!response.ok) {
                            throw new Exception("El servidor devolvio una respuesta erronea");
                        }
                        return response.json();
                    }).then(data => {
                        debugger;
                        //alert(data);
                        switch (data.StatusCode) {
                            case 200:
                                Swal.fire({
                                    title: 'Importante',
                                    text: `Producto Actualizado Correctamente`,
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then(result => {

                                    if (result.isConfirmed) {
                                        let dialog = document.getElementsByClassName('modal-dialog');
                                        let modal = document.getElementsByClassName('modal fade show');
                                        dialog[0].remove();
                                        modal[0].remove();

                                        form.className = form.className.split(' ').filter(c => c !== 'show').join(' ');

                                        form.setAttribute('inert', 'true');

                                        const modalBackDrop = document.querySelector(".modal-backdrop");
                                        if (modalBackDrop) {
                                            modalBackDrop.remove();
                                        }
                                    }
                                })
                                break;
                            case 400:
                                Swal.fire({
                                    title: 'Importante',
                                    text: `${data.Message}`,
                                    icon: 'warning',
                                    confirmButtonText: 'Aceptar'
                                }); break;
                            case 403:
                                Swal.fire({
                                    title: 'Importante',
                                    text: `${data.Message}`,
                                    icon: 'warning',
                                    confirmButtonText: 'Aceptar'
                                }); break;
                            case 404:
                                Swal.fire({
                                    title: 'Importante',
                                    text: `${data.Message}`,
                                    icon: 'warning',
                                    confirmButtonText: 'Aceptar'
                                }); break;
                            case 500:
                                Swal.fire({
                                    title: 'Importante',
                                    text: `${data.Message}`,
                                    icon: 'warning',
                                    confirmButtonText: 'Aceptar'
                                }); break;
                            default:
                                Swal.fire({
                                    title: 'Importante',
                                    text: `El servidor devolvio una respuesta erronea: ${data.Message}`,
                                    icon: 'warning',
                                    confirmButtonText: 'Aceptar'
                                }); break;
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: 'Excepcion encontrada',
                            text: `${error}`,
                            icon: 'warning',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }



            });

            this.modalElement.addEventListener("hidden.bs.modal", () => {
                console.log("El modal se ha cerrado");
                //this.clearValues(); // Limpiar los valores al cerrar el modal
                this.closeModal(); // Eliminar el listener del formulario
            });
        } else {
            console.error('Formulario no encontrado en el modal.');
        }
    }

    closeModal() {
        //this.clearValues();
        const modal = bootstrap.Modal.getInstance(this.modalElement);
        this.modalElement.remove();
        //alert("elemento removido , o al menos eso parece");
    }
    clearValues() {
        try {

            const Nombre_Producto = document.getElementById('Nombre-Producto');
            const Referencia_Producto = document.getElementById('Referencia-Producto');
            const Precio_Producto = document.getElementById("Precio-Producto");
            const Stock_Producto = document.getElementById('Stock-Producto');
            const Categoria_Producto = document.getElementById('Categoria');


            Nombre_Producto.value = '';
            Referencia_Producto.value = '';
            Precio_Producto.value = '';
            Stock_Producto.value = '';
            Categoria_Producto.value = '';
        } catch (error) {
            alert(error);
        }
    }
    setValues() {
        try {

            const object_json = this.#json_information_product;
            const Nombre_Producto = document.getElementById('Nombre-Producto');
            const Referencia_Producto = document.getElementById('Referencia-Producto');
            const Precio_Producto = document.getElementById("Precio-Producto");
            const Stock_Producto = document.getElementById('Stock-Producto');
            const Categoria_Producto = document.getElementById('Categoria');
            //alert(object_json.Nombre);
            debugger;
            Nombre_Producto.value = object_json.Nombre;
            Referencia_Producto.value = object_json.Referencia;
            Precio_Producto.value = object_json.Precio;
            Stock_Producto.value = object_json.Stock;
            Categoria_Producto.value = object_json.Categoria;
        } catch (error) {
            alert(error);
        }


    }
}


class CreateProduct extends Modal {
    constructor() {
        super(); // Llama al constructor de la clase padre Modal
    }

    setCustomContent() {
        // Aquí defines el contenido específico para el modal de crear producto
        const customContent = `<div class="container">
        <div class='container-fluid' style='width:90%;'>
                    <form method='POST' id='form-main'>
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col'>
                                    Nombre del Producto
                                    <input class='form-control' id='Nombre-Producto'
                                        type='text'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Referencia del Producto
                                    <input class='form-control' id='Referencia-Producto'
                                        type='text'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Precio del Producto
                                    <input class='form-control' id='Precio-Producto'
                                        type='number'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Stock del Producto
                                    <input class='form-control' id='stock-producto'
                                        type='number'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Categoria del Producto
                                    <select name='opciones' id='categoria' class='form-control'
                                        style='width:100%'>
                                        <option selected='' hidden>Escoje la Categoria</option>
                                        <option value='Limpieza Personal' id='new-product'>
                                            Productos de Aseo Personal</option>
                                        <option value='Limpieza Hogar' id='update-product'>
                                            Productos de Limpieza del Hogar</option>
                                        <option value='Granel' id='search'>Productos a Granel
                                        </option>
                                        <option value='Fruver' id='search'>Productos Fruver
                                        </option>
                                        <option value='Carnicos' id='search'>Productos Carnicos
                                        </option>
                                        <option value='Lacteos' id='search'>Productos Lacteos
                                        </option>
                                        <option value='Alimentos para Animales' id='search'>
                                            Alimentos para Animales</option>
                                        <option value='Confituras' id='search'>Dulces y
                                            Confituras</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='container' hidden>
                            <div class='row'>
                                <div class='col'>
                                    Productos Vendidos
                                    <input class='form-control' value='crear-producto'
                                        type='text'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    <br>
                                    <a href='#' id='prueba' class='btn btn-outline-primary'
                                        style='width:100%;'>Crear Producto</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

    </div>`;

        //this.setContent(customContent); // Establece el contenido del modal
        //this.addCreateProductEvent(); // Añade el evento para manejar la creación del producto
        //this.show(); // Muestra el modal
    }

    addCreateProductEvent() {
        // Añade un evento de escucha al formulario para manejar la creación del producto
        const form = this.modalElement.querySelector('#create-product-form');
        if (form) {
            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Previene la acción predeterminada de enviar el formulario

                // Aquí puedes añadir la lógica para manejar la creación del producto
                const productName = form.productName.value;
                const productDescription = form.productDescription.value;
                const productPrice = form.productPrice.value;

                

                // Cierra el modal después de crear el producto
                const modal = bootstrap.Modal.getInstance(this.modalElement);
                modal.hide();
            });
        } else {
            console.error('Formulario no encontrado en el modal.');
        }
    }
}
/*lass CreateAccounts extends Modal {
    constructor() {
        super(); // Llama al constructor de la clase padre Modal
    }
    openModal() {
        
        this.setCustomContent();
        this.addCreateAccountsEvent();

    }
    setCustomContent() {
        // Aquí defines el contenido específico para el modal de crear producto
        const customContent = `<div class="container">
        <div class='container-fluid' style='width:90%;'>
                    <form method='POST' id='form-main'>
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col'>
                                    Nombre del Producto
                                    <input class='form-control' id='Nombre-Producto'
                                        type='text'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Referencia del Producto
                                    <input class='form-control' id='Referencia-Producto'
                                        type='text'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Precio del Producto
                                    <input class='form-control' id='Precio-Producto'
                                        type='number'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Stock del Producto
                                    <input class='form-control' id='stock-producto'
                                        type='number'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    Categoria del Producto
                                    <select name='opciones' id='categoria' class='form-control'
                                        style='width:100%'>
                                        <option selected='' hidden>Escoje la Categoria</option>
                                        <option value='Limpieza Personal' id='new-product'>
                                            Productos de Aseo Personal</option>
                                        <option value='Limpieza Hogar' id='update-product'>
                                            Productos de Limpieza del Hogar</option>
                                        <option value='Granel' id='search'>Productos a Granel
                                        </option>
                                        <option value='Fruver' id='search'>Productos Fruver
                                        </option>
                                        <option value='Carnicos' id='search'>Productos Carnicos
                                        </option>
                                        <option value='Lacteos' id='search'>Productos Lacteos
                                        </option>
                                        <option value='Alimentos para Animales' id='search'>
                                            Alimentos para Animales</option>
                                        <option value='Confituras' id='search'>Dulces y
                                            Confituras</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='container' hidden>
                            <div class='row'>
                                <div class='col'>
                                    Productos Vendidos
                                    <input class='form-control' value='crear-producto'
                                        type='text'>
                                </div>
                            </div>
                        </div>
                        <div class='container'>
                            <div class='row'>
                                <div class='col'>
                                    <br>
                                    <a href='#' id='prueba' class='btn btn-outline-primary'
                                        style='width:100%;'>Crear Producto</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

    </div>`;

        this.setContent(customContent); // Establece el contenido del modal
        this.addCreateAccountsEvent(); // Añade el evento para manejar la creación del producto
        this.show(); // Muestra el modal
    }

    addCreateAccountsEvent() {
        // Añade un evento de escucha al formulario para manejar la creación del producto
        
        alert("desde addCreateAccountsEvent");
    }
}

class GenericLoad extends Modal {

}


*/
