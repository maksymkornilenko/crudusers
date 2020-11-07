<?php

include('Api.php');

$api_object = new API();

if($_GET["action"] == 'list')
{
	$data = $api_object->list();
}
if($_GET["action"] == 'options')
{
	$data = $api_object->options();
}

if($_GET["action"] == 'create')
{
	$data = $api_object->create();
}

if($_GET["action"] == 'get')
{
	$data = $api_object->get($_GET["id"]);
}

if($_GET["action"] == 'update')
{
	$data = $api_object->update();
}

if($_GET["action"] == 'delete')
{
	$data = $api_object->delete($_GET["id"]);
}

echo json_encode($data);

?>