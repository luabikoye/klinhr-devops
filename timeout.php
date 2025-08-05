<?php  
if(isset($_SESSION["Klin_user"]))  
{  
    if((time() - $_SESSION['last_login_timestamp']) > 900) // 15 minutes of inactivity
    {  
        $return_page = base64_encode(basename($_SERVER['REQUEST_URI'])); 
        $_SESSION['redirect'] = $return_page;
        ?>
        <script>
            setTimeout(function(){
            window.location='redirect?1c30f1ae89e3ba2eb42c7d=0f52ac208baa24be3b8f7';
        }, 1000);
        </script>    

        <?php        
        // $return_page = base64_encode(basename($_SERVER['REQUEST_URI']));        
        // header("location: login?return_page=$return_page");         
    }  
    else  
    {  
        $_SESSION['last_login_timestamp'] = time();            
    }  
}  
else  
{  
        header('location:logout');  
        exit;
}  

?>