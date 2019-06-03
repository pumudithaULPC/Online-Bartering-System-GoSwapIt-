<?php

class Swapper extends User
{
    public $us_address;
    
    public function __construct($us_id, $us_username, $us_email,$us_password,$us_type,$us_contact_no,$us_status,$us_address)
    {
        $this->us_id                 =   $us_id;
        $this->us_username           =   $us_username;
        $this->us_email              =   $us_email;
        $this->us_password           =   $us_password;
        $this->us_type               =   $us_type;
        $this->us_contact_no         =   $us_contact_no;
        $this->us_status             =   $us_status;
        $this->us_address            =   $us_address;
    }
    
    public static function authenticateSwapper($data)
    {
        $data   =   (object) $data;
        return User::authenticate($data->us_username, $data->us_password,2);
    }
    
    public static function createSwapper($data)
    {
        
        if($data->us_id == NULL) //If User Id is null Insert a new Record
        {
            $db     =   Database::getInstance();
            
            try
            {
            
                if(parent::checkUserExists($data->us_username)==true)
                {
                    throw new Exception("USERNAME_EXISTS");
                }

                $statement_user     =   $db->prepare("INSERT INTO `gs_user`(`US_USERNAME`, `US_EMAIL`,`US_PASSWORD`,`US_TYPE`,`US_CONTACT_NO`, `US_STATUS`) VALUES (?,?,?,?,?,?)");
                $statement_user->execute(array($data->us_username,$data->us_email,md5($data->us_password),2,$data->us_contact_no,1));

                $us_id         =   $db->lastInsertId();

                $statement_swapper  =   $db->prepare("INSERT INTO `gs_user_swapper`(`US_ID`, `US_ADDRESS`) VALUES (?,?)");
                $statement_swapper->execute(array($us_id,$data->us_address));


                return array('success' => true,'message' => "Registered Successfully !");  
            } 
            catch (PDOException $e) 
            {
                return array('success' => false, 'message' => $e->getMessage());
            }
            catch (Exception $e) 
            {
                return array('success' => false, 'message' => $e->getMessage());
            }
           
        }
        else
        {
            $db     =   Database::getInstance();
            
            try
            {

                $statement_user     =   $db->prepare("UPDATE `gs_user` SET  `US_EMAIL`=?, `US_CONTACT_NO`=? WHERE `US_ID`=?");
                $statement_user->execute(array($data->us_email,$data->us_contact_no,$data->us_id));

                $statement_swapper  =   $db->prepare("UPDATE `gs_user_swapper` SET `US_ADDRESS`=? WHERE `US_ID`=?");
                $statement_swapper->execute(array($data->us_address,$data->us_id));


                return array('success' => true,'message' => "Swapper Updated Successfully !");  
            } 
            catch (PDOException $e) 
            {
                return array('success' => false, 'message' => $e->getMessage());
            }
            catch (Exception $e) 
            {
                return array('success' => false, 'message' => $e->getMessage());
            }
        }
    }
    
    public static function searchAll()
    {
        $list = array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_user_swapper, gs_user  WHERE swapper.US_ID=user.US_ID");
            
            foreach ($req->fetchAll() as $row)
            {               
                $list[] = new Swapper($row['US_ID'],$row['US_USERNAME'],$row['US_EMAIL'],$row['US_PASSWORD'], $row['US_TYPE'],$row['US_CONTACT_NO'],$row['US_STATUS'], $row['US_ADDRESS']);
            } 
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        
        }
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }  
    }
    
    public static function search($us_id)
    {
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_user_swapper swapper, gs_user user WHERE swapper.US_ID=user.US_ID AND user.US_ID='$us_id'");
            
            foreach ($req->fetchAll() as $row)
            {               
                $list = new Swapper($row['US_ID'],$row['US_USERNAME'],$row['US_EMAIL'],$row['US_PASSWORD'],$row['US_TYPE'],$row['US_CONTACT_NO'],$row['US_STATUS'], $row['US_ADDRESS']);
            } 
            
            return array('success' => true, 'result' => $list, 'message' => 'Search Complete');
        
        }
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }           
    }

}
