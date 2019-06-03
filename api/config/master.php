<?php



class Master
{
    public static function GetDateTime()
    {
        date_default_timezone_set("Asia/Colombo"); #Set timezone
        return date("Y-m-d H:i:s");
    }
    
    public static function validateAPIKey($key)
    {
        $apikey  =   "RM6bxH5xkK9znM5LfS59QNcPTxHYYEB5Gj7LV82nZtQHv3XHQMRZrev4euWYCy9PKXYMRPdrRfX8ZzHqZNkRjSU52WBkKbhcdHvUSyjrFQpBQDsqdvhdJZ75Qt3jPNtm";
        
        if($key==$apikey)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public static function SendEmail($Subject, $To, $Body, $From)
    {
        if ($From == "")
        {
            $From = "GoSwapIt <info@goswapit.store>";
        }

        $headers = "From: " . $From . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";

        mail($To, $Subject, $Body, $headers);
    }
    
    public static function GetParameter($Name, $Method, $ValidateType)
    {
        if ($Method == 'POST')
        {
            $Param = (filter_input(INPUT_POST, $Name));
        }
        else if ($Method == 'GET')
        {
            $Param = (filter_input(INPUT_GET, $Name));
        }

        /** String Validation */
        if ($ValidateType == 'STRING')
        {
            if ($Param == NULL || $Param == "" || $Param == " ")
            {
                return false;
            }
            else
            {
                return $Param;
            }
        }
        /** Amount Validation (Amount should be not less than or equal to 0) */
        else if ($ValidateType == 'AMOUNT')
        {
            if ($Param == NULL || $Param == "" || $Param == " ")
            {
                return false;
            }
            else
            {
                $Param = filter_var($Param, FILTER_VALIDATE_FLOAT);

                if ($Param == false)
                {
                    return false;
                }
                else
                {
                    if ($Param > 0)
                    {
                        return $Param;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }
        /** Any other filter type See : http://php.net/manual/en/filter.filters.validate.php */
        else
        {
            $Param = filter_var($Param, $ValidateType);

            if ($Param == false)
            {
                return false;
            }
            else
            {
                return $Param;
            }
        }
    }
    
    public static function GetClientIP()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        {
            $ServerIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if (array_key_exists('REMOTE_ADDR', $_SERVER))
        {
            $ServerIP = $_SERVER["REMOTE_ADDR"];
        }
        else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER))
        {
            $ServerIP = $_SERVER["HTTP_CLIENT_IP"];
        }

        return $ServerIP; # Accessed IP Address
    }
    
    public static function GenerateRandomNumber($length) 
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }


    public static function CreateLOG($access, $result, $ip = NULL, $domain = NULL)
    {

        $myFile = '../access_log/file_log_' . date("n_Y") . '.josn';

        if ($ip == NULL)
        {
            $ip = self::GetClientIP();
        }

        if (!file_exists($myFile) == 1)
        {
            $log = '{ "data": []}';
            file_put_contents($myFile, $log);
        }

        $arr_data = array(); // create empty array

        try
        {
            //Get form data 
            $formdata = array(
                'User' => $ip,
                'Access' => $access,
                'Attempt' => ($result == true ? 'Success' : 'Failed'),
                'Domain' => $domain,
                'DateTime' => date("F j, Y, g:i a")
            );

            //Get data from existing json file
            $jsondata = file_get_contents($myFile);

            // converts json data into array
            $arr_data = json_decode($jsondata, true);

            // Push user data to array
            array_push($arr_data['data'], $formdata);

            //Convert updated array to JSON
            $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

            //write json data into data.json file
            if (file_put_contents($myFile, $jsondata))
            {
                // 'Data successfully saved';
            }
            else
            {
                // "error";
            }
        }
        catch (Exception $e)
        {
            // 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}