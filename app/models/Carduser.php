<?php


/**
 * Cargo class
 */
class Carduser
{

    use Model;

    protected $table = 'card_user';

    protected $allowedColumns = [
        'id',
        'u_id',
        'card_id',
        'date_form',
        'date_to'
    ];

    public function getCardUser($card_id)
    {
        $query = "
            SELECT u.first_name, u.last_name
            FROM users u
            JOIN card_user cu ON u.id = cu.u_id
            WHERE cu.card_id = '$card_id'
            AND cu.date_from <= NOW()
            AND (cu.date_to IS NULL OR cu.date_to >= NOW())
            LIMIT 1;
        ";
        return $this->query($query);
    }
    public function getAll()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
    
}