<?php


/**
 * User class
 */
class Orderdelivery
{

	use Model;

	protected $table = 'order_delivery';

	protected $allowedColumns = [
		'id',
		'order_id',
		'u_id',
		'date',
		'phone',
		'email',
		'full_name',
		'city',
		'postal_code',
		'street',
		'street_number',
		'house_number',
		'c_nip',
		'c_name',
		'c_city',
		'c_postal_code',
		'c_street',
		'c_street_number',
		'c_house_number',
		'fv_id'
	];


	public function getAll()
	{
		$query = "select * from $this->table;";
		return $this->query($query);
	}

	public function getDeliverys($u_id)
	{
		$query = "select * from $this->table WHERE u_id = $u_id";
		return $this->query($query);
	}
	public function getOrder($order_id)
	{
		$query = "select * from $this->table WHERE order_id = $order_id";
		return $this->query($query);
	}

}