<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

define("COOKIE", dirname(__FILE__). DIRECTORY_SEPARATOR . md5(uniqid(rand(), true)));

$post = json_decode(file_get_contents('php://input'));

if (!$post) {
    http_response_code(404);
    exit;
}

$ch  = curl_init();
$ret = [];

foreach ($post as $request) {
    curl_setopt($ch, CURLOPT_HEADER,         false);
    curl_setopt($ch, CURLOPT_NOBODY,         false);
    curl_setopt($ch, CURLOPT_URL,            $request->url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR,      COOKIE);
    curl_setopt($ch, CURLOPT_COOKIE,         "cookiename=0");
    curl_setopt($ch, CURLOPT_USERAGENT,      "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER,        $request->url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  "POST");
    curl_setopt($ch, CURLOPT_POST,           1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($request->body));
    
    $ret[] = curl_exec($ch);
}

echo json_encode($ret);

curl_close($ch);

@unlink(COOKIE);