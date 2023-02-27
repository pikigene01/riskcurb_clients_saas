<?php 
include_once('includes/cors.php');
include_once('includes/host.php');
if(isset($_POST['site_name'])){
$site_name = $_POST['site_name'];
$con = new mysqli($host,$user,$password,$site_name);

if(isset($_POST['html'])){
    $index_data = $_POST['index'];
    $type = $_POST['type'];
    $html = $_POST['html'];
    $site_name = $_POST['site_name'];


}
}