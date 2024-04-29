<?php

/**
 * Returns class
 */
class Reports
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $u_id = $_SESSION["USER"]->id;

        $users = new User;
        $data["users"] = $users->getAllTraders("users",TRADERS);

        $sales = new Sales;
        $data["sales"] = $sales->reportData("2024-04-24 00:00:00", "2024-04-24 23:59:59");
        
        $cargo = new Cargo;
        $data["cargo"] = $cargo->reportData("2024-04-24 00:00:00", "2024-04-24 23:59:59");

        $places = new PlacesModel;
        $data["places"] = $places->reportData("2024-04-24 00:00:00", "2024-04-24 23:59:59");

        $returns = new ReturnsModel;
        $data["returns"] = $returns->reportData("2024-04-24 00:00:00", "2024-04-24 23:59:59");

        $exchanges = new CargoExchange;
        $data["exchanges"] = $exchanges->reportData("2024-04-24 00:00:00", "2024-04-24 23:59:59");


        $companies = new Companies;
        foreach($companies->getCompaniesNumber() as $comp) {
            $data["companies"][$comp->guardian] = $comp->num;
        }
        


        $this->view('sales.daily', $data);
    }
}
