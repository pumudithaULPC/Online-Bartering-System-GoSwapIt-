<?php

class User 
{
    public $us_id;
    public $us_username;
    public $us_email;
    public $us_password;
    public $us_type;
    public $us_contact_no;
    public $us_status;
    
    public function __construct($us_id, $us_username, $us_email,$us_password,$us_type,$us_contact_no,$us_status)
    {
        $this->us_id                 =   $us_id;
        $this->us_username           =   $us_username;
        $this->us_email              =   $us_email;
        $this->us_password           =   $us_password;
        $this->us_type               =   $us_type;
        $this->us_contact_no         =   $us_contact_no;
        $this->us_status             =   $us_status;
    }
    
    public static function checkUserExists($username)
    {
        $db = Database::getInstance();
        
        $dbOperation    =   new DbOperation($db);
        $UserExists     =   $dbOperation->CheckValueExists("gs_user", "US_USERNAME", $username, "");
        
        return $UserExists;
    }
    
    public static function resetPassword($username)
    {
        if(self::checkUserExists($username))
        {
            try
            {
                $db = Database::getInstance(); 
                
                $User = self::SearchUser($username);

                $NewPassword = Master::GenerateRandomNumber(10);

                $Email       = $User->us_email;
                $UserId      = $User->us_id;

                $statement_user     =   $db->prepare("UPDATE `gs_user` SET `US_PASSWORD`=? WHERE `US_ID`=?");
                $statement_user->execute(array(md5($NewPassword),$UserId));
                
                Master::SendEmail("New Passowrd for GoSwapIt",$Email,"Your new password is : ".$NewPassword,"");

                return array('success' => true,'message' => "New password has been mailed !");
            }
            catch (PDOException $e) 
            {
                return array('success' => false, 'message' => $e->getMessage());
            } 
        }
        else
        {
            return array('success' => false,'message' => "INVALID_USERNAME");
        }
    }
    
    public static function authenticate($username,$password,$us_type)
    {  
        if(self::checkUserExists($username))
        {
            $data       =   User::SearchUser($username);
            
            try
            {
                if($us_type!= $data->us_type)
                {
                    throw new Exception("ACCESS_DENIND");
                }
                
                if($data->us_password != md5($password))
                {
                    throw new Exception("INVALID_PASSWORD");
                }
                
                return array('success' => true, 'message' => "AUTHENTICATED", 'user' => $data);
            } 
            catch (Exception $e) 
            {
                return array('success' => false, 'message' => $e->getMessage());
            } 
        }
        else
        {
            return array('success' => false,'message' => "INVALID_USERNAME");
        }
    }
    
    public static function SearchUser($username)
    {
        $db = Database::getInstance(); 
        $dbOperation    =   new DbOperation($db);
        
        $ResultSet      =   $dbOperation->GetResultSet("SELECT * FROM gs_user WHERE US_USERNAME=?", array($username));
        
        foreach ($ResultSet as $row)
        {
            $User = new User($row['US_ID'],$row['US_USERNAME'],$row['US_EMAIL'],$row['US_PASSWORD'],$row['US_TYPE'],$row['US_CONTACT_NO'],$row['US_STATUS']);
        }
        
        return $User;
    }
    
    public static function SearchUserById($us_id)
    {
        $db = Database::getInstance(); 
        $dbOperation    =   new DbOperation($db);
        
        $ResultSet      =   $dbOperation->GetResultSet("SELECT * FROM gs_user WHERE US_ID=?", array($us_id));
        
        foreach ($ResultSet as $row)
        {
            $User = new User($row['US_ID'],$row['US_USERNAME'],$row['US_EMAIL'],'',$row['US_TYPE'],$row['US_CONTACT_NO'],$row['US_STATUS']);
        }
        
        return $User;
    }
    
}
