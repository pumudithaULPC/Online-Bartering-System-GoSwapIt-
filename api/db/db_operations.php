<?php

class DbOperation
{
    public $dbInstance;
    
    public function __construct($dbInstance)
    {
        $this->dbInstance   =   $dbInstance;
    }
    
    //Extract Single Value From a Table
    public function ExtractValue($table, $field, $searchFeild, $searchValue)
    {
        $stmt   =   $this->dbInstance->prepare("SELECT `" . $field . "` FROM `" . $table . "` WHERE `" . $searchFeild . "` = ? ");
        $stmt->execute(array($searchValue));
        $result =   $stmt->fetch();
        $value =    $result[$field];
        return $value;
    }
    
    //Get Result Set of a SQL
    public function GetResultSet($sql,$values)
    {
        $stmt  =   $this->dbInstance->prepare($sql);
        $stmt->execute($values);
        $result =   $stmt->fetchAll();
        return $result;
    }
    
    //Check Value is Exists on a Table
    function CheckValueExists($table, $field, $searchvalue, $otherConditions="") 
    {
        $query = $this->dbInstance->query("SELECT " . $field . " FROM " . $table . " WHERE " . $field . " = '" . $searchvalue . "' " . $otherConditions . "");
        $result =   $query->fetch();
        $value =    $result[$field];

        if ($value == null || $value=="")
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
