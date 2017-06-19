<?php
namespace DarioSartori\Controller;
use DarioSartori\SimpleTemplateEngine;
class IndexController
{
	/**
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	/**
	 * @param ihrname\SimpleTemplateEngine
	 */
	public function __construct(\Twig_Environment $template)
	{
		$this->template = $template;
	}
	public function homepage() {
		echo $this->template->render("base.html.twig");
	}
	public function greet($name) {
		echo $this->template->render("hello.html.twig", ["name" => $name]);
	}

	public function showIndex($session = "") {
		echo $this->template->render("index.html.twig", ["session" => $session]);
	}
}