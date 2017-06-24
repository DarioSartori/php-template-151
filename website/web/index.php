<?php
error_reporting(E_ALL);
session_start();

require_once("../vendor/autoload.php");
require_once("../src/Factory.php");
use DarioSartori\Service\Login;
$factory = DarioSartori\Factory::createFromIniFile(__DIR__. "/../config.ini");

$loginService = $factory->getLoginService();

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		break;
	case "/login":
		$cnt = $factory->getLoginController();
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$cnt->login($_POST);
		} else	{
			$cnt->showLogin();
		}
		break;
	case "/register":
		$cnt = $factory->getLoginController();
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$cnt->register($_POST);
		} else	{
			$cnt->showRegister();
		}
		break;
	case "/logout":
		$cnt = $factory->getLoginController();
		$cnt->logout();
		break;
	case "/blog":
		$cnt = $factory->getBlogController();
		$cnt->showBlog();
		break;
	case "/upload":
		echo '<script>console.log("Upload")</script>';
		$cnt = $factory->getBlogController();
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$cnt->upload($_POST);
		} else	{
			$cnt->showBlog();
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		else {
			$factory->getIndexController()->showIndex();
			break;
		}
}