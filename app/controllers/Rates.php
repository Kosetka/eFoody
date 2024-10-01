<?php

/**
 * GetCargo class
 */
class Rates
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('rates', $data);
    }

    public function generate()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $month = 9;
        $year = 2024;

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $roles = new RolesNameModel();
        foreach ($roles->getAllRoles() as $role) {
            $data["roles"][$role->id] = $role;
        }

        $users = new User;
        foreach ($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $rates = new Payrate();
        foreach ($rates->getRates($month, $year) as $rate) {
            $data["rates"][$rate->u_id][] = $rate;
        }


        $workhour = new Workhours();
        if (!empty($workhour->getMonth($month, $year))) {
            foreach ($workhour->getMonth($month, $year) as $wh) {
                $data["accepted"][$wh->date][$wh->u_id] = $wh;
                if (!isset($data["hours"][$wh->u_id])) {
                    $data["hours"][$wh->u_id] = 0;
                }
                $data["hours"][$wh->u_id] += $wh->accept_time;

                if (isset($data["rates"][$wh->u_id])) {
                    foreach ($data["rates"][$wh->u_id] as $rt) {
                        if ($rt->date_from <= $wh->date) {
                            if ($rt->date_to == NULL || $rt->date_to >= $wh->date) {
                                if ($rt->type == 2) {
                                    if (!isset($data["pay"][$wh->u_id])) {
                                        $data["pay"][$wh->u_id] = 0;
                                    }
                                    $data["pay"][$wh->u_id] += getPayment($wh->accept_time, $rt->rate);
                                }
                            }
                        }
                    }
                }
            }
        }
        //show($data["rates"]);
        //die;
        //show($data);
        //die;

        $this->view('rates.generate', $data);
    }

}
