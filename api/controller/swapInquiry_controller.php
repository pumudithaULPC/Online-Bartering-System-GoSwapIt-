
<?php

class swapInquiryController
{

    function saveSwapInquiry($data)
    {
        $data = (object) $data;
        $Result = SwapInquiry::save($data);
        echo json_encode($Result);
    }

    function search($data)
    {
        $data = (object) $data;
        $Result = SwapInquiry::search($data->spi_id);
        echo json_encode($Result);
    }

    function close($data)
    {
        $data = (object) $data;
        $Result = SwapInquiry::close($data->spi_id);
        echo json_encode($Result);
    }

    function searchSentInquiries($data)
    {
        $data = (object) $data;
        $Result = SwapInquiry::searchSentInquiries($data->us_id);
        echo json_encode($Result);
    }
    
    function searchReceivedInquiries($data)
    {
        $data = (object) $data;
        $Result = SwapInquiry::searchReceivedInquiries($data->us_id);
        echo json_encode($Result);
    }
    
    

}
