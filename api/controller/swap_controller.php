<?php

class SwapController
{
    
    function save($data)
    {
        $data       =   (object)$data;
        $Result     =   Swap::save($data);
        
        echo json_encode($Result);
    }
    
    function displaySwaps($data)
    {
        $Result     =   Swap::searchAll();
        echo json_encode($Result);
    }
    
    function search($data)
    {
        $data       =   (object)$data;
        $Result     = Swap::search($data->sp_id);
        echo json_encode($Result);
    }
    
    function searchswapwithitems($data)
    {
        $data       =   (object)$data;
        $swap       =   Swap::search($data->sp_id);
        $items      =   SwapItem::searchAll($data->sp_id);
        
        $response   =   array('swap' => $swap, 'items' => $items);
        echo json_encode($response);
    }
    
    function loadIncompletedSwap($data)
    {
        $data       =   (object)$data;
        $Result     =   Swap::searchIncompletedSwaps($data->sp_us_id);
        echo json_encode($Result);
    }
    
    function loadMySwaps($data)
    {
        $data       =   (object)$data;
        $Result     =   Swap::loadMySwaps($data->sp_us_id);
        echo json_encode($Result);
    }
    
    function complete($data)
    {
        $data       =   (object)$data;
        $Result     =   Swap::completeSwap($data->sp_id);
        echo json_encode($Result);
    }
    
    
    function searchByUserID($data)
    {
        $data       =   (object)$data;
        $Result     = Swap::searchByUserID($data->us_id);
        echo json_encode($Result);
    }
}

