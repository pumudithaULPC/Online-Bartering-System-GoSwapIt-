<?php

class SwapItemAttribute
{

    public $ia_id;
    public $at_name;
    public $ia_value;

    public function __construct($ia_id,$at_name,$ia_value)
    {
        $this->ia_id    =   $ia_id;
        $this->at_name  =   $at_name;
        $this->ia_value =   $ia_value;
    }
    
    
    //Search All Items
    public static function searchAll($im_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_item_atributes WHERE `IM_ID`='$im_id'");

            foreach ($req->fetchAll() as $row)
            {
                $Attribute = CategoryAttributes::search($row['AT_ID']);
                
                $list[] = new SwapItemAttribute($row['IA_ID'], $Attribute->at_name, $row['IA_VALUE']);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }
}
