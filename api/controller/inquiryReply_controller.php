
<?php
class InquiryReplyController
{    
    function searchAll($data)
    {
        $data       =   (object)$data;
        $Result     =   InquiryReply::SearchAll($data->spi_id);
        
        echo json_encode($Result);
    }
    
    function save($data)
    {
        $data       =   (object)$data;
        $Result     =   InquiryReply::save($data);
        
        echo json_encode($Result);
    }
}



