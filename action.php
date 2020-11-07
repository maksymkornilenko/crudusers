<?php

//action.php

if(isset($_POST["action"]))
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Command: ".$_POST["action"]);
	if($_POST["action"] == 'create')
	{
		$form_data = array(
			'nick'	=>	$_POST['nick'],
			'password'=>$_POST['password'],
			'role_id'=>	$_POST['role_id'],
			'additional_data'=>	$_POST['additional_data']
		);
		$api_url = "http://crudusers/api/test_api.php?action=create";  //change this url as per your folder path for api folder
        header("Access-Control-Allow-Methods: POST");
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_POST, true);
		curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		curl_close($client);
		$result = json_decode($response, true);
		foreach($result as $keys => $values)
		{
			if($result[$keys]['success'] == '1')
			{
                echo json_encode(['status'=>200,'msg'=>'Your record has been added successfully']);
			}
			else
			{
                echo json_encode(['status'=>500,'msg'=>'error']);
			}
		}
	}

	if($_POST["action"] == 'get')
	{
		$id = $_POST["id"];
		$api_url = "http://crudusers/api/test_api.php?action=get&id=".$id."";  //change this url as per your folder path for api folder
        header("Access-Control-Allow-Methods: GET");
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		echo $response;
	}
	if($_POST["action"] == 'update')
	{
		$form_data = array(
			'nick'=>$_POST['nick'],
			'password'=>$_POST['password'],
			'role_id'=>	$_POST['role_id'],
			'additional_data'=>$_POST['additional_data'],
			'id'=>$_POST['hidden_id']
		);
		$api_url = "http://crudusers/api/test_api.php?action=update";  //change this url as per your folder path for api folder
        header("Access-Control-Allow-Methods: PATCH");
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_POST, true);
		curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		curl_close($client);
		$result = json_decode($response, true);
		foreach($result as $keys => $values)
		{
			if($result[$keys]['success'] == '1')
			{
                echo json_encode(['status'=>200,'msg'=>'Your record has been updated successfully']);
			}
			else
			{
                echo json_encode(['status'=>500,'msg'=>'error']);
            }
		}
	}
	if($_POST["action"] == 'delete')
	{
		$id = $_POST['id'];
		$api_url = "http://crudusers/api/test_api.php?action=delete&id=".$id.""; //change this url as per your folder path for api folder
        header("Access-Control-Allow-Methods: DELETE");
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		echo $response;
	}
}


?>