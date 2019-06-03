<?php

class ModelController
{
    function saveModel($data)
    {
        $data       =   (object)$data;
        $Result     =   Model::save($data);
        
        echo json_encode($Result);
    }

    function deleteModel($data)
    {
        $data       =   (object)$data;
        $Result     =   Model::delete($data);
        
        echo json_encode($Result);
    }
    
    function displayModels($data)
    {
        $Result     =   Model::searchAll();
        echo json_encode($Result);
    }

    function search($data)
    {
        $data       =   (object)$data;
        $Result     =   Model::search($data->md_id);
        echo json_encode($Result);
    }
    
    function searchByBrand($data)
    {
        $data       =   (object)$data;
        $Result     =   Model::searchByBrandId($data->br_id);
        echo json_encode($Result);
    }
}