<?php


/**
 * warehouseaccess class
 */
class WarehouseAccessModel
{

    use Model;

    protected $table = 'warehouse_access';

    protected $allowedColumns = [
        'wa_id',
        'u_id',
        'w_id'
    ];
    public function delete($u_id, $id = null)
    {

        $query = "delete from $this->table where u_id = $u_id";
        $this->query($query);

        return false;
    }
}