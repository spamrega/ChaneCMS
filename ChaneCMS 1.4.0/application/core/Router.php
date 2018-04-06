<?php

class Router
{
	private $routes;
	public static $location;

	public function __construct()
	{
		$this -> routes = include(ROOT . '/core/routes.php');
	}
	
	/*
		Получение URI
	*/
	private function getURI()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			$new_uri = trim($_SERVER['REQUEST_URI'], '/');
			if ($new_uri === '') {
				$new_uri = '/';
			}
			return $new_uri;
		}
	}
	
	public function run()
	{
		$uri = $this -> getURI();
		if ($uri !== '/') {
			foreach ($this -> routes as $uriPattern => $path) {
				if (preg_match("~$uriPattern~", $uri)) {
					
					$localRoute = preg_replace("~$uriPattern~", $path, $uri);
					
					$segments = explode('/', $localRoute);
				
					$controllerName = array_shift($segments) . 'Controller';
					$actionName = 'action' . ucfirst(array_shift($segments));
					
					$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
					
					if (file_exists($controllerFile)) {
						include_once($controllerFile);
					}

					$this::$location = $uri;

					$controllerObject = new $controllerName;
					$result = $controllerObject -> $actionName($segments);
					
					if ($result != null) {
						break;
					}
				}
			}
		} else {
			$controllerName = 'indexController';
			$actionName = 'actionIndex';
					
			$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
					
			include_once($controllerFile);
					
			$controllerObject = new $controllerName;
			$result = $controllerObject -> $actionName();
		}
		
		if ($result === null) {
			Router::page404();
		}
	}
	
	public static function redirect ($location) 
	{
		header('Location: ' . $location);
		die('Location: ' . $location);
	}
	
	public static function page404 () 
	{
		$controllerFile = ROOT . '/controllers/error_404.php';
		include_once($controllerFile);
		
		$errorController = new errorController;
		$errorController -> actionError();
	}
}