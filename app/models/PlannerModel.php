<?php


/**
 * City class
 */
class PlannerModel
{

    use Model;

    protected $table = 'planner';

    protected $allowedColumns = [
        'id',
        'date_plan',
        'w_id',
        'p_id',
        'amount',
        'u_id',
        'date'
    ];

    public function getPlans(): array
    {
        $this->city = [];
        $array = [];
        $cities = new RolesNameModel;
        $arr = $cities->getAll($this->table);

        foreach ($arr as $city) {
            //foreach ($role as $r) {
            $city = (array) $city;
            $array[] = (array) $city;
            //}
        }
        $this->cities = $array;
        //show($array);
        return $array;
    }

    public function getAll($date)
    {
        $query = "select * from $this->table WHERE date_plan = '$date'";
        return $this->query($query);
    }
}