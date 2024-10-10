import { sesion2 } from "../Script/main.js";

$(document).ready(function () {
    // Mostrar/ocultar la contraseña
    $("#pass__").click(function () {
        let v = $("#pass__").is(':checked');
        $("#contraseña").attr('type', v ? 'text' : 'password');
    });

    // Manejo del inicio de sesión
    $("#btn-init-session").click(function () {
        let nombre = $("#nombre_").val();
        let contraseña = $("#contraseña_").val();
    
        if (nombre.length === 0 || contraseña.length === 0) {
            Swal.fire({
                title: 'Campos incompletos',
                text: "¡Debe completar los campos obligatorios!",
                icon: 'warning',
               confirmButtonText: 'Aceptar'
              })
             
              
        } else {
            let dato = {
                nombre:nombre,
                contraseña:contraseña
            }
            sesion2(dato);
        }
         
    });
    
    

    
    $("#btn-btn-create").click(function () {
        let nombre = $("#nombre").val();
        let contraseña = $("#contraseña").val();
        let confirmContraseña = $("#contraseña_").val();

        if (nombre.length === 0 || contraseña.length === 0 || confirmContraseña.length === 0) {
            window.alert('¡Debe completar los campos obligatorios!');
        } else {
            if (contraseña === confirmContraseña) {
                $("#formulario-1b").prop("action", "../../capa-negocios/backend.php");
                $("#formulario-1b").submit();
            } else {
                $("#formulario-1b").removeAttr('action');
                window.alert('¡Las contraseñas no coinciden!');
            }
        }
    });

    // Mostrar/ocultar la contraseña de confirmación
    $("#pass_").click(function () {
        let x = $("#pass_").is(':checked');
        $("#contraseña_").attr('type', x ? 'text' : 'password');
    });
});













