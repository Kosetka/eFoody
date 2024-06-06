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
		'helper_for'
	];

	public function getAllTraders($table, $ids)
	{
		$query = "select * from $table WHERE u_role IN ($ids)";
		return $this->query($query);
	}

	public function getEmailsByRole($ids)
	{
		$query = "select email from $this->table WHERE u_role IN ($ids)";
		return $this->query($query);
	}
	public function getTraders()
	{
		$ids = TRADERS;
		$query = "select * from $this->table WHERE u_role IN ($ids)";
		return $this->query($query);
	}
	public function getMyTraders($id)
	{
		$query = "select * from $this->table WHERE id IN ($id)";
		return $this->query($query);
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