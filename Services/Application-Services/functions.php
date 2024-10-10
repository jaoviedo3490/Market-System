<?php
    function InyectionJS($message,$button,$title,$route){
        return "<script>".
                    "swal({".
                        "title: '".$title."',".
                        "text: '".$message."',".
                        "icon: '".$button."',".
                        "dangerMode: true,".
                        "}).then(function(){".
                            "RenewCrentials();".
                        "</script>";
                    }


                    function GenericAlert($message,$button,$title){
                        return "<script>".
                                    "swal({".
                                        "title: '".$title."',".
                                        "text: '".$message."',".
                                        "icon: '".$button."',".
                                        "});</script>";
                                    }
    

?>