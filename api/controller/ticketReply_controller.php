<?php

class TicketReplyController
{    
    function searchAll($data)
    {
        $data       =   (object)$data;
        $Result     =   ticketReply::SearchAll($data->ht_id);
        
        echo json_encode($Result);
    }
    
    function save($data)
    {
        $data       =   (object)$data;
        $Result     =   ticketReply::save($data);
        
        echo json_encode($Result);
    }
}


