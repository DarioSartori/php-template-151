<?php
namespace DarioSartori\Controller;
use DarioSartori\SimpleTemplateEngine;
use DarioSartori\Service\Blog\BlogService;
class BlogController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $blogService;
  private $factory;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, BlogService $blogService, $factory)
  {
     $this->template = $template;
     $this->blogService = $blogService;
     $this->factory = $factory;
  }
  
  public function showBlog(){
  	echo $this->template->render("blog.html.twig");
  }
  
  public function getPosts(){
  	$posts = "Sorry, hadn't enough time to make the blog. Here are some Pictures: ".$this->blogService->getPosts();
  	echo $this->template->render("blog.html.twig", ["posts" => $posts]);
  }
  
  public function upload(array $data){
  	$error = "";
  	// Check if everything is entered
  	if(!isset($data["title"]) || trim($data["title"] == ''))
  	{
  		$error = $error." Please enter a title!";
  	}
  	if(!isset($data["image"]) || trim($data["image"] == ''))
  	{
  		$error = $error." Please enter a image to upload!";
  	}  
  	if(!isset($error) || trim($error == ''))
  	{
  		$this->BlogService->uploadPost($data["title"], $data["image"]);
  		$this->showBlog();
  		return;
  	}
  	echo $this->showRegister($data["title"], $data["image"], $error);
  }
}