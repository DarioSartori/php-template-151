<?php 
namespace DarioSartori\Service\Blog;
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
	public function uploadPost($imageTitle, $image)
	{
		echo "upload";
		$stmt = $this->pdo->prepare("INSERT INTO post (Title, Image, Upvotes) VALUES (?, ?, 0)");
		$stmt->bindValue(1, $imageTitle);
		$stmt->bindValue(2, $image);
		if($stmt->execute())
		{
			return true;
		}
		else
		{
			return true;
		}
	}
}