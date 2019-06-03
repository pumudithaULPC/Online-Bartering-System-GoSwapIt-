<?php

class Authenticate
{

    public static function auth($data)
    {
        $result =  json_decode(Request::ProcessRequest('admin','authenticateadmin',$data));
        
        if ($result->success == true)
        {
            $Session    =    new Session();
              
            $Session->set_parameter('logged', true);
            $Session->set_parameter('us_id', $result->user->us_id);
            $Session->set_parameter('us_username', $result->user->us_username);
            $Session->set_parameter('us_type', $result->user->us_type);

            return array('success' => true, 'message' => $result->message);
        }
        else
        {
            return array('success' => false, 'message' => $result->message);
        }
    }
    
    public static function getSessionData($data)
    {
        $Session    =    new Session();
        
        $result =   array();
        $keys   =   explode(",",$data);
        
        foreach ($keys as $key) 
        {
            $value          =  $Session->get_parameter($key);
            $result[$key]   =    $value;
        }
        
        return $result;

    }
    
    public static function getSessionStatus()
    {
        $Session    =    new Session();
        return  $Session->get_parameter('logged');
    }
    
    public static function destroySession()
    {
        $Session    =    new Session();
        $Session->unset_paramenter('logged');
        $Session->unset_paramenter('us_id');
        $Session->unset_paramenter('us_username');
        $Session->unset_paramenter('us_type');
        $Session->destroy();
    }

}
