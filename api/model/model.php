<?php

class Model
{
    public $md_id;
    public $md_name;
    public $br_id;
    
    
    public function __construct($md_id,$md_name,$br_id)
    {
        $this->md_id             	= (int)$md_id;
        $this->md_name           	=  $md_name;
        $this->br_id      	 	=  $br_id; 
    }
    
    //Search All Brands
    public static function searchAll()
    {
        $list = array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_model");

            foreach ($req->fetchAll() as $row) 
            {
                $Brand     =  Brand::search($row['BR_ID']);
                
                $list[] = new Model($row['MD_ID'], $row['MD_NAME'], $Brand);
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    public static function search($ModelId)
    {
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_model WHERE MD_ID='$ModelId'");

            foreach ($req->fetchAll() as $row) 
            {
                $Brand     =  Brand::search($row['BR_ID']);
                $list= new Model($row['MD_ID'], $row['MD_NAME'], $Brand);
            }
            
            return $list;
        } 
        catch (PDOException $exc) 
        {
           
        }
    }
    
    public static function searchByBrandId($br_id)
    {
        $list   =   array();
        
        try 
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_model WHERE BR_ID='$br_id'");

            foreach ($req->fetchAll() as $row) 
            {                
                $list[]= new Model($row['MD_ID'], $row['MD_NAME'], $row['BR_ID']);
            }
            
            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        } 
        catch (PDOException $exc) 
        {
           return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    
    // Add/Update New Brand
    public static function save($data)
    {
        
        
        try 
        {
            $db = Database::getInstance();

            //If Brand ID is balnk, insert a new brand
            if($data->md_id=="")
            {
                $stmt = $db->prepare("INSERT INTO gs_model(`MD_NAME`,`BR_ID`) VALUES(?,?)");
                $affected_rows = $stmt->execute(array($data->md_name, $data->br_id));
            }
            else
            {
                 $stmt = $db->prepare("UPDATE gs_model SET `MD_NAME`=?, `BR_ID`=? WHERE `MD_ID`=?");
                 $affected_rows = $stmt->execute(array($data->md_name, $data->br_id, $data->md_id));
            }
            
            return array('success' => ($affected_rows > 0), 'message' => 'Model Saved Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    

    //Delete Brand
    public static function delete($data)
    {
        try 
        {
            $db = Database::getInstance();
            
            $stmt = $db->prepare("DELETE FROM gs_model WHERE MD_ID=:mdid");
            $stmt->bindValue(':mdid', $data->md_id, PDO::PARAM_STR);
            $affected_rows = $stmt->execute();
            
            return array('success' => ($affected_rows > 0), 'message' => 'Model Deleted Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
 }




?>