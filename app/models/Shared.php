<?php

/**
 * shared model
 */
class Shared
{
    use Model;

    public function getCitiesAndWarehouse()
    {
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $data = $this->query($query);
        return $data;
    }
    public function getActiveCitiesAndWarehouse()
    {
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city WHERE w_active = 1";
        $data = $this->query($query);
        return $data;
    }
    public function getFullData()
    {
        $query = "SELECT *, ps.date as ps_date, w.id as wh_id, ps.id as ps_id FROM product_scans as ps INNER JOIN products as p ON ps.p_id = p.id INNER JOIN users as u ON ps.u_id = u.id INNER JOIN warehouses as w ON ps.s_warehouse = w.id INNER JOIN cities as c ON c.id = w.id_city WHERE ps_active = 1 ORDER BY ps.date DESC LIMIT 10";
        return $this->query($query);
    }
    public function getAllScans($d)
    {
        $query = "SELECT *, ps.date as ps_date, w.id as wh_id, ps.id as ps_id FROM product_scans as ps INNER JOIN products as p ON ps.p_id = p.id INNER JOIN users as u ON ps.u_id = u.id INNER JOIN warehouses as w ON ps.s_warehouse = w.id INNER JOIN cities as c ON c.id = w.id_city WHERE ps_active = 1 $d ORDER BY ps.date DESC";
        //return $query;
        return $this->query($query);
    }


}