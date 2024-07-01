<?php

/**
 * GetCargo class
 */
class Holidays
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $holi = new Holidaysmodel();
            if(isset($_POST["delete"]) ) {
                $holi->delete($_POST["date"],"date");
            } else {
                $holi->delete($_POST["date"],"date");
                $holi->insert(["date" => $_POST["date"], "reason" => $_POST["reason"]]);
            }
        }

        $holidays = new Holidaysmodel();
        $data["holidays"] = $holidays->getAll();

        $data["month"] = $holidays->getWorkingDays(1,2024, 12);

        $this->view('holidays', $data);
    }

    public function generateFreeDays() {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $year = $URL[2];
        }
        ///holidays/generateFreeDays/2024 <- generuje wolne dni dla podanego roku

        $holi = new Holidaysmodel();
        $weekends = getWeekends($year);
        foreach ($weekends as $weekend) {
            $date = $weekend['date'];
            $reason = $weekend['reason'];
            $holi->insert(["date" => $date, "reason" => "$reason"]);
        }
        redirect('holidays');
    }
}
