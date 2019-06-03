<?php

class SwapItemController
{
    
    function saveItem($data)
    {
        $data       =   (object)$data;
        $Result     =   SwapItem::save($data);
        
        echo json_encode($Result);
    }
    
    function displayItems($data)
    {
    	$data       =   (object)$data;
        $Result     =   SwapItem::searchAll($data->sp_id);
        echo json_encode($Result);
    }
    
    function deleteItem($data)
    {
        $data       =   (object)$data;
        $Result     =   SwapItem::delete($data);
        
        echo json_encode($Result);
    }
    
}

