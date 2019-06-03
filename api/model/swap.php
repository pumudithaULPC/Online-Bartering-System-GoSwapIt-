<?php

class Swap
{

    public $sp_id;
    public $sp_name;
    public $sp_posted_date;
    public $sp_expire_date;
    public $sp_pub_status;
    public $sp_status;
    public $sp_us_id;
    public $sp_default_img;

    public function __construct($sp_id, $sp_name, $sp_posted_date, $sp_expire_date, $sp_pub_status, $sp_status, $sp_us_id,$sp_default_img)
    {
        $this->sp_id = (int) $sp_id;
        $this->sp_name = $sp_name;
        $this->sp_posted_date = $sp_posted_date;
        $this->sp_expire_date = $sp_expire_date;
        $this->sp_pub_status = $sp_pub_status;
        $this->sp_status = $sp_status;
        $this->sp_us_id = $sp_us_id;
        $this->sp_default_img = $sp_default_img;
    }

    
    public static function completeSwap($sp_id)
    {

        try
        {
            $db = Database::getInstance();
            
            $stmt = $db->prepare("UPDATE gs_swaps SET `SP_STATUS`=? WHERE `SP_ID`=?");
            $stmt->execute(array(1, $sp_id));

            return array('success' => true, 'message' => 'Swap Completed Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    // Add/Update Swap
    public static function save($data)
    {

        try
        {
            $db = Database::getInstance();

            $date = Master::GetDateTime();

            $expire_date = date('Y-m-d H:i:s', strtotime('+30 days', time()));

            if ($data->sp_id == null)
            {
                $stmt = $db->prepare("INSERT INTO gs_swaps(`SP_NAME`,`SP_POSTED_DATE`,`SP_EXPIRE_DATE`,`SP_PUB_STATUS`,`SP_STATUS`,`SP_US_ID`) VALUES(?,?,?,?,?,?)");
                $stmt->execute(array($data->sp_name, $date, $expire_date, 1, 0, $data->sp_us_id));

                $sp_id = $db->lastInsertId();
            }
            else
            {
                $stmt = $db->prepare("UPDATE gs_swaps SET `SP_NAME`=?,`SP_POSTED_DATE`=?,`SP_EXPIRE_DATE`=? WHERE `SP_ID`=?");
                $stmt->execute(array($data->sp_name, $date, $expire_date, $data->sp_id));

                $sp_id = $data->sp_id;
            }

            return array('success' => true, 'message' => 'Swap Saved Successfully !', 'sp_id' => $sp_id);
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    //Search All Swaps
    public static function searchAll()
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_swaps WHERE `SP_STATUS`=1");

            foreach ($req->fetchAll() as $row)
            {
                $defaultimg = SwapItem::getDefaultImage($row['SP_ID']);
                $user = User::SearchUserById($row['SP_US_ID']);
                $list[] = new Swap($row['SP_ID'], $row['SP_NAME'], $row['SP_POSTED_DATE'], $row['SP_EXPIRE_DATE'], $row['SP_PUB_STATUS'], $row['SP_STATUS'], $user,$defaultimg);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    //Search Swaps by User ID
    public static function searchByUserID($us_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_swaps WHERE `SP_US_ID`='$us_id' AND `SP_STATUS`!=0");

            foreach ($req->fetchAll() as $row)
            {
                if ($row['SP_STATUS']!=0)
                {
                $defaultimg = SwapItem::getDefaultImage($row['SP_ID']);
                $user = User::SearchUserById($row['SP_US_ID']);
                $list[] = new Swap($row['SP_ID'], $row['SP_NAME'], $row['SP_POSTED_DATE'], $row['SP_EXPIRE_DATE'], $row['SP_PUB_STATUS'], $row['SP_STATUS'], $user,$defaultimg);
                }
                
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    //Load my swaps combo
    public static function loadMySwaps($us_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_swaps WHERE `SP_US_ID`='$us_id' AND `SP_STATUS`=1");

            foreach ($req->fetchAll() as $row)
            {
                $defaultimg = SwapItem::getDefaultImage($row['SP_ID']);
                $user = User::SearchUserById($row['SP_US_ID']);
                $list[] = new Swap($row['SP_ID'], $row['SP_NAME'], $row['SP_POSTED_DATE'], $row['SP_EXPIRE_DATE'], $row['SP_PUB_STATUS'], $row['SP_STATUS'], $user,$defaultimg);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    //Search Swaps by User ID
    public static function searchIncompletedSwaps($us_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_swaps WHERE `SP_US_ID`='$us_id' AND `SP_STATUS`=0 ORDER BY SP_ID DESC LIMIT 1");

            foreach ($req->fetchAll() as $row)
            {
                $defaultimg = SwapItem::getDefaultImage($row['SP_ID']);
                $user = User::SearchUserById($row['SP_US_ID']);
                $list[] = new Swap($row['SP_ID'], $row['SP_NAME'], $row['SP_POSTED_DATE'], $row['SP_EXPIRE_DATE'], $row['SP_PUB_STATUS'], $row['SP_STATUS'], $user,$defaultimg);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    //single search for swaps to be used for single swapview.
    public static function search($sp_id)
    {

        try
        {

            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_swaps WHERE SP_ID='$sp_id'");

            foreach ($req->fetchAll() as $row)
            {
                $defaultimg = SwapItem::getDefaultImage($row['SP_ID']);
                $User = User::SearchUserById($row['SP_US_ID']);
                $list = new Swap($row['SP_ID'], $row['SP_NAME'], $row['SP_POSTED_DATE'], $row['SP_EXPIRE_DATE'], $row['SP_PUB_STATUS'], $row['SP_STATUS'],$User,$defaultimg);
            }

            return $list;
        }
        catch (PDOException $exc)
        {
            
        }
    }

}

?>
