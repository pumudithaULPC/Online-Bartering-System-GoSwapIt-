<?php

class CategoryController
{
    function loadSuperCategories()
    {
        $Result       =    Category::loadSuperCategories();
        echo json_encode(array('result' => $Result));
    }
    
    function loadCategoriesforBrand()
    {
        $Result       =    Category::loadCategoriesforBrand();
        echo json_encode(array('result' => $Result));
    }
    
    function saveCategory($data)
    {
        $data       =   (object)$data;
        $Result     =   Category::save($data);
        
        echo json_encode($Result);
    }

    function deleteCategory($data)
    {
        $data       =   (object)$data;
        $Result     =   Category::delete($data);
        
        echo json_encode($Result);
    }
    
    function displayCategories($data)
    {
        $Result     =   Category::searchAll();
        echo json_encode($Result);
    }

    function search($data)
    {
        $data       =   (object)$data;
        $Result     =   Category::search($data->ca_id);
        echo json_encode($Result);
    }
}