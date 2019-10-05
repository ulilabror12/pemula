<?php
function request($url,$data,$header,$rheader=null)
    {
    $ch = curl_init();
    $headers = [];
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   // curl_setopt($ch, CURLOPT_VERBOSE, 1);
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
    function($curl, $header) use (&$headers)
    {
    $len = strlen($header);
    $header = explode(':', $header, 2);
    if (count($header) < 2) // ignore invalid headers
    return $len;
    
    $headers[strtolower(trim($header[0]))][] = trim($header[1]);
    
    return $len;
    }
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //curl_setopt($ch, CURLOPT_USERAGENT, "okhttp/3.10.0");
    $page =curl_exec($ch) or die(curl_error($ch));
    if($rheader==null)
       {
        return $page;
       }
    else
       {
        return [$headers,$page];
       };
    }
function encodejwt($data)
    {
       $header = json_encode(['typ'=>'JWT','alg'=>'HS256']);
       // Encode header menjadi Base64Url String
       $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
       
       // Buat Array payload ladlu convert menjadi JSON
       $payload = json_encode($data);
       // Encode Payload menjadi Base64Url String
       $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));	
       
       // Buat Signature dengan metode HMAC256
       $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'secretkey', true);
       // Encode Signature menjadi Base64Url String
       $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
       
       // Gabungkan header, payload dan signature dengan tanda titik (.)
       $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
       return $jwt;
    ;}
function requestc($url,$data,$header,$method,$rheader=null)
    {
    $ch = curl_init();
    $headers = [];
    curl_setopt($ch, CURLOPT_URL, 'https://'.$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
    function($curl, $header) use (&$headers)
    {
    $len = strlen($header);
    $header = explode(':', $header, 2);
    if (count($header) < 2) // ignore invalid headers
    return $len;
    
    $headers[strtolower(trim($header[0]))][] = trim($header[1]);
    
    return $len;
    }
    );
    //if($data!=null){
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($ch, CURLOPT_VERBOSE, 1);
  //  curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //curl_setopt($ch, CURLOPT_USERAGENT, "okhttp/3.10.0");
    $page =curl_exec($ch) or die(curl_error($ch));
    if($rheader==null)
       {
         return $page;
       }
    else
       {
         return $headers;
       }
    }
function decodejwt($token)
    {
       list($header, $payload, $signature) = explode (".", $token);   
       return json_decode(base64_decode($payload),true);
    }
