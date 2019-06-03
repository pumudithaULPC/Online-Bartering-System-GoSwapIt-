<?php

require_once('connection.php');

class Database
{

    private static $instance = NULL;

    public static function getInstance()
    {
        if (!isset(self::$instance)) 
        {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $dbconfig = self::GetConnection();
            $connection_string = $dbconfig->Driver.':host='.$dbconfig->Host.';dbname='.$dbconfig->Database.'';
            
            try
            {
                self::$instance = new PDO($connection_string, $dbconfig->Username, $dbconfig->Password, $pdo_options);
                self::$instance->exec("set names utf8");
            } 
            catch (PDOException $ex) 
            {
                self::$instance=null;
            }
        }
        
        return self::$instance;
    }
    
    public static function GetConnection()
    {
        return Connection::MainServer();
    }
}
