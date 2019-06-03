<?php

class Admin extends User
{
    public $us_nic_no;
    
    public function __construct($us_id, $us_username, $us_email,$us_password,$us_type,$us_contact_no,$us_status,$nic_no)
    {
        $this->us_id                 =   $us_id;
        $this->us_username           =   $us_username;
        $this->us_email              =   $us_email;
        $this->us_password           =   $us_password;
        $this->us_type               =   $us_type;
        $this->us_contact_no         =   $us_contact_no;
        $this->us_status             =   $us_status;
        $this->us_nic_no             =   $nic_no;
    }
    
    public static function authenticateadmin($data)
    {
        $data   =   (object) $data;
        return User::authenticate($data->username, $data->password, 1);
    }
    
    public static function CreateAdmin($data)
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
                $statement_user->execute(array($data->us_username,$data->us_email,md5($data->us_password),1,$data->us_contact_no,$data->us_status));

                $us_id         =   $db->lastInsertId();

                $statement_admin  =   $db->prepare("INSERT INTO `gs_user_admin`(`US_ID`, `US_NIC_NO`) VALUES (?,?)");
                $statement_admin->execute(array($us_id,$data->us_nic_no));


                return array('success' => true,'message' => "Administrator Added Successfully !");  
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

                $statement_user     =   $db->prepare("UPDATE `gs_user` SET `US_EMAIL`=?, `US_CONTACT_NO`=?, `US_STATUS`=? WHERE `US_ID`=?");
                $statement_user->execute(array($data->us_email,$data->us_contact_no,$data->us_status,$data->us_id));

                $statement_admin  =   $db->prepare("UPDATE `gs_user_admin` SET `US_NIC_NO`=? WHERE `US_ID`=?");
                $statement_admin->execute(array($data->us_nic_no,$data->us_id));


                return array('success' => true,'message' => "Administretor Updated Successfully !");  
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
            
            $req = $db->query("SELECT * FROM gs_user_admin admin, gs_user user WHERE admin.US_ID=user.US_ID");
            
            foreach ($req->fetchAll() as $row)
            {               
                $list[] = new Admin($row['US_ID'],$row['US_USERNAME'],$row['US_EMAIL'],$row['US_PASSWORD'], $row['US_TYPE'],$row['US_CONTACT_NO'],$row['US_STATUS'], $row['US_NIC_NO']);
            } 
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        
        }
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }  
    }


    public static function delete($data)
    {
        
        try 
        {
            $db = Database::getInstance();
            
            $statement_admin = $db->prepare("DELETE FROM gs_user_admin WHERE US_ID=:usid");
            $statement_admin->bindValue(':usid', $data->us_id, PDO::PARAM_STR);
            $statement_admin->execute();
            
            $statement_user = $db->prepare("DELETE FROM gs_user WHERE US_ID=:usid");
            $statement_user->bindValue(':usid', $data->us_id, PDO::PARAM_STR);
            $statement_user->execute();
            
            return array('success' => true, 'message' => 'Admin Deleted Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    public static function search($UserId)
    {
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_user_admin admin, gs_user user WHERE admin.US_ID=user.US_ID AND user.US_ID='$UserId'");
            
            foreach ($req->fetchAll() as $row)
            {               
                $list = new Admin($row['US_ID'],$row['US_USERNAME'],$row['US_EMAIL'],'', $row['US_TYPE'],$row['US_CONTACT_NO'],$row['US_STATUS'], $row['US_NIC_NO']);
            } 
            
            return array('success' => true, 'result' => $list, 'message' => 'Search Complete');
        
        }
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }           
    }
  
}
