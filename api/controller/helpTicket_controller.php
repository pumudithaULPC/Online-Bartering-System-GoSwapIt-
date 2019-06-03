<?php

class helpTicketController
{
	
    function saveHelpTicket($data)
    {
        $data       =   (object)$data;
        $Result     =   helpTicket::save($data);
        
        echo json_encode($Result);
    }
    
    function allTickets($data)
    {
       
        $Result     =   helpTicket::searchAll();
        echo json_encode($Result);
    }
    
    function search($data)
    {
        $data       =   (object)$data;
        $Result     =   helpTicket::search($data->ht_id);
        echo json_encode($Result);
    }
    
    function close($data)
    {
        $data       =   (object)$data;
        $Result     =   helpTicket::close($data->ht_id);
        echo json_encode($Result);
    }
    
    function displayTickets($data)
    {
        $data       =   (object)$data;
        $Result     =   helpTicket::searchAllByUser($data->us_id);
        echo json_encode($Result);
    }
    
}