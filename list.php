<?php

//list.php
$api_url = "http://crudusers/api/test_api.php?action=list";
header("Command: list");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
$client = curl_init($api_url);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);
echo $response;


?>