<?php
namespace DarioSartori;
class AntiforgeryTokenManager
{
	private $session;
	
	public function __construct(Session $session)
	{
		$this->session = $session;
	}
	
	public function getToken()
	{
		if ($this->hasToken())
		{
			return $this->session->get("antiforgeryToken");
		}
		return null;
	}
	
	public function generateNewToken()
	{
		$this->session->set("antiforgeryToken", bin2hex(random_bytes(8)));
		return $this->getToken();
	}
		
	public function validate(string $returnedToken)
	{
		if ($this->hasToken() && $this->getToken() == $returnedToken)
		{
			return true;
		}
		return false;
	}
	
	public function hasToken()
	{
		return $this->session->isSet("antiforgeryToken");
	}
}