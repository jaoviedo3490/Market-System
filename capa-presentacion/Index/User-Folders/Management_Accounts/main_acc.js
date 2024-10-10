$(document).ready(function(){
    $("#suspended_accounts").click(function(){
        $("#suspended_accounts").prop('style','text-decoration:none;border-radius: 4%; border-bottom:5px solid #466375;');
        $("#show_accounts").removeAttr('style');
        $("#show_accounts").prop('style','text-decoration:none');
    })
    $("#show_accounts").click(function(){
        $("#show_accounts").prop('style','text-decoration:none;border-radius: 4%; border-bottom:5px solid #466375;');
        $("#suspended_accounts").removeAttr('style');
        $("#suspended_accounts").prop('style','text-decoration:none');
    })
    $('#suspended_accounts').click(function(){
        $.ajax({
            url:'suspend.php',
            method: 'post',
            data: {'trigger_':'active'},
            success: function(response){
                let arr = new Array();
                arr = JSON.parse(JSON.stringify(response));
                arreglo = new Array();
                    let t = arr.toString();
                    if(t.length==0) $("#table---").html('<h3>Sin cuentas registradas</h3>');
                    t = t.replaceAll(']',':');
                    t = t.replaceAll('[','');
                    t = t.replaceAll(']','');
                    t = t.replaceAll('"','');
                    t = t.replaceAll(' ','');
                    arreglo = t.split(':');
                    for(let k=0;k<arreglo.length;k++)
                        arreglo[k] = arreglo[k].split(',',3);
                    let tabla = '<table class="table table-hover bg- table-striped table-bordered"><thead>'
                    +'<tr>'
                    +'<th class="col-sm-2">ID</td><td class="col-sm-2">Nombre</th><th class="col-sm-2">Privilegios</th><th class="col-sm-2">Acciones</th>'
                    +'</tr>'
                    +'<tr id="suspend-actions"></tr></thead>';
                $('#table---').html(tabla);
                for(let k=0;k<=arreglo.length-2;k++){
                    tabla += '<tr>';
                    for(let j=0;j<=arreglo[k].length-2;j++){
                        tabla += '<td>'+arreglo[k][j]+'</td><td>'+arreglo[k][j+(j+1)]+"</td><td>"+arreglo[k][j+(j+2)]+
                        "</td><td>"+'<a href="#" id="recover-account"><img class="img-fluid" style="width:20%;heigth:20%;" src="../../../resources/restaurar.png"/></a><a style="margin:0 2% 0 2%" href="#" id="delete-account"><img class="img-fluid" style="width:20%;heigth:20%;" src="../../../resources/delete.png"></a>';
                        if(k>=0) break;
                    }tabla+='</tr>';
                    $('#table---').html(tabla);
                }
            },
            cache: false
        });
    })
    $("#create-account").click(function(){
        let modal_window = '<div id="modal-window" class="window-modal" style="pointer-events:none;">'+
        '<div class="wnd-popup">'+
        '<a href="#" id="close-popup" style="text-decoration:none;"><h5>X</h5></a><h2>Nuevo Usuario</h2>'+
        '<hr><form>'+
        '<label>Nombre:</label><input type="text" class="form-control">'+
        '<label>Contraseña:</label><a id="pass-generated" href="#" style="margin: 0 0 0 49%;">Generar Contraseña</a><input id="contrasena" type="password" class="form-control" disabled>'+
        '<label style="margin: 2% 0 0 0">Tipo de Rol:</label><div style="margin:-5% 0 0 50%;" class="form-check ">'+
        '<input type="radio" class="form-check-input" name="user-permissions">Administrador</input>'+
        '</div><div style="margin: -5% 0 0 80%;" class="form-check"><input type="radio" class="form-check-input" name="user-permissions">Empleado</input></div>'+
        '</form>'+
        '</div>'+
        '</div></div>'
        $("#n").append(modal_window);
        $("#close-popup").click(function(event){
            $('#modal-window').remove();
        })
        $("#pass-generated").click(function(){
            $("#contrasena").val('contraseña generada!!');
        })
    })
    
})
function click_(){
    swal({
        title: "¿Desea suspender esta cuenta?",
        text: "La cuenta NO sera eliminada, podra encontrar en la pestaña Cuentas Suspendidas",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
                let id =$("#id_user").text();
                $.ajax({
                    url:'../../../capa-negocios/Ajax-Products/suspend-user.php',
                    method:'POST',
                    data:{'trigger___':id},
                    success:function(response){
                        location = 'main_accounts.php';
                        let array = JSON.parse(JSON.stringify(response));
                        $("#n").html(array);
                    },
                    error:function(response){
                        alert(response);
                    }
                })
        } 
      });
}