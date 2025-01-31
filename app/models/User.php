<?php


/**
 * User class
 */
class User
{

	use Model;

	protected $table = 'users';

	protected $allowedColumns = [
		'id',
		'email',
		'password',
		'first_name',
		'last_name',
		'u_warehouse',
		'active',
		'u_role', 
		'phone_business',
		'phone_private',
		'camera',
		'helper_for',
		'priv_email'
	];

	public function getAllTraders($table, $ids)
	{
		$query = "select * from $table WHERE u_role IN ($ids)";
		return $this->query($query);
	}

	public function getEmailsByRole($ids)
	{
		$query = "select email, priv_email from $this->table WHERE u_role IN ($ids) AND active = 1";
		return $this->query($query);
	}
	public function getTradersOld()
	{
		$ids = TRADERS;
		$query = "select * from $this->table WHERE u_role IN ($ids)";
		return $this->query($query);
	}
	public function getTraders($date_from = null, $date_to = null)
	{
		$currentDate = date('Y-m-d');
		if (!$date_from) {
			$date_from = $currentDate;
		}
		if (!$date_to) {
			$date_to = $date_from;
		}

		$ids = TRADERS;

		$query = "
			SELECT DISTINCT u.* 
			FROM $this->table u
			JOIN user_history uh ON u.id = uh.u_id
			WHERE uh.role IN ($ids)
			AND uh.date_from <= :date_to
			AND (uh.date_to >= :date_from OR uh.date_to IS NULL)
		";

		$params = [
			':date_from' => $date_from,
			':date_to'   => $date_to
		];

		return $this->query($query, $params);
	}

	public function getAllUsers()
	{
		$query = "select * from $this->table;";
		return $this->query($query);
	}

	public function getAllDrivers()
	{
		$query = "SELECT u.*, r.role_name
			FROM $this->table AS u
			INNER JOIN roles_name AS r ON r.id = u.u_role
			WHERE u.u_role IN (3, 5, 10) ;";//AND u.active = 1
		return $this->query($query);
	}
	public function getAllDriversActive()
	{
		$query = "SELECT u.*, r.role_name
			FROM $this->table AS u
			INNER JOIN roles_name AS r ON r.id = u.u_role
			WHERE u.u_role IN (3,5,10) AND u.active = 1;";//
		return $this->query($query);
	}
	public function getAllDriverShopsActive()
	{
		$query = "SELECT u.*, r.role_name
			FROM $this->table AS u
			INNER JOIN roles_name AS r ON r.id = u.u_role
			WHERE u.u_role IN (5) AND u.active = 1;";//
		return $this->query($query);
	}
	public function getAllUsersWithRole()
	{
		$query = "SELECT u.*, r.role_name
			FROM $this->table AS u
			INNER JOIN roles_name AS r ON r.id = u.u_role";
		return $this->query($query);
	}

	public function getAllUsersSorted()
	{
		$query = "select * from $this->table ORDER BY first_name ASC;";
		return $this->query($query);
	}
	public function getActiveUsers($month, $year)
	{
		$start_date = "$year-$month-01";
        $end_date = date("Y-m-t", strtotime($start_date));

        $query = "
            SELECT * 
            FROM users as u INNER JOIN user_history as h ON u.id = h.u_id
            WHERE 
                h.date_from <= '$end_date'
                AND (h.date_to >= '$start_date' OR h.date_to IS NULL)
        ";
		return $this->query($query);
	}
	public function getAllActiveUsers()
	{
		$query = "select * from $this->table WHERE active = 1;";
		return $this->query($query);
	}
	public function getAllActiveUsersSorted()
	{
		$query = "select * from $this->table WHERE active = 1 ORDER BY u_role ASC;";
		return $this->query($query);
	}

	public function getMyTraders($id)
	{
		$query = "select * from $this->table WHERE id IN ($id)";
		return $this->query($query);
	}
	public function getUser($id)
	{
		$query = "select * from $this->table WHERE id = $id";
		return $this->query($query)[0];
	}

	public function validate($data)
	{
		$this->errors = [];

		if (empty($data['email'])) {
			$this->errors['email'] = "Adres e-mail jest wymagany.";
		} else
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$this->errors['email'] = "Adres e-mail jest nieprawidłowy.";
			}

		if (empty($data['password'])) {
			$this->errors['password'] = "Hasło jest wymagane.";
		}

		if (empty($data['terms'])) {
			$this->errors['terms'] = "Zaakceptuj regulamin.";
		}

		if (empty($data['first_name'])) {
			$this->errors['first_name'] = "Imię jest wymagane.";
		}

		if (empty($data['last_name'])) {
			$this->errors['last_name'] = "Nazwisko jest wymagane.";
		}

		if (empty($data['u_warehouse'])) {
			$this->errors['u_warehouse'] = "Wybierz prawidłowy magazyn.";
		}

		if (empty($data['u_role'])) {
			$this->errors['u_role'] = "Wybierz prawidłowe uprawnienia.";
		}
		if (empty($data['active'])) {
			$data['active'] = 0;
		}

		$user = new User;
		$temp["email"] = $_POST['email'];

		$row = $user->first($temp);
		if ($row) {
			$this->errors['email_exists'] = "Taki adres e-mail już widnieje w bazie danych.";
		}

		if (empty($this->errors)) {
			return true;
		}

		return false;
	}
}