<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config("debug", true);

$includeFiles = array(
	"functions",
	"site",
	"admin-login",
	"admin-users",
	"admin-categories",
	"admin-products"
);

foreach($includeFiles as $file)
{
	require_once($file.".php");
}

$app->run();