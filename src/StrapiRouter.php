<?php

namespace JF\PHPStrapi;

class StrapiRouter
{
	/**
	 * @var array
	 */
	protected $routes = [];

	function __construct()
	{
	}

	function addRoute($path, $template, $id)
	{
		if (!$path || !$template) {
			throw new \Exception("Invalid route");
		}

		array_push($this->routes, [
			"path" => $path,
			"template" => $template,
			"id" => $id
		]);

	}

	function getRoutes()
	{
		return $this->routes;
	}

	function toString()
	{
		return "StrapiRouter: " . json_encode($this->routes);
	}
}
