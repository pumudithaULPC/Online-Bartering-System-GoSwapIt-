<?php

class Offer
{

    public $of_id;
    public $of_from_sp_id;
    public $of_to_sp_id;
    public $of_datetime;
    public $of_status;
    public $of_st_changed_datetime_;

    public function __construct($of_id, $of_from_sp_id, $of_to_sp_id, $of_datetime, $of_status, $of_st_changed_datetime_)
    {
        $this->of_id = $of_id;
        $this->of_from_sp_id = $of_from_sp_id;
        $this->of_to_sp_id = $of_to_sp_id;
        $this->of_datetime = $of_datetime;
        $this->of_status = $of_status;
        $this->of_st_changed_datetime_ = $of_st_changed_datetime_;
    }

    //Search All Categories
    public static function searchAll($us_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM `gs_offers`,`gs_swaps` WHERE `gs_offers`.`OF_FROM_SP_ID`=`gs_swaps`.`SP_ID` AND `gs_swaps`.`SP_US_ID`='$us_id' UNION SELECT * FROM `gs_offers`,`gs_swaps` WHERE `gs_offers`.`OF_TO_SP_ID`=`gs_swaps`.`SP_ID` AND `gs_swaps`.`SP_US_ID`='$us_id'");

            foreach ($req->fetchAll() as $row)
            {
                $FromSwap = Swap::search($row['OF_FROM_SP_ID']);
                $ToSwap = Swap::search($row['OF_TO_SP_ID']);

                $list[] = new Offer($row['OF_ID'], $FromSwap, $ToSwap, $row['OF_DATETIME'], $row['OF_STATUS'], $row['OF_ST_CHANGED_DATETIME']);
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
            $date = Master::GetDateTime();
            
            $result = $db->prepare("SELECT COUNT(*) FROM `gs_offers` WHERE `OF_FROM_SP_ID`='$data->of_from_sp_id' AND `OF_TO_SP_ID`='$data->of_to_sp_id'"); 
            $result->execute(); 
            $number_of_rows = $result->fetchColumn(); 
            
            if($number_of_rows > 0)
            {
                //Already offered
                throw new Exception("You have already offered to this Swap !");
            }
            
            $stmt = $db->prepare("INSERT INTO `gs_offers`(`OF_FROM_SP_ID`, `OF_TO_SP_ID`, `OF_DATETIME`, `OF_STATUS`) VALUES (?,?,?,?)");
            $stmt->execute(array($data->of_from_sp_id, $data->of_to_sp_id, $date,0));

            return array('success' => true, 'message' => 'Offer Saved Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
        catch (Exception $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    public static function accept($of_id)
    {

        try
        {
            $db = Database::getInstance();
            $dbOperation    =   new DbOperation($db);
            $date = Master::GetDateTime();
            
            //Get Swap ID
            $sp_to_id          =   $dbOperation->ExtractValue("gs_offers","OF_TO_SP_ID","OF_ID",$of_id);
            $sp_fr_id          =   $dbOperation->ExtractValue("gs_offers","OF_FROM_SP_ID","OF_ID",$of_id);

            //Close All Offers
            $stmt_close_from = $db->prepare("UPDATE `gs_offers` SET `OF_STATUS`=?,`OF_ST_CHANGED_DATETIME`=? WHERE `OF_TO_SP_ID`=? OR `OF_FROM_SP_ID`=?");
            $stmt_close_from->execute(array(3,$date,$sp_fr_id,$sp_fr_id));
            
            $stmt_close_to = $db->prepare("UPDATE `gs_offers` SET `OF_STATUS`=? ,`OF_ST_CHANGED_DATETIME`=? WHERE `OF_TO_SP_ID`=? OR `OF_FROM_SP_ID`=?");
            $stmt_close_to->execute(array(3,$date,$sp_to_id,$sp_to_id));

            
            //Accept Offer
            $stmt_accept = $db->prepare("UPDATE `gs_offers` SET `OF_STATUS`=?, `OF_ST_CHANGED_DATETIME`=? WHERE `OF_ID`=?");
            $stmt_accept->execute(array(1,$date,$of_id));
            
            //Process Swap
            $stmt_swap_to = $db->prepare("UPDATE `gs_swaps` SET `SP_STATUS`=?  WHERE `SP_ID`=?");
            $stmt_swap_to->execute(array(2,$sp_to_id));
            
            $stmt_swap_fr = $db->prepare("UPDATE `gs_swaps` SET `SP_STATUS`=?  WHERE `SP_ID`=?");
            $stmt_swap_fr->execute(array(2,$sp_fr_id));
            
            return array('success' => true, 'message' => 'Offer Accepted Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    public static function reject($of_id)
    {

        try
        {
            $db = Database::getInstance();
            
            $date = Master::GetDateTime();
            
            //Accept Offer
            $stmt_reject = $db->prepare("UPDATE `gs_offers` SET `OF_STATUS`=?, `OF_ST_CHANGED_DATETIME`=? WHERE `OF_ID`=?");
            $stmt_reject->execute(array(2,$date,$of_id));
            
            return array('success' => true, 'message' => 'Offer Rejected Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

}
