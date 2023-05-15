<?php

namespace JF\PHPStrapi;

use JF\PHPStrapi\StrapiClient;

class StrapiRouter
{
	/**
	 * @var array
	 */
	protected $routes = [];

	/**
	 * @var StrapiClient
	 */
	protected $client;


	function __construct(StrapiClient $client)
	{
		$this->client = $client;
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

	function routeFromCollection($collectionName, $slugField = "slug", $templateField = "template", $publicRoot = "/")
	{
		$results = $this->client->getProxy()->getCollection($collectionName);

		!d($results);
		exit;

		if (!$results) {
			throw new \Exception("No results found for collection {$collectionName}");
		}

		if (isset($results["data"]) && count($results["data"]) > 0) {

			/**
			 * @todo fix order of path elements 
			 * @todo level deeper than 1 does not have parent, make tree first
			 */
			function buildPath($route, $prefix = "/")
			{
				$slug = $route["attributes"]["slug"];

				$path = $prefix . ($prefix == '/' ? '' : '/') . $slug;

				$parent = $route["attributes"]["parent"]["data"] ?? null;

				!d("IN", $slug, $prefix, $path, ($parent ? 'continue' : 'last'));

				if (!$parent) {
					return $path;
				}

				return buildPath($parent, $path);
			}

			foreach ($results["data"] as $route) {
				$id = $route["id"] ?? null;
				$slug = $route["attributes"][$slugField] ?? null;
				$template = $route["attributes"][$templateField] ?? "page";
				if ($slug && $template) {
					$path = buildPath($route);
					$this->addRoute($path, $template, $id);
				}
			}
		}

		!d(
			$this->getRoutes(),
		);

		return $results;
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
