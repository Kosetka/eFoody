<?php


/**
 * Cargo class
 */
class Cardriver
{

    use Model;

    protected $table = 'car_driver';

    protected $allowedColumns = [
        'id',
        'u_id',
        'car_id',
        'date_from',
        'date_to'
    ];

    public function getCarUser($id)
    {
        $query = "
            SELECT *, u.first_name, u.last_name
            FROM users u
            JOIN car_driver cu ON u.id = cu.u_id
            WHERE cu.car_id = '$id'
            AND cu.date_from <= NOW()
            AND (cu.date_to IS NULL OR cu.date_to >= NOW())
            LIMIT 1;
        ";
        return $this->query($query);
    }
    public function getCarUsers($id)
    {
        $query = "
            SELECT *, u.first_name, u.last_name
            FROM users u
            JOIN car_driver cu ON u.id = cu.u_id
            WHERE cu.car_id = '$id'
            ORDER BY date_to ASC;
        ";
        return $this->query($query);
    }
    public function getAll()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
    public function getFreeCars()
    {
        $query = "SELECT c.id, c.objectno c.active, cu.date_from, cu.date_to, cu.u_id
                FROM cars c
                LEFT JOIN car_driver cu ON c.id = cu.car_id
                WHERE c.car_id NOT IN (
                    SELECT car_id
                    FROM car_driver
                    WHERE date_to IS NULL OR date_to >= CURRENT_DATE
                );";
        return $this->query($query);
    }
    public function getUserCars($id)
    {
        $query = "select * from $this->table WHERE u_id = $id ORDER BY id DESC";
        return $this->query($query);
    }
    public function getCarInfo($id)
    {
        $query = "select * from $this->table WHERE id = $id LIMIT 1";
        return $this->query($query)[0];
    }
    public function getCarHolder($id)
    {
        $date = date("Y-m-d");
        $query = "SELECT * FROM $this->table 
          WHERE id = '$id' 
          AND ('$date' BETWEEN date_from AND IFNULL(date_to, NOW())) 
          LIMIT 1";
        return $this->query($query);
    }
    public function getLastOwner($id)
    {
        $query = "SELECT * FROM $this->table WHERE car_id = $id ORDER BY date_to ASC LIMIT 1";
        return $this->query($query);
    }

    public function getCarsWithDriversByDate($date)
    {
        $query = "
            SELECT 
                cars.*,
                users.id AS user_id,
                users.first_name,
                users.last_name
            FROM cars
            LEFT JOIN car_driver ON cars.id = car_driver.car_id 
                AND ('$date' >= car_driver.date_from AND ('$date' <= car_driver.date_to OR car_driver.date_to IS NULL))
            LEFT JOIN users ON car_driver.u_id = users.id
            ORDER BY cars.id;
        ";

        return $this->query($query);
    }

}