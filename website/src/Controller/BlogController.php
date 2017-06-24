<?php
namespace DarioSartori\Controller;
use DarioSartori\SimpleTemplateEngine;
use DarioSartori\Service\Blog\BlogService;
use DarioSartori\AntiforgeryTokenManager;
class BlogController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $blogService;
  private $factory;
  private $antiforgeryTokenManager;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, BlogService $blogService, $factory, AntiforgeryTokenManager $antiforgeryTokenManager)
  {
     $this->template = $template;
     $this->blogService = $blogService;
     $this->factory = $factory;
     $this->antiforgeryTokenManager = $antiforgeryTokenManager;
  }
  
  public function showBlog(){  	
  	$antiforgeryToken = $this->antiforgeryTokenManager->generateNewToken();
  	echo $this->template->render("blog.html.twig", ["antiforgeryToken" => $antiforgeryToken]);
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
  	echo $this->showBlog($data["title"], $data["image"], $error);
  }
}