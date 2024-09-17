<?php


/**
 * Cargo class
 */
class Leafletmodel
{

    use Model;

    protected $table = 'leaflet';

    protected $allowedColumns = [
        'id',
        'img_name',
        'date',
        'date_now',
        'u_id'
    ];

    public function getLeaflets()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getLeaflet($date)
    {
        $query = "select * from $this->table WHERE date = '$date';";
        return $this->query($query);
    }

    public function getLeafletsWeekly()
    {
        $currentMonday = strtotime('last Monday');  // Bieżący poniedziałek
        $previousMonday = date('Y-m-d', strtotime('-1 week', $currentMonday));  // Poniedziałek z poprzedniego tygodnia
        $nextSunday = date('Y-m-d', strtotime('+2 weeks sunday', $currentMonday));  // Niedziela za dwa tygodnie
    
        $query = "SELECT * FROM $this->table WHERE `date` BETWEEN '$previousMonday' AND '$nextSunday';";
    
        return $this->query($query);
    }
}
