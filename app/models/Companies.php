<?php


/**
 * Companies class
 */
class Companies
{

    use Model;

    protected $table = 'companies';

    protected $allowedColumns = [
        'id',//+
        'email',//+
        'phone_number',//+
        'full_name',//+
        'contact_first_name',//+
        'contact_last_name',//+
        'city_id',//+
        'active',//+
        'guardian',//+
        'address',
        'postal_code',//+
        'city',//+
        'street',//+
        'street_number',//+
        'nip',//+
        'company_type',
        'date',
        'description',
        'latitude',
        'longitude',
        'c_type',
        'workers',
        'friendly_name'
    ];

    public function validate($data)
    {
        $this->errors = [];

        //if (empty($data['nip'])) {
        //    $this->errors['nip'] = "NIP jest wymagany.";
        //}

        //$user = new Companies;
        //$temp["nip"] = $_POST['nip'];

        //$row = $user->first($temp);
        //if ($row) {
        //    $this->errors['nip_exists'] = "Taki NIP już widnieje w bazie danych.";
        //}

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getAllCompanies($table)
    {
        $query = "select * from $table WHERE company_type = 0";
        return $this->query($query);
    }
    public function getAllShops()
    {
        $query = "select * from $this->table WHERE company_type IN (2, 3)";
        return $this->query($query);
    }
    public function getAllCompaniesBuy()
    {
        $query = "select * from $this->table WHERE company_type = 1";
        return $this->query($query);
    }
    public function getMyCompanies($u_id)
    {
        $query = "select * from $this->table WHERE company_type = 0 AND guardian = $u_id AND active = 1";
        return $this->query($query);
    }
    public function getAdded($date)
    {
        $query = "select count(*) as total from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59'";
        return $this->query($query)[0]->total;
    }

    function getCompaniesNumber() {
        $query = "SELECT 
        guardian,
        COUNT(*) AS num
    FROM 
        companies
    GROUP BY 
        guardian";
        return $this->query($query);
    }
    public function getLast()
    {
        $query = "select * from $this->table ORDER BY date DESC LIMIT 1";
        return $this->query($query);
    }
}