<?php


/**
 * Cargo class
 */
class Helperhistory
{

    use Model;

    protected $table = 'helper_for';

    protected $allowedColumns = [
        'id',
        'u_id',
        'date_from',
        'date_to',
        'date',
        'helper_for'
    ];

    public function getUser($u_id)
    {
        $query = "select * from $this->table WHERE u_id = $u_id;";
        return $this->query($query);
    }
    public function getLast($u_id)
    {
        $query = "select * from $this->table WHERE u_id = $u_id ORDER BY date DESC, id DESC LIMIT 1;";
        return $this->query($query);
    }
    public function getLastHelpers($date = null)
    {
        // Ustaw domyślną datę na dzisiejszą, jeśli nie jest podana
        if ($date === null) {
            $date = date("Y-m-d");
        }

        $query = "
            SELECT *
            FROM $this->table AS t1
            WHERE  t1.date = (
                SELECT MAX(t2.date)
                FROM $this->table AS t2
                WHERE t2.u_id = t1.u_id
            )
            AND (
                (t1.date_from IS NULL OR t1.date_from <= '$date')
                AND (t1.date_to IS NULL OR t1.date_to >= '$date')
            )
            ORDER BY t1.date DESC, t1.id DESC;
        ";

        return $this->query($query);
    }

}