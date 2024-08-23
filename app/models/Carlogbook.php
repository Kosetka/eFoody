<?php


/**
 * Cargo class
 */
class Carlogbook
{

    use Model;

    protected $table = 'wf_logbook';

    protected $allowedColumns = [
        'id',
        'tripid',
        'objectno',
        'objectname',
        'logflag',
        'start_time',
        'start_odometer',
        'start_postext',
        'end_time',
        'end_odometer',
        'end_postext',
        'distance',
        'objectuid',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'avg_speed',
        'max_speed',
        'fuel_usage',
        'u_id',
        'flag',
        'last_update',
        'date',
        'car_id',
        'company_id',
        'after_work'

    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getTripIds()
    {
        $date = date("Y-m-d");
        $query = "select tripid from $this->table WHERE date = '$date';";
        return $this->query($query);
    }
    public function getAllByDate($date)
    {
        $query = "select * from $this->table WHERE date = '$date' AND after_work = 1 ORDER BY tripid DESC, objectno ASC;";
        return $this->query($query);
    }
    public function getAllRoute($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date >= '$date_from' AND date <= '$date_to' AND after_work = 0 ORDER BY tripid DESC, objectno ASC;";
        return $this->query($query);
    }
    public function getLastRecord($date)
    {
        // Ustawienie końcowej godziny na 23:59:59
        $endDateTime = $date . ' 23:59:59';

        $query = "
            SELECT t1.*
            FROM $this->table AS t1
            INNER JOIN (
                SELECT objectno, MAX(tripid) AS max_tripid
                FROM $this->table
                WHERE end_time <= '$endDateTime'
                GROUP BY objectno
            ) AS t2 ON t1.objectno = t2.objectno AND t1.tripid = t2.max_tripid
            WHERE t1.end_time <= '$endDateTime'
            ORDER BY t1.objectno ASC;
        ";
        
        return $this->query($query);
    }

    public function getAllAfterHour($date, $hour = 12)
    {
        $d = $date . " $hour:00:00";
        $query = "select * from $this->table WHERE start_time >= '$d' AND date = '$date' AND after_work = 0 ORDER BY tripid DESC, objectno ASC;";
        return $this->query($query);
    }
}