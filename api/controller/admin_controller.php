    <?php

class AdminController
{

    function createAdmin($data)
    {
        $data       =   (object)$data;
        $Result     =   Admin::createAdmin($data);
        
        echo json_encode($Result);
    }

    function deleteAdmin($data)
    {
        $data       =   (object)$data;
        $Result     =   Admin::delete($data);
        
        echo json_encode($Result);
    }
    function displayNames($data)
    {
        $Result     =   Admin::searchAll();
        echo json_encode($Result);
    }

    function search($data)
    {
        $data       =   (object)$data;
        $Result     =   Admin::search($data->us_id);
        echo json_encode($Result);
    }
    
    function authenticateadmin($data)
    {
        $data       =   (object)$data;
        $Result     =   Admin::authenticateadmin($data);
        
        echo json_encode($Result);
    }
    
    
    
}