<?php
namespace DarioSartori\Controller;

use DarioSartori\SimpleTemplateEngine;
use DarioSartori\Service\Login\LoginService;
use DarioSartori\AntiforgeryTokenManager;

class LoginController
{
	/**
	 * @var DarioSartori\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	/**
	 * @var DarioSartori\Service\Login\LoginService
	 */
	private $loginService;

	private $factory;	

	private $antiforgeryTokenManager;

	/**
	 * @param DarioSartori\SimpleTemplateEngine
	 */
	public function __construct(\Twig_Environment $template, LoginService $loginService, $factory, AntiforgeryTokenManager $antiforgeryTokenManager)
	{
		$this->template = $template;
		$this->loginService = $loginService;
		$this->factory = $factory;
		$this->antiforgeryTokenManager = $antiforgeryTokenManager;
	}
	public function showLogin($username = "", $error = "")
	{
		$antiforgeryToken = $this->antiforgeryTokenManager->generateNewToken();
		echo $this->template->render("login.html.twig", ["antiforgeryToken" => $antiforgeryToken, "username" => $username, "error" => $error]);
	}

	public function showRegister($email = "", $username = "", $error = "")
	{
		$antiforgeryToken = $this->antiforgeryTokenManager->generateNewToken();
		session_regenerate_id();
		echo $this->template->render("register.html.twig", ["antiforgeryToken" => $antiforgeryToken, "email" => $email, "username" => $username, "error" => $error] );
	}

	public function login(array $data)
	{
		if ($this->antiforgeryTokenManager->validate($data["antiforgeryToken"])
				&& isset($data["antiforgeryToken"]))
		{
			if (!array_key_exists("username", $data) OR !array_key_exists("password", $data)) {
				$this->showLogin();
				return;
			}
			 
			$error = "";
			if(!isset($data["username"]) || trim($data["username"] == ''))
			{
				$error = $error." Please enter a username!";
			}
			if(!isset($data["password"]) || trim($data["password"] == ''))
			{
				$error = $error." Please enter a password!";
			}
			if(!$this->loginService->authenticate($data["username"], $data["password"]) && (!isset($error) || trim($error == '')))
			{
				$error = $error ." Username or password is wrong!";
			}
			 
			if(!isset($error) || trim($error == '')) {
				session_regenerate_id();
				$_SESSION["username"] = $data["username"];
				$_SESSION["LoggedIn"] = true;
				header("Location: /blog");
				echo $this->template->render("blog.html.twig", [
						"username" => $data["username"]
				]);
			} else {
				echo $this->showLogin($data["username"], $error);
			}
		}
	}

	public function logout()
	{
		session_destroy();
		header("Location: /");
		return;
	}

	public function register(array $data)
	{
		if ($this->antiforgeryTokenManager->validate($data["antiforgeryToken"])
				&& isset($data["antiforgeryToken"]))
		{
			$error = "";
			// Check if everything is entered
			if(!isset($data["email"]) || trim($data["email"] == ''))
			{
				$error = $error." Please enter a email!";
			}
			if(!isset($data["username"]) || trim($data["username"] == ''))
			{
				$error = $error." Please enter a username!";
			}
			if(!isset($data["password"]) || trim($data["password"] == ''))
			{
				$error = $error." Please enter a password!";
			}
			if ($this->loginService->existsEmail($data["email"]))
			{
				$error = $error." This Email is already in use!";
			}
			if(!isset($error) || trim($error == ''))
			{
				//$passwordhash = password_hash($data["password"], PASSWORD_DEFAULT);
				$this->loginService->createUser($data["username"], $data["email"], $data["password"]);
				$this->login($data);
				return;
			}
			echo $this->showRegister($data["email"], $data["username"], $error);
		}
	}
}