<?php

/**
 * signup class
 */
class Monitor
{
	use Controller;

	public function index()
	{
		if (empty($_SESSION['USER']))
			redirect('login');

		$data = [];

		$this->view('home', $data);
	}

    public function register()
	{
		//if (empty($_SESSION['USER']))
		//	redirect('login');

		$data = [];

		$this->view('monitor.register', $data);
	}

}
