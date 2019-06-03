<?php

class InquiryReply
{

    public $spir_id;
    public $spi_id;
    public $us_id;
    public $spir_datetime;
    public $spir_text;

    public function __construct($spir_id, $spi_id, $us_id, $spir_datetime, $spir_text)
    {
        $this->spir_id = (int) $spir_id;
        $this->spi_id = $spi_id;
        $this->us_id = $us_id;
        $this->spir_datetime = $spir_datetime;
        $this->spir_text = $spir_text;
    }

    public static function SearchAll($spi_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_swap_inquiry_replys WHERE SPI_ID='$spi_id' ORDER BY SPIR_DATETIME DESC");

            foreach ($req->fetchAll() as $row)
            {
                $User = User::SearchUserById($row['US_ID']);
                $list[] = new InquiryReply($row['SPIR_ID'], $row['SPI_ID'], $User, $row['SPIR_DATETIME'], $row['SPIR_TEXT']);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function save($data)
    {
        try
        {
            $db = Database::getInstance();

            $datetime = Master::GetDateTime();

            $stmt = $db->prepare("INSERT INTO `gs_swap_inquiry_replys`( `SPI_ID`,`US_ID`, `SPIR_DATETIME`, `SPIR_TEXT`) VALUES (?,?,?,?)");
            $stmt->execute(array($data->spi_id, $data->us_id, $datetime, $data->spir_text));

            return array('success' => true, 'message' => 'Reply sent successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

}

?>
