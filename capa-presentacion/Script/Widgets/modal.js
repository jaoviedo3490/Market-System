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






class Modal {
    constructor() {
        this.modalElement = this.createModalElement();
        document.body.appendChild(this.modalElement);
    }

    createModalElement(titulo) {
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.tabIndex = -1;
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${titulo}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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






class Edit_Product extends Modal {
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
                                        style='width:100%;'>Editar Producto</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

    </div>`;

        this.setContent(customContent); // Establece el contenido del modal
        this.addCreateProductEvent(); // Añade el evento para manejar la creación del producto
        this.show(); // Muestra el modal
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

                console.log('Producto creado:', {
                    name: productName,
                    description: productDescription,
                    price: productPrice
                });

                // Cierra el modal después de crear el producto
                const modal = bootstrap.Modal.getInstance(this.modalElement);
                modal.hide();
            });
        } else {
            console.error('Formulario no encontrado en el modal.');
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

        this.setContent(customContent); // Establece el contenido del modal
        this.addCreateProductEvent(); // Añade el evento para manejar la creación del producto
        this.show(); // Muestra el modal
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

                console.log('Producto creado:', {
                    name: productName,
                    description: productDescription,
                    price: productPrice
                });

                // Cierra el modal después de crear el producto
                const modal = bootstrap.Modal.getInstance(this.modalElement);
                modal.hide();
            });
        } else {
            console.error('Formulario no encontrado en el modal.');
        }
    }
}

// Asegúrate de que esta clase se defina en el mismo archivo o en uno accesible por el contexto donde la instancias.



