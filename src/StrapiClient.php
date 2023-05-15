<?php

namespace JF\PHPStrapi;

use JF\PHPStrapi\StrapiProxy;
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

	/**
	 * @var StrapiProxy
	 */
	protected $proxy;


	function __construct($strapi_url, $token = null)
	{
		$this->strapi_url = $strapi_url;
		
		$this->token = $token;

		$this->proxy = new StrapiProxy($this);

		$this->router = new StrapiRouter($this);
	}

	function getRouter()
	{
		return $this->router;
	}

	function getProxy()
	{
		return $this->proxy;
	}

	function getStrapiUrl()
	{
		return $this->strapi_url;
	}

	function toString()
	{
		return "StrapiClient: {$this->strapi_url}";
	}
}
