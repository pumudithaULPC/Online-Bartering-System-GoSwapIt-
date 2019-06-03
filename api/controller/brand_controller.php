<?php

class BrandController
{
    function saveBrand($data)
    {
        $data       =   (object)$data;
        $Result     =   Brand::save($data);
        
        echo json_encode($Result);
    }

    function deleteBrand($data)
    {
        $data       =   (object)$data;
        $Result     =   Brand::delete($data);
        
        echo json_encode($Result);
    }
    
    function displayBrands($data)
    {
        $Result     =   Brand::searchAll();
        echo json_encode($Result);
    }

    function search($data)
    {
        $data       =   (object)$data;
        $Result     =   Brand::search($data->br_id);
        echo json_encode($Result);
    }
    
    function loadBrands($data)
    {
        $data         =   (object)$data;
        $Result       =    Brand::loadBrands($data->ca_id);
        echo json_encode($Result);
    }
}