<?php

class SwapInquiry
{

    public $spi_id;
    public $sp_id;
    public $spi_title;
    public $spi_message;
    public $spi_datetime;
    public $spi_status;
    public $spi_us_id;

    public function __construct($spi_id, $sp_id, $spi_title, $spi_message, $spi_datetime, $spi_status,$spi_us_id)
    {

        $this->spi_id = $spi_id;
        $this->sp_id = $sp_id;
        $this->spi_title = $spi_title;
        $this->spi_message = $spi_message;
        $this->spi_datetime = $spi_datetime;
        $this->spi_status = $spi_status;
        $this->spi_us_id    =   $spi_us_id;
    }

    public static function save($data)
    {

        $Date = Master::GetDateTime();
        
        try
        {
            $db = Database::getInstance();

            //If Brand ID is balnk, insert a new brand
            if ($data->spi_id == "")
            {
                $stmt = $db->prepare("INSERT INTO gs_swap_inquiry(`SPI_TITLE`,`SPI_MESSAGE`,`SP_ID`,`SPI_DATETIME`,`SPI_US_ID`) VALUES(?,?,?,?,?)");
                $affected_rows = $stmt->execute(array($data->spi_title, $data->spi_message, $data->sp_id, $Date,$data->spi_us_id));
            }


            return array('success' => ($affected_rows > 0), 'message' => 'Message sent Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function searchSentInquiries($us_id)
    {
        $list = array();
        
        try
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_swap_inquiry WHERE SPI_US_ID='$us_id'");
            
            foreach ($req->fetchAll() as $row)
            {
                $Swap   = Swap::search($row['SP_ID']);
                $list[] = new SwapInquiry($row['SPI_ID'], $Swap, $row['SPI_TITLE'], $row['SPI_MESSAGE'], $row['SPI_DATETIME'], $row['SPI_STATUS'], $row['SPI_US_ID']);
            }
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    public static function searchReceivedInquiries($us_id)
    {
        $list = array();
        
        try
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT GSIP.*, GSS.SP_ID AS SSID, GSS.SP_US_ID FROM gs_swap_inquiry GSIP, gs_swaps GSS WHERE GSIP.SP_ID = GSS.SP_ID AND GSS.SP_US_ID='$us_id'");
            
            foreach ($req->fetchAll() as $row)
            {
                $Swap   = Swap::search($row['SP_ID']);
                $list[] = new SwapInquiry($row['SPI_ID'], $Swap, $row['SPI_TITLE'], $row['SPI_MESSAGE'], $row['SPI_DATETIME'], $row['SPI_STATUS'], $row['SPI_US_ID']);
            }
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function search($spi_id)
    {
        try
        {
            $db = Database::getInstance();
            $req = $db->query("SELECT * FROM gs_swap_inquiry WHERE SPI_ID='$spi_id'");
            foreach ($req->fetchAll() as $row)
            {
                $list = new SwapInquiry($row['SPI_ID'], $row['SP_ID'], $row['SPI_TITLE'], $row['SPI_MESSAGE'], $row['SPI_DATETIME'], $row['SPI_STATUS'], $row['SPI_US_ID']);
            }
            return $list;
        }
        catch (PDOException $exc)
        {
            
        }
    }

    public static function close($spi_id)
    {
        try
        {
            $db = Database::getInstance();

            $stmt = $db->prepare("UPDATE gs_swap_inquiry SET  `SPI_STATUS` = 2 WHERE `SPI_ID`=?");
            $stmt->execute(array($spi_id));

            return array('success' => true, 'message' => 'Inquiry Closed Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

}
