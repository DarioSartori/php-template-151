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
  private $gameService;
  private $factory;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, BlogService $blogService, $factory)
  {
     $this->template = $template;
     $this->gameService = $blogService;
     $this->factory = $factory;
  }
  
  public function showBlog(){
  	echo $this->template->render("blog.html.twig");
  }
  
  public function getPosts(){
  	$posts = "Sorry, hadn't enough time to make the blog. Here are some Pictures: ".$this->blogService->getPosts();
  	echo $this->template->render("blog.html.twig", ["posts" => $posts]);
  }
}