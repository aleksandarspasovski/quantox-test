<?php 

class Router
{
	
	function __construct()
	{
		$url = isset($_GET['url']) ? $_GET['url'] : null; 
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		if (empty($url[0])) {
			require 'controller/Home.php';
			$controller = new Home();
			$controller->index();
			return false;
		}

		$file = 'controller/' .$url[0]. '.php';
		if (file_exists($file)) {
			require $file;
		} else{
			return false;
		}
		$controller = new $url[0];
		$controller->loadModel($url[0]);

		if (isset($url[2])) {
			if (method_exists($controller, $url[1])) {
				$controller->{$url[1]}($url[2]);
			} else {
				return false;
			}
		} else{
			if (isset($url[1])) {
				if (method_exists($controller, $url[1])) {
					$controller->{$url[1]}();
				} else{
					return false;
				} 
			} else{
				$controller->index();
			}
		}
	}
}