<?php

class Brand
{

    public $br_id;
    public $br_name;
    public $ca_id;

    public function __construct($br_id, $br_name, $ca_id)
    {
        $this->br_id = (int) $br_id;
        $this->br_name = $br_name;
        $this->ca_id = $ca_id;
    }

    //Search All Brands
    public static function searchAll()
    {
        $list = array();

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_brand");

            foreach ($req->fetchAll() as $row)
            {
                $Category = Category::search($row['CA_ID']);

                $list[] = new Brand($row['BR_ID'], $row['BR_NAME'], $Category);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'View Complete');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

    public static function search($BrandId)
    {

        try
        {
            $db = Database::getInstance();

            $req = $db->query("SELECT * FROM gs_brand WHERE BR_ID='$BrandId'");

            foreach ($req->fetchAll() as $row)
            {
                $Category = Category::search($row['CA_ID']);
                $list = new Brand($row['BR_ID'], $row['BR_NAME'], $Category);
            }

            return $list;
        }
        catch (PDOException $exc)
        {
            
        }
    }

    public static function loadBrands($ca_id)
    {
        $list = array();

        try
        {
            $db = Database::getInstance();
            
            $req = $db->query("SELECT * FROM gs_brand WHERE CA_ID='$ca_id'");
            
            foreach ($req->fetchAll() as $row)
            {
                $Category = Category::search($row['CA_ID']);
                $list[] = new Brand($row['BR_ID'], $row['BR_NAME'], $Category);
            }

            return array('success' => true, 'totalItems' => sizeof($list), 'lists' => $list, 'message' => 'Load Combo Completed');
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
            if ($data->br_id == "")
            {
                $stmt = $db->prepare("INSERT INTO gs_brand(`BR_NAME`,`CA_ID`) VALUES(?,?)");
                $affected_rows = $stmt->execute(array($data->br_name, $data->ca_id));
            }
            else
            {
                $stmt = $db->prepare("UPDATE gs_brand SET `BR_NAME`=?, `CA_ID`=? WHERE `BR_ID`=?");
                $affected_rows = $stmt->execute(array($data->br_name, $data->ca_id, $data->br_id));
            }

            return array('success' => ($affected_rows > 0), 'message' => 'Brand Saved Successfully !');
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

            $stmt = $db->prepare("DELETE FROM gs_brand WHERE BR_ID=:brid");
            $stmt->bindValue(':brid', $data->br_id, PDO::PARAM_STR);
            $affected_rows = $stmt->execute();

            return array('success' => ($affected_rows > 0), 'message' => 'Brand Deleted Successfully !');
        }
        catch (PDOException $exc)
        {
            return array('success' => false, 'message' => $exc->getMessage());
        }
    }

}

?>