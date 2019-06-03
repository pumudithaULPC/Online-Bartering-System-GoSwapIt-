<?php 

    require_once('request.php');

    $postdata = file_get_contents("php://input");

    if(isset($_POST['data']))
    {
        $data      =  $_POST['data'];
    }
    else
    {
        $data       = '';
    }

    echo Request::ProcessRequest($_POST['controller'],$_POST['action'],$data);

?>