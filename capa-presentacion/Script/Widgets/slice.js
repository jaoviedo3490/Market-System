$(document).ready(function(){
    
});

function widget(action,elemento){
    let counter = "<div id ='widget-prod'  class='container'>"+
            "<div class='row'>"+
                "<div class='col' style='margin-left:40%'>"+
                "<ul class='pagination'>"+
                    "<li class='page-item disabled'>"+
                        "<a class'page-link' href='#'>&laquo;</a>"+
                    "</li>"+"<div class='container' id='item-wid'></div>"
                    "<li class='page-item'>"
                        +"<a class='page-link' href='#'>&raquo;</a>"
                    +"</li>"
                "</ul>"+
                +"</div>"
            +"</div>";
            let widget = "";
    $.ajax({
        url:"../../capa-negocios/Ajax-products/ajax_actions/groupElement.php",
        method:"POST",
        data:{action},
        dataType: 'json',
        success:function(response){
            let arreglo = [];
                       
                      
                        let cantidad = (response.cantidad <= 5) ? 1 : Math.floor(response.cantidad / 5);
                        console.log(response);
                        for (let i = 0; i < cantidad; i++) {
                         widget += "<li class='page-item active'>"+
                            "<button class='page-link' href='#'>"+(i+1)+"</button>"
                        "</li>";
                            
                        }

                      
                        $("#"+elemento).html(counter);

                        $("#item-wid").html(widget);

                  
        },
        error:function(response){
            console.log(JSON.stringify(response, null, 2));
           
        }
    });
}