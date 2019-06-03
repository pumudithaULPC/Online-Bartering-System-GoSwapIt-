<?php

class SwapItem
{

    public $im_id;
    public $im_name;
    public $im_desc;
    public $im_img_name;
    public $ca_id;
    public $md_id;
    public $im_date;
    public $sp_id;
    public $attributes;

    public function __construct($im_id,$im_name,$im_desc,$im_img_name,$ca_id,$md_id,$im_date,$sp_id,$attributes)
    {
        $this->im_id    =   $im_id;
        $this->im_name  =   $im_name;
        $this->im_desc  =   $im_desc;
        $this->im_img_name = $im_img_name;
        $this->ca_id    =   $ca_id;
        $this->md_id    =   $md_id;
        $this->im_date  =   $im_date;
        $this->sp_id    =   $sp_id;
        $this->attributes   =   $attributes;
    }

    // Add Swap Item
    public static function save($data)
    {

        try
        {
            $db = Database::getInstance();

            $date = Master::GetDateTime();   
            
            if($data->md_id=="")
            {
                $data->md_id    = null;
            }
            
            $stmt_item = $db->prepare("INSERT INTO `gs_item`(`IM_NAME`, `IM_DESC`, `IM_IMG_NAME`, `CA_ID`, `MD_ID`, `IM_DATE`, `SP_ID`) VALUES (?,?,?,?,?,?,?)");
            $stmt_item->execute(array($data->im_name, $data->im_desc,$data->im_img_name, $data->ca_id, $data->md_id, $date, $data->sp_id));

            $attributes  =   $data->attributes;
            
            $im_id      =   $db->lastInsertId();
            
            if(count($attributes)> 0)
            {
                foreach ($attributes as $attribute)
                {
                    $id     =   $attribute->id;
                    $value  =   $attribute->value;

                    $stmt_attribute = $db->prepare("INSERT INTO `gs_item_atributes`(`IM_ID`, `AT_ID`, `IA_VALUE`) VALUES (?,?,?)");
                    $stmt_attribute->execute(array($im_id,$id,$value));
                }
            }
            
            return array('success' => true, 'message' => 'Item Saved Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    
    //Search All Items
    public static function searchAll($sp_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_item WHERE `SP_ID`='$sp_id'");

            foreach ($req->fetchAll() as $row)
            {
                $Attributes = (object)SwapItemAttribute::searchAll($row['IM_ID']);
                $Category   = Category::search($row['CA_ID']);
                $Model      = Model::search($row['MD_ID']);
                $list[] = new SwapItem($row['IM_ID'], $row['IM_NAME'], $row['IM_DESC'], $row['IM_IMG_NAME'], $Category, $Model, $row['IM_DATE'], $row['SP_ID'],$Attributes);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
    
    
    //Delete Item
    public static function delete($data)
    {
        try 
        {
            $db = Database::getInstance();
            
            
            
            $stmt_attr = $db->prepare("DELETE FROM gs_item_atributes WHERE IM_ID=:id");
            $stmt_attr->bindValue(':id', $data->im_id, PDO::PARAM_STR);
            $stmt_attr->execute();
            
            $stmt = $db->prepare("DELETE FROM gs_item WHERE IM_ID=:id");
            $stmt->bindValue(':id', $data->im_id, PDO::PARAM_STR);
            $stmt->execute();
            
            return array('success' => true, 'message' => 'Item Deleted Successfully !');
        } 
        catch (PDOException $exc) 
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    } 
    
    public static function getDefaultImage($sp_id)
    {
        try 
        {
            
            $db = Database::getInstance(); 
            $dbOperation    =   new DbOperation($db);
            
            $ResultSet      =   $dbOperation->GetResultSet("SELECT IM_IMG_NAME FROM gs_item WHERE SP_ID=? ORDER BY IM_ID DESC LIMIT 1", array($sp_id));
        
            foreach ($ResultSet as $row)
            {
                $Image = $row['IM_IMG_NAME'];
            }
            
            return $Image;
        } 
        catch (PDOException $exc) 
        {
            return null;
        }
    }
}
