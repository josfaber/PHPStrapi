<?php

namespace JF\PHPStrapi;

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

	function __construct($strapi_url, $token = null)
	{
		$this->strapi_url = $strapi_url;
		$this->token = $token;
	}

	function toString()
	{
		return "StrapiClient: {$this->strapi_url}";
	}
}
