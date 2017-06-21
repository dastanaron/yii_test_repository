<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pecom.ru/ru/calc/towns.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: bf881870-9143-9445-25c0-d3f728f18a01"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    dump(json_decode($response, true));
}


function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}