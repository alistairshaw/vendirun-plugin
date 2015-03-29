<?php

namespace Ambitiousdigital\Vendirun\Lib;

class PropertyApi extends BaseApi {

	function search($searchArray)
	{
		$url = 'property/search';
		$this->request($url, $searchArray);
		return $this->getResult();
	}
	/**
	 * Get All Categories from the system
	 * @return mixed
	 */
	public function getCategories()
	{
		$url = 'property/category';
		$this->request($url);
		return $this->getResult();
	}

	public function property($params)
	{
		$url = 'property/find';
		$this->request($url, $params);
		return $this->getResult();
	}

	public function addToFavourite($params)
	{
		$url = 'property/add_favourite';
		$this->request($url, $params, true);
		return $this->getResult();
	}

	public function removeFavourite($params)
	{
		$url = 'property/remove_favourite';
		$this->request($url, $params, true);
		return $this->getResult();
	}

	public function getFavourite($params)
	{
		$url = 'property/get_favourite';
		$this->request($url, $params, true);
		return $this->getResult();
	}

} 