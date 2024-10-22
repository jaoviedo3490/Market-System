<?php
    function InyectionJS($message,$button,$title,$route){
        return "<script>".
                    "Swal.fire({".
                        "title: '".$title."',".
                        "text: '".$message."',".
                        "icon: '".$button."',".
                        "confirmButtonText: 'Aceptar',".
                        "}).then(function(){".
                            "RenewCrentials();".
                        "</script>";
                    }
                    

                    function GenericAlert($message,$button,$title){
                        return "<script>debugger;".
                                    "Swal.fire({".
                                        "title: '".$title."',".
                                        "text: '".$message."',".
                                        "icon: '".$button."',".
                                        "});</script>";
                                    }
    

?>