<?php

class Request
{
	
	public static function ProcessRequest($controller,$action,$data)
	{
		
		$url	=	"http://api.goswapit.store";
                $val 	=	array(
                    "controller"  => $controller, 
                    "action" => $action,
                    "data" => json_encode($data)
		);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$val);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);
                curl_close($ch);
		return  $response;
		
	}
}

?>