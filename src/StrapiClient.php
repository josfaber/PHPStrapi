<?php

namespace JF\PHPStrapi;

use JF\PHPStrapi\StrapiRouter;

class StrapiClient
{
	/**
	 * @var string
	 */
	protected $strapi_url;

	/**
	 * @var string
	 */
	protected $token;

	/**
	 * @var StrapiRouter
	 */
	protected $router;


	function __construct($strapi_url, $token = null)
	{
		$this->strapi_url = $strapi_url;
		$this->token = $token;

		$this->router = new StrapiRouter();
	}

	function routeFromCollection($collectionName, $populate = false, $slugField = "slug", $templateField = "template", $publicRoot = "/")
	{
		$url = $this->strapi_url . '/api/' . $collectionName . '?';
		$params = [];
		if ($populate) {
			$params[] = 'populate=*';
		}
		$url .= implode('&', $params);

		$results = $this->request($url);

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
					$this->router->addRoute($path, $template, $id);
				}
			}
		}

		!d(
			$this->router->getRoutes(),
		);

		return $results;
	}

	function request($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

		$results = curl_exec($curl);
		curl_close($curl);

		if ($results == false) {
			throw new \Exception("Curl error: " . curl_error($curl));
		}

		try {
			$data = json_decode($results, true);
		} catch (\Exception $e) {
			throw new \Exception("JSON error: " . $e->getMessage());
		}

		if (isset($data["error"])) {
			throw new \Exception("Strapi error: " . $data["error"]["message"]);
		}

		return $data;
	}

	function toString()
	{
		return "StrapiClient: {$this->strapi_url}";
	}
}
