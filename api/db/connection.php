<?php

class Connection
{

    public $Driver;
    public $Host;
    public $Database;
    public $Username;
    public $Password;
    public $Type;

    public function __construct($Driver,$Host,$Database,$Username,$Password,$Type)
    {
        $this->Driver   = $Driver;
        $this->Host     = $Host;
        $this->Database = $Database;
        $this->Username = $Username;
        $this->Password = $Password;
        $this->Type     = $Type;
    }

    public static function MainServer()
    {
        # Main Server
        
        $db_host      = 'localhost';
        $db_user      = 'sandupa_gsuser';
        $db_pass      = 'rFwuwhhCrMsJu7lKLT';
        $db_name      = 'sandupa_goswapit';
        
        return new Connection("mysql", $db_host, $db_name,  $db_user, $db_pass, 'main');
    }
}

?>