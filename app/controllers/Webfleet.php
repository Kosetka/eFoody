<?php

/**
 * GetCargo class
 */
class Webfleet
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('carsgps', $data);
    }
    
    public function getLive()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $api_key = new Apitokens();
        $webfleet_key = $api_key->getToken("webfleet_key");
        $webfleet_pass = $api_key->getToken("webfleet_pass");
        $webfleet_login = $api_key->getToken("webfleet_login");

        // URL API
        $apiUrl = 'https://csv.webfleet.com/extern?lang=en&account=radluks&username='.$webfleet_login.'&password='.$webfleet_pass.'&apikey='.$webfleet_key.'&';
        $endpoint = 'action=showObjectReportExtern&outputformat=json&objectgroupname=wszystkie&range_pattern=d0';
        $apiUrl .= $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        
        $vehiclesData = [];

        if(curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Dekodowanie odpowiedzi JSON
            $data = json_decode($response, true);
        
            // Sprawdzenie, czy odpowiedź zawiera pole "errorCode"
            if (isset($data['errorCode'])) {
                echo "Error: " . $data['errorCode'] . " - " . $data['errorMsg'] . "\n";
                $vf_logger = new Wflog();
                $vf_logger->insert([
                    "error_code"=> $data["errorCode"],
                    "message"=> $data["errorMsg"],
                    "endpoint"=> $endpoint,
                    "u_id"=>$_SESSION["USER"]->id,
                ]);
            } else {
                if (is_array($data)) {
                    // Przykładowe wyświetlenie danych
                    foreach ($data as $vehicle) {
                        $vehicleInfo = [
                            'Object No' => isset($vehicle['objectno']) ? $vehicle['objectno'] : 'N/A',
                            'Name' => isset($vehicle['objectname']) ? $vehicle['objectname'] : 'N/A',
                            'Classname' => isset($vehicle['objectclassname']) ? $vehicle['objectclassname'] : 'N/A',
                            'Type' => isset($vehicle['objecttype']) ? $vehicle['objecttype'] : 'N/A',
                            'Last Message ID' => isset($vehicle['lastmsgid']) ? $vehicle['lastmsgid'] : 'N/A',
                            'Deleted' => isset($vehicle['deleted']) ? ($vehicle['deleted'] ? 'Yes' : 'No') : 'N/A',
                            'Message Time' => isset($vehicle['msgtime']) ? $vehicle['msgtime'] : 'N/A',
                            'Longitude' => isset($vehicle['longitude']) ? $vehicle['longitude'] : 'N/A',
                            'Latitude' => isset($vehicle['latitude']) ? $vehicle['latitude'] : 'N/A',
                            'Position Text' => isset($vehicle['postext']) ? $vehicle['postext'] : 'N/A',
                            'Position Text Short' => isset($vehicle['postext_short']) ? $vehicle['postext_short'] : 'N/A',
                            'Status' => isset($vehicle['status']) ? $vehicle['status'] : 'N/A',
                            'Driver Current Work State' => isset($vehicle['driver_currentworkstate']) ? $vehicle['driver_currentworkstate'] : 'N/A',
                            'Co-driver Current Work State' => isset($vehicle['codriver_currentworkstate']) ? $vehicle['codriver_currentworkstate'] : 'N/A',
                            'Odometer' => isset($vehicle['odometer']) ? $vehicle['odometer'] : 'N/A',
                            'Ignition' => isset($vehicle['ignition']) ? $vehicle['ignition'] : 'N/A',
                            'Trip Mode' => isset($vehicle['tripmode']) ? $vehicle['tripmode'] : 'N/A',
                            'Standstill' => isset($vehicle['standstill']) ? $vehicle['standstill'] : 'N/A',
                            'PND Connection' => isset($vehicle['pndconn']) ? $vehicle['pndconn'] : 'N/A',
                            'Ignition Time' => isset($vehicle['ignition_time']) ? $vehicle['ignition_time'] : 'N/A',
                            'Position Time' => isset($vehicle['pos_time']) ? $vehicle['pos_time'] : 'N/A',
                            'Longitude (mdeg)' => isset($vehicle['longitude_mdeg']) ? $vehicle['longitude_mdeg'] : 'N/A',
                            'Latitude (mdeg)' => isset($vehicle['latitude_mdeg']) ? $vehicle['latitude_mdeg'] : 'N/A',
                            'Object UID' => isset($vehicle['objectuid']) ? $vehicle['objectuid'] : 'N/A',
                            'Odometer Long' => isset($vehicle['odometer_long']) ? $vehicle['odometer_long'] : 'N/A',
                            'Fuel Level (ml)' => isset($vehicle['fuellevel_milliliters']) ? $vehicle['fuellevel_milliliters'] : 'N/A',
                            'Fuel Level' => isset($vehicle['fuellevel']) ? $vehicle['fuellevel'] : 'N/A',
                        ];
                
                        // Dodanie danych pojazdu do głównej tablicy
                        $vehiclesData[] = $vehicleInfo;
                    }
                    $vf_logger = new Wflog();
                    $vf_logger->insert([
                        "error_code"=> "-1",
                        "message"=> "Successfully retrieved vehicle position.",
                        "endpoint"=> $endpoint,
                        "u_id"=>$_SESSION["USER"]->id,
                    ]);
                } else {
                    echo "Invalid response format.";
                    $vf_logger = new Wflog();
                    $vf_logger->insert([
                        "error_code"=> NULL,
                        "message"=> "Invalid response format.",
                        "endpoint"=> $endpoint,
                        "u_id"=>$_SESSION["USER"]->id,
                    ]);
                }
            }
        }
        
        curl_close($ch);
        
        show($vehiclesData);

        $veh_update = new Wfvehicleslive();

        foreach($veh_update->getFulldataByDate(date("Y-m-d")) as $vu) {
            $temp[$vu->objectno] = $vu;
        }
        //show($temp);
        //die;
        foreach($vehiclesData as $vehicle) {
            $ignition = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $vehicle['Ignition Time'])));
            $position = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $vehicle['Position Time'])));
            $veh_update->insert([
                "objectno"=> $vehicle["Object No"],
                "name"=> $vehicle["Name"],
                "longitude"=> $vehicle["Longitude"],
                "latitude"=> $vehicle["Latitude"],
                "position_text"=> $vehicle["Position Text"],
                "odometer"=> $vehicle["Odometer"],
                "ignition"=> $vehicle['Ignition'],
                "standstill"=> $vehicle['Standstill'],
                "ignition_time"=> $ignition,
                "position_time"=> $position,
                "lng"=> $vehicle["Longitude (mdeg)"]/1000000,
                "lat"=> $vehicle["Latitude (mdeg)"]/1000000,
                "odometer_long"=> $vehicle["Odometer Long"],
                "fuel_lvl_ml"=> $vehicle["Fuel Level (ml)"],
                "fuel_lvl"=> $vehicle["Fuel Level"],
                "u_id"=> $temp[$vehicle["Object No"]]->u_id,
            ]);
            
        }
        show($veh_update->getNewestData());


    }
}
