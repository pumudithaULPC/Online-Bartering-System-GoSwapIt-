<?php 

require_once ('request.php');
require_once ('session_control.php');
require_once ('authenticate.php');


class AuthenticateControl
{
    public function AuthenticateUser($data)
    {
        return Authenticate::auth($data);
    }
    
    public function getSessionData($data)
    {
        return Authenticate::getSessionData($data);
    }
    
    public function getSessionStatus()
    {
        return Authenticate::getSessionStatus();
    }
    
    public function signOut($data)
    {
        Authenticate::destroySession();
        return true;
    }
}

$postdata = file_get_contents("php://input");

    if(isset($_POST['data']))
    {
        $data      =  $_POST['data'];
    }
    else
    {
        $data       = '';
    }

$AuthControl    =   new AuthenticateControl();
$response       =   $AuthControl->{$_POST['action']}($data);

echo json_encode($response);
?>