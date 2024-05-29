<?php

/**
 * login class
 */
class Login
{
	use Controller;

	public function index()
	{
		if (!empty($_SESSION['USER']))
			redirect('home');

		$data = [];

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$user = new User;
			$arr['email'] = $_POST['email'];

			$row = $user->first($arr);

			if ($row) {
				if ($row->password === $_POST['password']) {
					if ($row->active === 1) {
						$_SESSION['USER'] = $row;
						$role = new RolesNameModel;

						$temp = $role->getOne('roles_name', $row->u_role);
						$tarr["ROLE"] = (object) ["id" => $temp[0]->id, "role_name" => $temp[0]->role_name, "role_description" => $temp[0]->role_description, "r_active" => $temp[0]->r_active];
						$_SESSION['ROLE'] = $tarr["ROLE"];
						$l_access = new Linksaccess;
						if(!empty($l_access->getAccessByRole($_SESSION['ROLE']->id))) {
							foreach($l_access->getAccessByRole($_SESSION['ROLE']->id) as $l_a) {
								$data["access"][$l_a->l_id] = $l_a->l_id;
							}
						}

						$links = new Linksmodel();
						foreach ($links->getLinks() as $link) {
							if(in_array($link->id, $data["access"])) {
								$temp_links[$link->id] = (array) $link;
							}
						}
						$hierarchy = buildHierarchy($temp_links);
						$_SESSION["links"] = $hierarchy;

						//ograniczyć do dostępnych oddziałów
						$user_id = $_SESSION['USER']->id;
						$cities = new Shared();
						$query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city INNER JOIN warehouse_access as a ON a.w_id = w.id WHERE u_id = $user_id ORDER BY a.w_id ASC";
						$temp["cities"] = $cities->query($query);
						foreach ($temp["cities"] as $city) {
							$data[$city->id] = (array) $city;
						}
						$_SESSION['CITIES'] = $data;


						redirect('home');
					} else {
						$user->errors['email'] = "Twoje konto jest zablokowane!";
					}
				} else {
					$user->errors['email'] = "Błędne adres e-mail lub hasło!";
				}
			} else {
				$user->errors['email'] = "Logowanie nieudane!";
			}

			$data['errors'] = $user->errors;
		}

		$this->view('login', $data);
	}

}
