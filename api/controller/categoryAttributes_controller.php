<?php

class CategoryAttributesController
{
    function loadSuperCategories()
    {
        $Result       =    CategoryArributes::loadSuperCategories();
        echo json_encode(array('result' => $Result));
    }
    
    function saveCategoryAttributes($data)
    {
        $data       =   (object)$data;
        $Result     =   CategoryAttributes::save($data);
        
        echo json_encode($Result);
    }

    function deleteCategoryAttributes($data)
    {
        $data       =   (object)$data;
        $Result     =   CategoryAttributes::delete($data);
        
        echo json_encode($Result);
    }
    
    function displayCategories($data)
    {
        $Result     =   CategoryAttributes::searchAll();
        echo json_encode($Result);
    }

    function search($data)
    {
        $data       =   (object)$data;
        $Result     =   CategoryAttributes::search($data->ca_id);
        echo json_encode($Result);
    } 
    
    function getCategoryAttributes($data)
    {
        $data       =   (object)$data;
        $Result     =   CategoryAttributes::getAll($data->ca_id);
        echo json_encode($Result);
    }
}