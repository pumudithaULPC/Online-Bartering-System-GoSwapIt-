<?php

class Session
{

    protected $sessionID;

    public function __construct()
    {
        if (!isset($_SESSION))
        {
            $this->init_session();
        }
    }

    public function init_session()
    {
        session_start();
    }

    public function set_session_id()
    {
        $this->sessionID = session_id();
    }

    public function get_session_id()
    {
        return $this->sessionID;
    }

    public function check_parameter_exist($key)
    {
        if (isset($_SESSION[$key]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function display_session()
    {
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    public function unset_paramenter($key)
    {
        unset($_SESSION[$key]);
    }

    public function get_parameter($key)
    {
        if($this->check_parameter_exist($key))
        {
            return $_SESSION[$key];
        }
        else
        {
            return false;
        }
    }

    public function set_parameter($key, $data)
    {
        $_SESSION[$key] = $data;
    }
    
    public function destroy()
    {
        session_unset();
        session_destroy();
    }

}