<?php

class CategoryAttributes 
{
    public $at_id;
    public $at_name;
    public $ca_id;
    
    
    public function __construct($at_id,$at_name,$ca_id)
    {
        $this->at_id             	= (int)$at_id;
        $this->at_name           	=  $at_name;
        $this->ca_id      	 	=  $ca_id;
       
    }
    
    //Search All Categories
   public static function searchAll()
    {
        $list = array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_cat_atributes");

            foreach ($req->fetchAll() as $row) 
            {
                
                $Category     =  Category::search($row['CA_ID']);
                
                $list[] = new CategoryAttributes ($row['AT_ID'], $row['AT_NAME'], $Category);
            
                               
                
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function search($CategoryAttributesId)
    {
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_cat_atributes WHERE AT_ID='$CategoryAttributesId'");

            foreach ($req->fetchAll() as $row) 
            {                
                $list= new CategoryAttributes($row['AT_ID'], $row['AT_NAME'], $row['CA_ID']);
            }
            
            return $list;
        } 
        catch (PDOException $exc) 
        {
           
        }
    }
    
    //Load Super Categories for Combo Box
  /*  public static function loadSuperCategories()
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
 */  
    // Add/Update New Category
    public static function save($data)
    {
        
        try 
        {
            $db = Database::getInstance();

            //If Category ID is balnk, insert a new category
            if($data->at_id=="")
            {
                $stmt = $db->prepare("INSERT INTO gs_cat_atributes(`AT_NAME`,`CA_ID`) VALUES(?,?)");
                $affected_rows = $stmt->execute(array($data->at_name, $data->ca_id));
            }
            else
            {
                 $stmt = $db->prepare("UPDATE gs_cat_atributes SET `AT_NAME`=?, `CA_ID`=? WHERE `AT_ID`=?");
                 $affected_rows = $stmt->execute(array($data->at_name, $data->ca_id,$data->at_id));
            }
           
            return array('success' => ($affected_rows > 0), 'message' => 'Category Attributes Saved Successfully !');
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
            
            $stmt = $db->prepare("DELETE FROM gs_cat_atributes WHERE AT_ID=:atid");
            $stmt->bindValue(':atid', $data->at_id, PDO::PARAM_STR);
            $affected_rows = $stmt->execute();
            
            return array('success' => ($affected_rows > 0), 'message' => 'Category Attributes Deleted Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    } 
    
    
    public static function getAll($CategoryAttributesId)
    {
        
        try 
        {
            $list = array();
            
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_cat_atributes WHERE CA_ID='$CategoryAttributesId'");

            foreach ($req->fetchAll() as $row) 
            {                
                $list[]= new CategoryAttributes($row['AT_ID'], $row['AT_NAME'], $row['CA_ID']);
            }
            
            return array('success' => true, 'total' => sizeof($list), 'list' => $list ,'message' => 'View Complete');
        } 
        catch (PDOException $exc) 
        {
           
        }
    }
    
 }




?>
