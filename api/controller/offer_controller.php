<?php

class OfferController
{       
    function displayMyOffers($data)
    {
        $data       =   (object)$data;
        $Result     =   Offer::searchAll($data->us_id);
        echo json_encode($Result);
    }
    
    function save($data)
    {
        $data       =   (object)$data;
        $Result     =   Offer::save($data);
        echo json_encode($Result);
    }
    
    function accept($data)
    {
        $data       =   (object)$data;
        $Result     =   Offer::accept($data->of_id);
        echo json_encode($Result);
    }
    
    function reject($data)
    {
        $data       =   (object)$data;
        $Result     =   Offer::reject($data->of_id);
        echo json_encode($Result);
    }
}