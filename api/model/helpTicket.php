<?php

class helpTicket
{

    public $ht_id;
    public $us_id;
    public $ht_title;
    public $ht_message;
    public $ht_datetime;
    public $ht_status;

    public function __construct($ht_id, $us_id, $ht_title, $ht_message, $ht_datetime, $ht_status)
    {
        $this->ht_id = (int) $ht_id;
        $this->us_id = $us_id;
        $this->ht_title = $ht_title;
        $this->ht_message = $ht_message;
        $this->ht_datetime = $ht_datetime;
        $this->ht_status = $ht_status;
    }

    public static function save($data)
    {
        $Date = Master::GetDateTime();
        try
        {
            $db = Database::getInstance();
            $stmt = $db->prepare("INSERT INTO gs_help_tickets(`HT_TITLE`,`HT_MESSAGE`, `US_ID`,`HT_DATETIME`) VALUES(?,?,?,?)");
            $affected_rows = $stmt->execute(array($data->ht_title, $data->ht_message, $data->us_id, $Date));
            return array('success' => ($affected_rows > 0), 'message' => 'Message sent Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function searchAll()
    {
        $list = array();
        try
        {
            $db = Database::getInstance();
            $req = $db->query("SELECT * FROM gs_help_tickets");
            foreach ($req->fetchAll() as $row)
            {
                $list[] = new helpTicket($row['HT_ID'], $row['US_ID'], $row['HT_TITLE'], $row['HT_MESSAGE'], $row['HT_DATETIME'], $row['HT_STATUS']);
            } 
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function searchAllByUser($us_id)
    {
        $list = array();
        try
        {
            $db = Database::getInstance();
            $req = $db->query("SELECT * FROM gs_help_tickets WHERE `US_ID`='$us_id'");
            foreach ($req->fetchAll() as $row)
            {
                $User = User::SearchUserById($row['US_ID']);
                $list[] = new helpTicket($row['HT_ID'], $User, $row['HT_TITLE'], $row['HT_MESSAGE'], $row['HT_DATETIME'], $row['HT_STATUS']);
            } 
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function search($ht_id)
    {
        try
        {
            $db = Database::getInstance();
            $req = $db->query("SELECT * FROM gs_help_tickets WHERE HT_ID='$ht_id'");
            foreach ($req->fetchAll() as $row)
            {
                $User = User::SearchUserById($row['US_ID']);
                $list = new helpTicket($row['HT_ID'], $User, $row['HT_TITLE'], $row['HT_MESSAGE'], $row['HT_DATETIME'], $row['HT_STATUS']);
            } return $list;
        }
        catch (PDOException $exc)
        {
            
        }
    }

    public static function close($ht_id)
    {
        try
        {
            $db = Database::getInstance();
            $stmt = $db->prepare("UPDATE gs_help_tickets SET `HT_STATUS` = 2 WHERE `HT_ID`=?");
            $stmt->execute(array($ht_id));
            return array('success' => true, 'message' => 'Ticket Closed Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

}

?>