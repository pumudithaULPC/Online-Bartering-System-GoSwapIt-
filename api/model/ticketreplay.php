<?php

class TicketRep
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
    
    
    public static function replay($ht_id)
    {
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_help_ticket_replys WHERE HT_ID='$ht_id'");

            foreach ($req->fetchAll() as $row) 
            {                
                $list   =  new helpTicket($row['HTR_ID'], $row['HT_ID'], $row['US_ID'], $row['HTR_MESSAGE'], $row['HTR_DATETIME']);
            }
            
            return $list;
        } 
        catch (PDOException $exc) 
        {
           
        }
    }
    
    
 }




?>