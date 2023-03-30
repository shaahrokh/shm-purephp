<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routers = [];

    public function register(string $requestMethod, string $route, Callable|array $action): self
    {
        $this->routers[$requestMethod][$route] = $action;

        return $this;
    }

	public function get(string $route, Callable|array $action): self
	{
		return $this->register('get', $route, $action);
	}

	public function post(string $route, Callable|array $action):self
	{
		return $this->register('post', $route, $action);
	}

	public function resolve(string $requestUri, string $requestMethod)
    {
		$route = explode('?', $requestUri)[0];

		$action = $this->routers[strtolower($requestMethod)][$route];

		if(!$action) {
			throw new RouteNotFoundException();
		}

		if(is_callable($action)){
			call_user_func($action);
		}
		if(is_array($action)){
			[$class, $method] = $action;

			if(class_exists($class)){
				$class = new $class();

				if(method_exists($class, $method)){
					return call_user_func_array([$class, $method], []);
				}
			}
		}

		throw new RouteNotFoundException();
    }
}