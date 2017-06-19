<?php 
namespace DarioSartori\Service\Game;
class BlogPdoService implements BlogService
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	public function getPosts()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM post");
		$stmt->execute();
		return $stmt->fetch()["post"];
	}
}