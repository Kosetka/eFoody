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
        //if (empty($_SESSION['USER']))
            //redirect('login');

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
        
        //show($vehiclesData);

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
        //show($veh_update->getNewestData());

        $data = $veh_update->getNewestData();

        $this->view('webfleet.getlive', $data);
    }

    public function getLogbook()
    {
        //if (empty($_SESSION['USER']))
            //redirect('login');

        $temp = [];
        $todayId = [];

        $carlb = new Carlogbook();
        if(!empty($carlb->getTripIds())) {
            foreach($carlb->getTripIds() as $tid) {
                $todayId[] = $tid->tripid;
            }
        }
        //show($todayId);

        //die;
        $today = date("Y-m-d");//"2024-08-13";//date("Y-m-d");//
        $cardrivers = new Cardriver();
        foreach($cardrivers->getCarsWithDriversByDate($today) as $car) {
            $temp["cardrivers"][$car->objectno] = $car;
        }

        $holiday = new Holidaysmodel();
        if(!empty($holiday->checkToday($today))) {
            $hard_after_work = 1;
        } else {
            $hard_after_work = 0;
        }
        $flag = 0;
        $company_id = NULL;
        
        //show($temp["cardrivers"]);

        //die;
        $api_key = new Apitokens();
        $webfleet_key = $api_key->getToken("webfleet_key");
        $webfleet_pass = $api_key->getToken("webfleet_pass");
        $webfleet_login = $api_key->getToken("webfleet_login");
        // URL API
        $apiUrl = 'https://csv.webfleet.com/extern?lang=en&account=radluks&username='.$webfleet_login.'&password='.$webfleet_pass.'&apikey='.$webfleet_key.'&';
        $endpoint = 'action=showLogbook&outputformat=json&objectgroupname=wszystkie&range_pattern=d0';
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
                    "u_id"=>0,
                ]);
            } else {
                if (is_array($data)) {
                    // Przykładowe wyświetlenie danych
                    foreach ($data as $trip) {
                        $tripInfo = [
                            'tripid' => isset($trip['tripid']) ? $trip['tripid'] : 'N/A',
                            'objectno' => isset($trip['objectno']) ? $trip['objectno'] : 'N/A',
                            'objectname' => isset($trip['objectname']) ? $trip['objectname'] : 'N/A',
                            'logflag' => isset($trip['logflag']) ? $trip['logflag'] : '0',
                            'start_time' => isset($trip['start_time']) ? $trip['start_time'] : '0',
                            'start_odometer' => isset($trip['start_odometer']) ? $trip['start_odometer'] : '0',
                            'start_postext' => isset($trip['start_postext']) ? $trip['start_postext'] : '0',
                            'end_time' => isset($trip['end_time']) ? $trip['end_time'] : '0',
                            'end_odometer' => isset($trip['end_odometer']) ? $trip['end_odometer'] : '0',
                            'end_postext' => isset($trip['end_postext']) ? $trip['end_postext'] : '0',
                            'distance' => isset($trip['distance']) ? $trip['distance'] : '0',
                            'objectuid' => isset($trip['objectuid']) ? $trip['objectuid'] : 'N/A',
                            'start_latitude' => isset($trip['start_latitude']) ? $trip['start_latitude'] : '0',
                            'start_longitude' => isset($trip['start_longitude']) ? $trip['start_longitude'] : '0',
                            'end_latitude' => isset($trip['end_latitude']) ? $trip['end_latitude'] : '0',
                            'end_longitude' => isset($trip['end_longitude']) ? $trip['end_longitude'] : '0',
                            'avg_speed' => isset($trip['avg_speed']) ? $trip['avg_speed'] : '0',
                            'max_speed' => isset($trip['max_speed']) ? $trip['max_speed'] : '0',
                            'fuel_usage' => isset($trip['fuel_usage']) ? $trip['fuel_usage'] : '0'
                        ];
                        
                        $vehiclesData[] = $tripInfo;
                    }
                    $vf_logger = new Wflog();
                    $vf_logger->insert([
                        "error_code"=> "-1",
                        "message"=> "Successfully retrieved vehicle position.",
                        "endpoint"=> $endpoint,
                        "u_id"=>0,
                    ]);
                } else {
                    echo "Invalid response format.";
                    $vf_logger = new Wflog();
                    $vf_logger->insert([
                        "error_code"=> NULL,
                        "message"=> "Invalid response format.",
                        "endpoint"=> $endpoint,
                        "u_id"=>0,
                    ]);
                }
            }
        }
        
        curl_close($ch);

        $veh_insert = new Carlogbook();

        //foreach($veh_insert->getFulldataByDate(date("Y-m-d")) as $vu) {
        //    $temp[$vu->objectno] = $vu;
        //}

        foreach($vehiclesData as $trip) {
            //show($trip);
            $t_user_id = NULL;
            //show($temp["cardrivers"][$trip["objectno"]]);
            //echo "<br>";

            if(isset($temp["cardrivers"][$trip["objectno"]])) {
                $t_user_id = $temp["cardrivers"][$trip["objectno"]]->user_id;
            }
            $t_car_id = NULL;
            if(isset($temp["cardrivers"][$trip["objectno"]])) {
                $t_car_id = $temp["cardrivers"][$trip["objectno"]]->id;
            }

            //ustawienie czy podróż po pracy, później można zeminić po adresie
            if($hard_after_work == 0) {
                $datetime1 = new DateTime(date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $trip['start_time']))));
                $datetime2 = new DateTime($today);
                $datetime2->setTime(16, 0, 0); //tutaj możemy to rozbudować w przyszłości, jak na podstawie tego jak kierowcy zakończą pracę, to od tego momentu ustawiać im after_work
                if ($datetime1 > $datetime2) {
                    $after_work = 1;
                } else {
                    $after_work = 0;
                }
            } else {
                $after_work = 1;
            }
            if(!in_array($trip['tripid'], $todayId)) {
                $veh_insert->insert([
                    'tripid' => $trip['tripid'],
                    'objectno' => $trip['objectno'],
                    'objectname' => $trip['objectname'],
                    'logflag' => $trip['logflag'],
                    'start_time' => date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $trip['start_time']))),
                    'start_odometer' => $trip['start_odometer'],
                    'start_postext' => $trip['start_postext'],
                    'end_time' => date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $trip['end_time']))),
                    'end_odometer' => $trip['end_odometer'],
                    'end_postext' => $trip['end_postext'],
                    'distance' => $trip['distance'],
                    'objectuid' => $trip['objectuid'],
                    'start_latitude' => $trip['start_latitude']/1000000,
                    'start_longitude' => $trip['start_longitude']/1000000,
                    'end_latitude' => $trip['end_latitude']/1000000,
                    'end_longitude' => $trip['end_longitude']/1000000,
                    'avg_speed' => $trip['avg_speed'],
                    'max_speed' => $trip['max_speed'],
                    'fuel_usage' => $trip['fuel_usage'],
                    "u_id"=> $t_user_id ,
                    "flag"=> $flag,
                    "date"=> $today,
                    "car_id"=> $t_car_id,
                    "company_id"=> $company_id,
                    "after_work"=> $after_work,
                ]);
            } else {
                //echo "już wpisane";
            }
        }

        $this->view('webfleet.getlogbook', $temp);
    }
    public function updateAfterhourStatus() 
    {
        $today = date("Y-m-d", strtotime("-1 day"));

        $veh_insert = new Carlogbook();
        $change_work = [];
        if(!empty($veh_insert->getAllAfterHour($today))) {
            foreach($veh_insert->getAllAfterHour($today) as $rec) {
                $change_work[$rec->objectno][] = $rec;
            }
        }

        function findFirstRecordWithWernera($data) {
            foreach ($data as $record) {
                // Sprawdź, czy start_postext zawiera słowo "Wernera"
                if (stripos($record->start_postext, 'Wernera') !== false || stripos($record->start_postext, 'Rapackiego') !== false || stripos($record->start_postext, 'Barlickiego') !== false) {
                    return $record;
                }
            }
            return null;
        }
        
        
        //show($change_work);
        foreach($change_work as $car) {
            $record = findFirstRecordWithWernera($car);
            
            if ($record !== null) {
                //echo 'Znaleziono rekord: ';
                //show($record);
                $to_change = true;
                foreach($car as $rec) {
                    if($to_change == true) {
                        if($record->tripid == $rec->tripid) {
                            $to_change = false;
                        } else {
                            //tu zmienić status
                            //show($rec);
                            $veh_insert->update($rec->tripid,["after_work" => 1],"tripid");
                        }
                    }
                }
            } else {
                echo 'Nie znaleziono rekordu z "Wernera".';
            }
        }
        
        //show($change_work);
        $this->view('webfleet.getlogbook', $change_work);
    }
}
