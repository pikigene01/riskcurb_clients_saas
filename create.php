<?php 
include_once('includes/cors.php');
include_once('includes/host.php');
if(isset($_POST['site_name'])){
$site_name = $_POST['site_name'];
$user_email = $_POST['email'];
$user_password = $_POST['password'];//bycrypted password sent
$con = new mysqli($host,$user,$password);

$create = $con->query("CREATE DATABASE $site_name");

if($create){
   //load sql file

    $con_2 = new mysqli($host,$user,$password,$site_name);
    $time = new DateTime();
    $user_token = "qwertyuioadsghzvgdfuypbmcbjhcba$time";
    //insert values bycrypted password
    $save_user = $con_2->query("INSERT INTO users (email,name,password,role,created_at) VALUES ('$user_email','$site_name','$user_password','admin',NOW() ) ");
    $save_user_token = $con_2->query("INSERT INTO tokens (email,token,created_at) VALUES ('$user_email','$user_token',NOW() ) ");

     if($save_user){
    exit(json_encode(
        array(
            'status'=>200,
            'message'=>'Database created successfully',
            'token'=>$user_token
            )
        
    ));
}else{
    exit(json_encode(
        array(
            'status'=>200,
            'message'=>'there was an error occurred'
            
            )
        
    ));
}
}
    
}