<?php

class swapperController
{

    function createSwapper($data)
    {
        $data = (object) $data;
        $Result = Swapper::createSwapper($data);

        echo json_encode($Result);
    }

    function authenticateSwapper($data)
    {
        $data = (object) $data;
        $Result = Swapper::authenticateSwapper($data);

        echo json_encode($Result);
    }

    function search($data)
    {
        $data = (object) $data;
        $Result = Swapper::search($data->us_id);
        echo json_encode($Result);
    }

    function changePassword($data)
    {
        $data = (object) $data;
        $Result = Swapper::search($data->us_id);
        echo json_encode($Result);
    }
    
    function resetpw($data)
    {
        $data = (object) $data;
        $Result = User::resetPassword($data->us_username);
        echo json_encode($Result);
    }
}
