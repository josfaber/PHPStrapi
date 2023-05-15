<?php

namespace JF\PHPStrapi;

use JF\PHPStrapi\StrapiClient;

class StrapiProxy
{
	/**
	 * @var StrapiClient
	 */
	protected $client;


	function __construct(StrapiClient $client)
	{
		$this->client = $client;
	}

	function getCollection($collectionName, $params = [])
	{
		$params["fields"] = ["slug", "template", "parent"];
		$params["parent"]["populate"][] = ["slug", "template", "parent"];
		$url = $this->client->getStrapiUrl() . '/api/' . $collectionName . '?' . http_build_query($params);
!d($url);
		return $this->request($url);
	}

	protected function request($url)
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
		return "StrapiProxy";
	}
}
