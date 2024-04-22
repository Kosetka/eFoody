<?php


class _404
{
	use Controller;

	public function index()
	{
		//$this->view('login'); //Do redirect to nicest webpage
		echo "404 Page not found controller";
	}
}
