<?php

class TicketReply
{
    public $htr_id;
    public $ht_id;
    public $us_id;
    public $htr_datetime;
    public $htr_text;

    public function __construct($htr_id,$ht_id,$us_id,$htr_datetime,$htr_text)
    {
        $this->htr_id           = (int)$htr_id;
        $this->ht_id           	=  $ht_id;
        $this->us_id             =  $us_id;
        $this->htr_datetime      =  $htr_datetime;
        $this->htr_text         =  $htr_text;
    }
    
    public static function SearchAll($ht_id)
    {
        $list   =   array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_help_ticket_replys WHERE HT_ID='$ht_id' ORDER BY HTR_DATETIME DESC");

            foreach ($req->fetchAll() as $row) 
            {
                $User     =  User::SearchUserById($row['US_ID']);
                $list[]   =  new ticketReply($row['HTR_ID'],$row['HT_ID'],$User,$row['HTR_DATETIME'],$row['HTR_TEXT']);
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Replies Complete');

        } 
        catch (PDOException $exc) 
        {
           return array('success' => false,  'message' => $exc->getMessage());
        }
    }
    
    public static function save($data)
    {
        try 
        {
            $db = Database::getInstance();
            
            $datetime   =   Master::GetDateTime();
            
            $stmt = $db->prepare("INSERT INTO `gs_help_ticket_replys`(`HTR_ID`,`HT_ID`, `US_ID`, `HTR_DATETIME`, `HTR_TEXT`) VALUES (?,?,?,?,?)");
            $stmt->execute(array($data->htr_id, $data->ht_id, $data->us_id, $datetime,$data->htr_text));
            
            $User   =   User::SearchUserById($data->us_id);
            
            if($User->us_type==1)
            {
                $stmt_inq = $db->prepare("UPDATE gs_help_tickets SET  `HT_STATUS` = 1 WHERE `HT_ID`=?");
                $stmt_inq->execute(array($data->ht_id));
            }
          
            return array('success' => true, 'message' => 'Reply sent successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
 }




?>