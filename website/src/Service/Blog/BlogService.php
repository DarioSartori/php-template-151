<?php 
namespace DarioSartori\Service\Blog;
interface BlogService
{
	public function getPosts();
	public function uploadPost($imageTitle, $image);
}