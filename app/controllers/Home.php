<?php

/**
 * home class
 */
class Home
{
	use Controller;

	public function index()
	{
		$data['username'] = empty($_SESSION['USER']) ? redirect('login') : $_SESSION['USER']->email;

		$date = date("Y-m-d");
		$date_yesterday = date("Y-m-d", strtotime("yesterday"));

		$scan = new ScanModel();
		$data["created"]["today"] = $scan->getTotalProducts($date);
		$data["created"]["yesterday"] = $scan->getTotalProducts($date_yesterday);

		$scan = new Sales();
		$data["sold"]["today"] = $scan->getAllSold($date);
		$data["sold"]["yesterday"] = $scan->getAllSold($date_yesterday);

		$scan = new Sales();
		$data["companies"]["today"] = $scan->getVisited($date);
		$data["companies"]["yesterday"] = $scan->getVisited($date_yesterday);

		$scan = new Companies();
		$data["companies_added"]["today"] = $scan->getAdded($date);
		$data["companies_added"]["yesterday"] = $scan->getAdded($date_yesterday);

		$plan = new Plannerproducted();
        $data["producted_last14days"] = $plan->getLast14Days();
        


		if($_SESSION["USER"]->u_role == 1) {
			$this->view('home.role1', $data);
		} else {
			$this->view('home', $data);

		}


	}
}
