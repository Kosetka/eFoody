<?php

/**
 * signup class
 */
class Signup
{
	use Controller;

	public function index()
	{
		if (empty($_SESSION['USER']))
			redirect('login');

		$data = [];
		$roles_name = new RolesNameModel();
		$roles_name->getRoles();
		$data["roles"] = $roles_name->roles;

		$users_list = new User();

		foreach($users_list->getAllTraders("users", TRADERS) as $trader) {
			$data["users"][$trader->id] = $trader; 
		}

		$cities = new Shared();
		$query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
		$temp["cities"] = $cities->query($query);
		foreach ($temp["cities"] as $city) {
			$data["cities"][$city->id] = (array) $city;
		}

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if($_POST["u_role"]<>10) { //pomocnik handlowca
				unset($_POST["helper_for"]);
			}
			$user = new User;
			if ($user->validate($_POST)) {
				$user->insert($_POST);
				$email = $_POST["email"];
				$id = $user->getUserId($email);
				$u_warehouse = $_POST["u_warehouse"];

				$warehouse_access = new WarehouseAccessModel();
				$update_data = ["u_id" => $id, "w_id" => $u_warehouse];
				$warehouse_access->insert($update_data);

				$data['success'] = "Konto zostało pomyślnie utworzone";
				$this->view('signup', $data);
				//redirect('signup');
			}

			$data['errors'] = $user->errors;
		}

		$this->view('signup', $data);
	}

}
