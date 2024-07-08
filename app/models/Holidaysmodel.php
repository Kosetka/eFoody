<?php


/**
 * Cargo class
 */
class Holidaysmodel
{

    use Model;

    protected $table = 'holidays';

    protected $allowedColumns = [
        'id',
        'date',
        'reason'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getMonth($month, $year)
    {
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $query = "SELECT * FROM $this->table WHERE date BETWEEN '$startDate' AND '$endDate' ORDER BY date ASC;";
        
        return $this->query($query);
    }
    public function getWorkingDays($month_from, $year_from, $month_to = null, $year_to = null)
    {
        // Ustawienie wartości domyślnych dla month_to i year_to
        if ($month_to === null) {
            $month_to = $month_from;
        }
        if ($year_to === null) {
            $year_to = $year_from;
        }
        
        // Tworzenie zapytania SQL
        $query = "SELECT * FROM $this->table WHERE ";
        $query .= "YEAR(date) >= $year_from AND YEAR(date) <= $year_to AND MONTH(date) >= $month_from AND MONTH(date) <= $month_to ";

        $que = [];
        foreach($this->query($query) as $day) {
            $date_obj = explode("-", $day->date);
            $year = $date_obj[0];
            $month = $date_obj[1];
            if($month[0] === "0") {
                $month = substr($month, 1);
            }
            if(!isset($que[$year][$month])) {
                $que[$year][$month] = 0;
            }
            if(!isset($que[$year][$year])) {
                $que[$year][$year] = 0;
            }
            $que[$year][$month] += 1;
            $que[$year][$year] += 1;
            
        }
        return $que;
    }
}