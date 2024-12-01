<?php


/**
 * Cargo class
 */
class Companiestocheck
{

    use Model;

    protected $table = 'companies_to_check';

    protected $allowedColumns = [
        'id',
        'address',
        'street',
        'street_number',
        'postal_code',
        'city',
        'phone_number',
        'website',
        'rating',
        'latitude',
        'longitude',
        'type',
        'u_id',
        'status',
        'visit_date',
        'date',
        'name',
        'description',
        'to_delete',
        'moved'
    ];

    public function getCompanies()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getCompaniesActive()
    {
        $query = "select * from $this->table WHERE to_delete <> 1 OR to_delete IS NULL;";
        return $this->query($query);
    }
    public function getCompany($id)
    {
        $query = "select * from $this->table WHERE id = $id;";
        return $this->query($query);
    }
    public function getCompaniesVisited()
    {
        $query = "select * from $this->table WHERE status != 0 ORDER BY visit_date DESC;";
        return $this->query($query);
    }
    public function getCompaniesToVisit()
    {
        $query = "select * from $this->table WHERE status = 0 AND type = 'grocery_or_supermarket';";
        return $this->query($query);
    }
}