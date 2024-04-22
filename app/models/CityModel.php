<?php


/**
 * City class
 */
class CityModel
{

    use Model;

    protected $table = 'cities';

    protected $allowedColumns = [
        'c_name',
        'c_fullname',
        'c_description',
        'c_active'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['c_name'])) {
            $this->errors['c_name'] = "Tag miasta jest wymagany.";
        }

        if (empty($data['c_fullname'])) {
            $this->errors['c_fullname'] = "Pełna nazwa miasta jest wymagana.";
        }

        $city = new CityModel;
        $temp["c_name"] = $_POST['c_name'];

        $row = $city->first($temp);
        if ($row) {
            $this->errors['c_name_exists'] = "Taki TAG miasta już widnieje w bazie danych.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getCities(): array
    {
        $this->city = [];
        $array = [];
        $cities = new RolesNameModel;
        $arr = $cities->getAll($this->table);

        foreach ($arr as $city) {
            //foreach ($role as $r) {
            $city = (array) $city;
            $array[] = (array) $city;
            //}
        }
        $this->cities = $array;
        //show($array);
        return $array;
    }
}