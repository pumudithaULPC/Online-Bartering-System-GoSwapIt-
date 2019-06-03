<?php

class Category 
{
    public $ca_id;
    public $ca_name;
    public $ca_supid;
    public $ca_desc;
    public $ca_br_status;
    
    public function __construct($ca_id,$ca_name,$ca_supid,$ca_desc,$ca_br_status)
    {
        $this->ca_id             	= (int)$ca_id;
        $this->ca_name           	=  $ca_name;
        $this->ca_supid      	 	=  $ca_supid;
        $this->ca_desc              =  $ca_desc;
     	$this->ca_br_status		    =  $ca_br_status;
    }
    
    //Search All Categories
    public static function searchAll()
    {
        $list = array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_category");

            foreach ($req->fetchAll() as $row) 
            {
                if($row['CA_SUPID']!=NULL) 
                {
                    $SupCategory     =  Category::search($row['CA_SUPID']);
                }
                else
                {
                    $SupCategory     =  NULL;
                }
                               
                $list[] = new Category($row['CA_ID'], $row['CA_NAME'], $SupCategory , $row['CA_DESC'], $row['CA_BR_STATUS']);
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function search($CategoryId)
    {
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_category WHERE CA_ID='$CategoryId'");

            foreach ($req->fetchAll() as $row) 
            {                
                $list= new Category($row['CA_ID'], $row['CA_NAME'], $row['CA_SUPID'] , $row['CA_DESC'], $row['CA_BR_STATUS']);
            }
            
            return $list;
        } 
        catch (PDOException $exc) 
        {
           
        }
    }
    
    //Load Super Categories for Combo Box
    public static function loadSuperCategories()
    {
        $list = array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT CA_ID,CA_NAME FROM gs_category");

            foreach ($req->fetchAll() as $row) 
            {                
                $list[] = new Category($row['CA_ID'], $row['CA_NAME'], '' , '', '');
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'Load Combo Completed');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    public static function loadCategoriesforBrand()
    {
        $list = array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT CA_ID,CA_NAME FROM gs_category WHERE CA_BR_STATUS=1");

            foreach ($req->fetchAll() as $row) 
            {                
                $list[] = new Category($row['CA_ID'], $row['CA_NAME'], '' , '', '');
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'Load Combo Completed');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    // Add/Update New Category
    public static function save($data)
    {
        if($data->ca_supid=="")
        {
            $data->ca_supid = NULL;
        }
        
        try 
        {
            $db = Database::getInstance();

            //If Category ID is balnk, insert a new category
            if($data->ca_id=="")
            {
                $stmt = $db->prepare("INSERT INTO gs_category(`CA_NAME`,`CA_SUPID`,`CA_DESC`,`CA_BR_STATUS`) VALUES(?,?,?,?)");
                $affected_rows = $stmt->execute(array($data->ca_name, $data->ca_supid, $data->ca_desc,$data->ca_br_status));
            }
            else
            {
                 $stmt = $db->prepare("UPDATE gs_category SET `CA_NAME`=?, `CA_SUPID`=?, `CA_DESC`=?, `CA_BR_STATUS`=? WHERE `CA_ID`=?");
                 $affected_rows = $stmt->execute(array($data->ca_name, $data->ca_supid, $data->ca_desc,$data->ca_br_status,$data->ca_id));
            }
            
            return array('success' => ($affected_rows > 0), 'message' => 'Category Saved Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    

    //Delete Category
    public static function delete($data)
    {
        try 
        {
            $db = Database::getInstance();
            
            $stmt = $db->prepare("DELETE FROM gs_category WHERE CA_ID=:caid");
            $stmt->bindValue(':caid', $data->ca_id, PDO::PARAM_STR);
            $affected_rows = $stmt->execute();
            
            return array('success' => ($affected_rows > 0), 'message' => 'Category Deleted Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
 }




?>