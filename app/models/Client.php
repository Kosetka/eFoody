<?php


/**
 * User class
 */
class Client
{

    use Model;

    protected $table = 'clients';

    protected $allowedColumns = [
        'id',
        'email',
        'password',
        'phone',
        'first_name',
        'last_name',
        'full_name',
        'active',
        'city',
        'postal_code',
        'street',
        'street_number',
        'house_number',
        'date',
        'c_nip',
        'c_name',
        'c_city',
        'c_postal_code',
        'c_street',
        'c_street_number',
        'c_house_number',
        'want_register',
        'verified',
        'return_points',
        'session_id',
        'reset_time',
        'new_password'
    ];


    public function getAllUsers()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getUserBySession($id)
	{
		$query = "select * from $this->table WHERE `session_id` = '$id'";
		return $this->query($query)[0];
	}
    public function getUser($id)
    {
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query)[0];
    }
    public function getUserByEmail($email)
    {
        $query = "select * from $this->table WHERE email = '$email'";
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
        if (empty($data['password2'])) {
            $this->errors['password2'] = "Hasło jest wymagane.";
        } else {
            if ($data['password'] <> $data['password2']) {
                $this->errors['password'] = "Hasło muszą być jednakowe.";
            }
        }

        if (empty($data['agreements']['zg3'])) {
            $this->errors['terms'] = "Zaakceptuj regulamin.";
        }

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "Imię jest wymagane.";
        }

        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Nazwisko jest wymagane.";
        }

        if (empty($data['phone'])) {
            $this->errors['phone'] = "Numer telefonu jest wymagany.";
        }


        $user = new Client;
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