<?php
namespace DarioSartori;
class Session
{	
	public function __construct()
	{
		$this->create();
	}
	
	public function create()
	{
		session_start();
	}
	
	public function destroy()
	{
		session_unset();
	}
	
	public function regenerateId()
	{
		session_regenerate_id(true);
	}
	
	public function isSet(string $varName)
	{
		return isset($_SESSION[$varName]);
	}
	
	public function get(string $varName)
	{
		return $_SESSION[$varName];
	}
	
	public function set(string $varName, string $value)
	{
		if (isset($value))
		{
			$_SESSION[$varName] = $value;	
		}
	}
}