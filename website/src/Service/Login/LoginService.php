<?php
namespace DarioSartori\Service\Login;
interface LoginService
{
	public function authenticate($username, $password);
	public function existsUsername($username);
	public function existsEmail($email);
	public function activeUser($user);
	public function createUser($username, $email, $password);
}