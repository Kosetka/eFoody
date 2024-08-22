<?php


/**
 * Cargo class
 */
class Cardvisit
{

    use Model;

    protected $table = 'card_visit';

    protected $allowedColumns = [
        'id',
        'date',
        'w_id',
        'date_now'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }

    public function getOffline()
    {
        $query = "WITH RecentData AS (
            SELECT
                date,
                w_id,
                LEAD(date) OVER (PARTITION BY w_id ORDER BY date) AS next_date
            FROM
                $this->table
            WHERE
                date >= NOW() - INTERVAL 7 DAY
        ),
        Breaks AS (
            SELECT
                w_id,
                date AS break_start,
                next_date AS break_end
            FROM
                RecentData
            WHERE
                TIMESTAMPDIFF(SECOND, date, next_date) > 120
        )
        SELECT
            w_id,
            break_start,
            break_end
        FROM
            Breaks
        ORDER BY
            w_id, break_start;";

        return $this->query($query);
    }

    public function getStatus()
    {
        $query = "WITH RankedRecords AS (
            SELECT
                w_id,
                date,
                ROW_NUMBER() OVER (PARTITION BY w_id ORDER BY date DESC) AS rn
            FROM
                $this->table
        )
        SELECT
            w_id,
            date
        FROM
            RankedRecords
        WHERE
            rn = 1;";

        return $this->query($query);
    }
    
}