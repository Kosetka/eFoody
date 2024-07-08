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
        'date_from',
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
    public function getFreeCards()
    {
        $query = "SELECT c.card_id, c.status, cu.date_from, cu.date_to, cu.u_id
                FROM cards c
                LEFT JOIN card_user cu ON c.card_id = cu.card_id
                WHERE c.card_id NOT IN (
                    SELECT card_id
                    FROM card_user
                    WHERE date_to IS NULL OR date_to >= CURRENT_DATE
                );";
        return $this->query($query);
    }
    public function getUserCards($id)
    {
        $query = "select * from $this->table WHERE u_id = $id ORDER BY id DESC";
        return $this->query($query);
    }
    public function getCardInfo($id)
    {
        $query = "select * from $this->table WHERE id = $id LIMIT 1";
        return $this->query($query)[0];
    }
}