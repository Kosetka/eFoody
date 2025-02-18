<?php


/**
 * Cargo class
 */
class Order
{

    use Model;

    protected $table = 'orders';

    protected $allowedColumns = [
        'id',
        'u_id',
        'cookie_id',
        'date',
        'date_last',
        'status',
        'fv',
        'o_phone',
        'o_email',
        'discount',
        'id_discount_code',
        'discount_amount',
        'fv_id',
        'expired',
        'o_description',
        'send_sms',
        'send_sms_date',
        'send_email',
        'send_email_date'
    ];

    public function getOrders()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getOrdersAwaiting($date)
    {
        $query = "select * from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59' AND status = 2;";
        return $this->query($query);
    }
    public function getOrderByCookie($id)
    {
        $query = "select * from $this->table WHERE cookie_id = '$id';";
        return $this->query($query);
    }
    public function getOrderId($id)
    {
        $query = "select * from $this->table WHERE cookie_id = '$id';";
        return $this->query($query)[0]->id;
    }

    public function getFullOrder($id)
    {
        $query = "SELECT *
              FROM order_content oc
              JOIN $this->table o ON o.id = oc.order_id WHERE o.cookie_id = '$id';";
        return $this->query($query);
    }
    public function getFullOrdersbyDate($date_from, $date_to)
    {
        $t_p = ORDER_PAYED;
        $query = "SELECT *, oc.id as oc_id
              FROM order_content oc
              JOIN $this->table o ON o.id = oc.order_id WHERE o.date >= '$date_from 00:00:00' AND o.date <= '$date_to 23:59:59' AND status IN ($t_p) ORDER BY order_id DESC;";
        return $this->query($query);
    }
    public function getFullOrdersSingleDay($date)
    {
        $t_p = ORDER_PAYED;
        $query = "SELECT *, oc.id as oc_id
              FROM order_content oc
              JOIN $this->table o ON o.id = oc.order_id WHERE oc.o_date = '$date' AND status IN ($t_p) ORDER BY order_id DESC;";
        return $this->query($query);
    }
    public function getFullOrderById($id)
    {
        $query = "SELECT *
              FROM order_content oc
              JOIN $this->table o ON o.id = oc.order_id WHERE o.id = '$id';";
        return $this->query($query);
    }

}