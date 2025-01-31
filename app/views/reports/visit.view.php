<?php
$send = $data["get"]["send"];

if ($send == 2) {
    if ($data["get"]["type"] == "hour") {
        $f1 = "godzinę";
    }
    if ($data["get"]["type"] == "day") {
        $f1 = "dzień";
    }
    if ($data["get"]["type"] == "week") {
        $f1 = "zakres dat";
    }
    if ($data["get"]["type"] == "month") {
        $f1 = "miesiąc";
    }
    
    if($data["only_ours"]) {
        $date_from = "";
        $date_to = "";
        if (isset($data["date_from"])) {
            $date_from = $data["date_from"];
        }
        if (isset($data["date_to"])) {
            $date_to = $data["date_to"];
        }
    } else {
        echo '<form method="get">';
    
        echo '<h1 class="h3 mb-3 fw-normal">Wybierz ' . $f1 . ' do wyświetlenia raportu:</h1>';
        $date_from = "";
        $date_to = "";
        if (isset($data["date_from"])) {
            $date_from = $data["date_from"];
        }
        if (isset($data["date_to"])) {
            $date_to = $data["date_to"];
        }
    

    ?>
    <div class="text-start">
        <?php
        
        

            if ($data["get"]["type"] == "hour") {
                echo '  <div class="form-group row m-3">
                <label for="date_from" class="col-sm-2 col-form-label">Godzina:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="date_from" name="date_from" required>';
                for ($hour = 7; $hour < 17; $hour++) {
                    $selected = "";
                    if ($data["get"]["param1"] == $hour) {
                        $selected = "selected";
                    }
                    $hour_padded = sprintf("%02d", $hour);
                    $hour_padded_to = sprintf("%02d", $hour + 1);
                    echo '<option value="' . $hour_padded . '" ' . $selected . '>' . $hour_padded . ':00 - ' . $hour_padded_to . ':00</option>';
                }
                echo '</select>
                </div>
            </div>';
            }

            if ($data["get"]["type"] == "day") {

                echo '  <div class="form-group row m-3">
                            <label for="date_from" class="col-sm-2 col-form-label">Dzień:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="' . $date_from . '" required>
                            </div>
                        </div>';
            }
            if ($data["get"]["type"] == "week") {
                $datetime = new DateTime($data["get"]["param1"]);
                $param1 = $datetime->format('Y-m-d');
                $datetime = new DateTime($data["get"]["param2"]);
                $param2 = $datetime->format('Y-m-d');

                echo '  <div class="form-group row m-3">
                            <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="' . $param1 . '" required>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="' . $param2 . '" required>
                            </div>
                        </div>';
            }
            if ($data["get"]["type"] == "month") {
                $param1 = $data["get"]["param1"];
                $param2 = $data["get"]["param2"];

                echo '  <div class="form-group row m-3">
                <label for="date_from" class="col-sm-2 col-form-label">Miesiąc:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="date_from" name="date_from" required>';
                for ($month = 1; $month <= 12; $month++) {
                    $sel = "";
                    if ($param1 == $month) {
                        $sel = "selected";
                    }
                    echo '<option value="' . $month . '" ' . $sel . '>' . getPolishMonthName($month) . '</option>';
                }

                echo '</select>
                </div>
            </div>';

                echo '<div class="form-group row m-3">
                <label for="date_to" class="col-sm-2 col-form-label">Rok:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="date_to" name="date_to" required>';
                for ($year = 2024; $year <= 2025; $year++) {
                    $sel = "";
                    if ($param1 == $year) {
                        $sel = "selected";
                    }
                    echo '<option value="' . $year . '" ' . $sel . '>' . $year . '</option>';
                }
                echo '</select>
                </div>
            </div>';
            }
        
        ?>
        
    </div>
    <button class="w-40 btn btn-lg btn-primary" style="margin-bottom: 40px;" type="submit" name="search" value=1>Wyświetl
        raport</button>
    </form>
    <?php
    }
    ?>
    <script>
            const date = new Date();
            let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
            let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date);
            let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);

            let currentDate = `${year}-${month}-${day}`;

            <?php
            if (!isset($data["date_from"])) {
                if (!isset($param1)) {
                    echo "document.getElementById('date_from').setAttribute('value', currentDate);";
                }
            }
            if (!isset($data["date_to"])) {
                if (!isset($param2)) {
                    echo "document.getElementById('date_to').setAttribute('value', currentDate);";
                }
            }
            ?>
        </script>
    <?php
}

$name = REPORTTYPES[$data["get"]["type"]];
$dates = "";

if ($data["get"]["type"] == "hour") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $dates = $new_date_format . " - " . $data["get"]["param1"] . ":00";
}
if ($data["get"]["type"] == "day") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $dates = $new_date_format;
}
if ($data["get"]["type"] == "week") {
    $new_date_format_from = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $new_date_format_to = date("d-m-Y", strtotime($data["get"]["date_to"]));
    $dates = $new_date_format_from . " - " . $new_date_format_to;
}
if ($data["get"]["type"] == "month") {
    $month = date("F Y", strtotime($data["get"]["date_from"]));
    $dates = $month;
}
//show($data["cargo_temp"]);
$mess = "";

$prod = [];

if (isset($data["companies"])) {
    $total_comp = 0;
    $mess .= "<table style='border: 1px solid'>
        <thead style='border: 1px solid'>
            <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                <th colspan='12'>Odwiedzone firmy - $dates</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th style='border: 1px solid #000; width: 8%'>Nazwa</th>
                <th style='border: 1px solid #000; width: 8%'>Adres</th>
                <th style='border: 1px solid #000; width: 8%'>Data odwiedzin</th>
                <th style='border: 1px solid #000; width: 8%'>Status</th>
                <th style='border: 1px solid #000; width: 8%'>Opis</th>";
    if ($send == 2) {
        $mess .= "  <th style='border: 1px solid #000; width: 8%'>Akcje</th>";
    }
    $mess .= " </tr>
        </thead>
        <tbody>";
    $d_number = 1;
    if (isset($data["companies_new"])) {
        foreach ($data["companies_new"] as $kkey => $vvalue) {
            $compaid = $vvalue->id;
            if (isset($vvalue->latitude) && $vvalue->longitude) {
                if(isset($vvalue->delivery_hour) ) {
                    if($vvalue->delivery_hour == "") {
                        $vvalue->delivery_hour = 1;
                    }
                } else {
                    $vvalue->delivery_hour = 1;
                }
                $points["n" . $compaid] = [
                    "name" => $vvalue->name, 
                    "id" => $compaid, 
                    "visit_date" => "", 
                    "status_name" => "", 
                    "description" => $vvalue->description, 
                    "address" => $vvalue->address, 
                    "lat" => $vvalue->latitude, 
                    "lng" => $vvalue->longitude, 
                    "type" => $vvalue->type, 
                    "status" => 0, 
                    "visited" => "new",
                    "driver_id" => 0,
                    "driver_name" => "",
                    "delivery_time" => $vvalue->delivery_hour
                ];
            }
        }
    }
    $d_number = 1;
    if (isset($data["company_old"])) {
        foreach ($data["company_old"] as $kkey => $vvalue) {
            $compaid = $vvalue->id;
            if (isset($vvalue->latitude) && $vvalue->longitude) {
                if($vvalue->delivery_hour == "") {
                    $vvalue->delivery_hour = 1;
                }
                $driver_id = 0;
                $driver_name = "";
                if(isset($vvalue->guardian) && $vvalue->guardian <> "") {
                    if(isset($data["drivers"][$vvalue->guardian])) {
                        $driver_id = $data["drivers"][$vvalue->guardian]->int;
                        $driver_name = $data["drivers"][$vvalue->guardian]->first_name." ".$data["drivers"][$vvalue->guardian]->last_name;
                    }
                }
                $points["o" . $compaid] = [
                    "name" => $vvalue->full_name, 
                    "id" => $compaid, 
                    "visit_date" => "", 
                    "status_name" => "", 
                    "description" => $vvalue->description, 
                    "address" => "$vvalue->address", 
                    "lat" => $vvalue->latitude, 
                    "lng" => $vvalue->longitude, 
                    "type" => $vvalue->c_type, 
                    "status" => $vvalue->active, 
                    "visited" => "old",
                    "driver_id" => $driver_id,
                    "driver_name" => $driver_name,
                    "delivery_time" => $vvalue->delivery_hour
                ];
            }
        }
    }
    $d_number = 1;
    foreach ($data["companies"] as $company_id => $compval) {
        $inserted = "";
        if ($compval->inserted == 1) {
            $inserted = "<b>[NOWA]</b> ";
        }
        if ($compval->latitude == "" && $compval->longitude == "") {
            $inserted = "<span style='color: red;' title='Brak współrzędnych'>".$inserted."</span>";
        }
        if ($compval->visit_date == "0000-00-00 00:00:00" || $compval->visit_date == NULL) {
            if($compval->delivery_hour == "") {
                $compval->delivery_hour = 1;
            }
            $points[$company_id] = [
                "name" => $compval->name, 
                "visit_date" => $compval->visit_date, 
                "id" => $company_id, 
                "status_name" => COMPANYVISIT[$compval->status], 
                "description" => $compval->description, 
                "address" => $compval->address, 
                "lat" => $compval->latitude, 
                "lng" => $compval->longitude, 
                "type" => $compval->type, 
                "status" => $compval->status, 
                "visited" => "false",
                "driver_id" => 0,
                "driver_name" => "",
                "delivery_time" => $compval->delivery_hour
            ];
        } else {
            $color = '';
            if($compval->status == 2) {
                $color = "#28a745";
            } else if($compval->status == 9) {
                $color = "#ffc107";
            } else {
                $color = "#dc3545";
            }
            $mess .= "<tr style='text-align: center;'>";
            $mess .= "<td style='border: 1px solid;'>$inserted$compval->name</td>";
            $mess .= "<td style='border: 1px solid;'>$compval->address</td>";
            $mess .= "<td style='border: 1px solid;'>$compval->visit_date</td>";
            $mess .= "<td style='border: 1px solid; background-color: $color;'>" . COMPANYVISIT[$compval->status] . "</td>";
            $mess .= "<td style='border: 1px solid;'>$compval->description</td>";
            if ($send == 2) {
                $link_to_map = "https://www.google.com/maps/dir//" . $compval->latitude . "," . $compval->longitude;
                $mess .= "<td style='border: 1px solid;'><a href='$link_to_map' target='_blank'>Nawiguj</a></td>";
            }
            $mess .= "</tr>";
            $total_comp++;
            if(isset($compval->delivery_hour)) {
                if($compval->delivery_hour == "") {
                    $compval->delivery_hour = 1;
                }
            } else {
                $compval->delivery_hour = 1;
            }
            $points[$company_id] = [
                "name" => $compval->name, 
                "visit_date" => $compval->visit_date, 
                "id" => $company_id, 
                "status_name" => COMPANYVISIT[$compval->status], 
                "description" => $compval->description, 
                "address" => $compval->address, 
                "lat" => $compval->latitude, 
                "lng" => $compval->longitude, 
                "type" => $compval->type, 
                "status" => $compval->status, 
                "visited" => "true",
                "driver_id" => 0,
                "driver_name" => "",
                "delivery_time" => $compval->delivery_hour
            ];
        //driver_id: "' . $point["driver_id"] . '",
       // driver_name: "' . $point["driver_name"] . '",
        //delivery_time:
        }
    }
    
    
    $mess .= "
        </tbody>
        <tfoot>
            <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                <td style='border: 1px solid;'>ODWIEDZONE FIRMY</td>
                <td style='border: 1px solid;'>$total_comp</td>
                <td style='border: 1px solid;'></td>
                <td style='border: 1px solid;'></td>
                <td style='border: 1px solid;'></td>";
    if ($send == 2) {
        $mess .= "<td style='border: 1px solid;'></td>";
    }
    $mess .= "</tr>
        </tfoot>
    </table>";

}

//show($points);die;
if(!$data["only_ours"]) {
    echo $mess;
}

$to_send = false;
if ($mess != "") {
    $to_send = true;
}

?>



<div class="card mb-4">
    <div class="card-header">
        <h2 class="">Mapa</h2>
        <?php
            if($data["only_ours"]) {
                ?>
            <a href="<?=ROOT;?>/reports/visitmap/show/day/ours/2" class="btn btn-primary">2 Strefy</a>
            <a href="<?=ROOT;?>/reports/visitmap/show/day/ours/3" class="btn btn-primary">3 Strefy</a>
            <a href="<?=ROOT;?>/reports/visitmap/show/day/ours/4" class="btn btn-primary">4 Strefy</a>
            <button id="saveroute" class="btn btn-danger">Zapisz wybrany podział</button>
                <?php
            }
        ?>
    </div>
    <div class="form-group row m-3">
        <div class="col-sm-12">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>
</div>

<?php
    if($data["only_ours"]) {
?>

<div class="card mb-4">
    <div class="card-header">
        <h2 class="">Ilość sklepów</h2>
    </div>
    <div class="form-group row m-3">
        <div class="col-sm-12">
            <table class="table table-bordered" id="orderedProductsTable">
                <thead>
                    <tr>
                        <th>Kierowca</th>
                        <th>Ilość sklepów</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //show($points);die;
                    if(isset($data["drivers"])) {
                        $arr = [];
                        foreach($points as $point) {
                            if($point["delivery_time"] >= 2) {
                                if(!isset($arr["evening"])) {
                                    $arr["evening"] = 0;
                                }
                                $arr["evening"]++;
                            } else {
                                if(!isset($arr[$point["driver_id"]])) {
                                    $arr[$point["driver_id"]] = 0;
                                }
                                $arr[$point["driver_id"]]++;
                            }
                        }
                        foreach($data["drivers"] as $shop_id => $shop_val) {
                            echo "<tr>";
                            echo '<td>'.$shop_val->first_name.' '.$shop_val->last_name.'</td>';
                            $num_shops = 0;
                            $ttemp = "";
                            if(isset($arr[$shop_val->int])) {
                                $ttemp = $arr[$shop_val->int];
                            }
                            echo '<td>'.$ttemp.'</td>';
                            echo "</tr>";
                        }

                        echo "<tr>";
                        echo '<td>Popołudnie</td>';
                        echo '<td>'.$arr["evening"].'</td>';
                        echo "</tr>";
                        if(!isset($arr[0])) {
                            $arr[0] = 0;
                        }
                        echo "<tr>";
                        echo '<td>Brak opiekuna</td>';
                        echo '<td>'.$arr[0].'</td>';
                        echo "</tr>";
                    }
                
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header">
        <h2 class="">Szczegółowa lista</h2>
    </div>
    <div class="form-group row m-3">
        <div class="col-sm-12">
            <table class="table table-bordered" id="orderedProductsTable">
                <thead>
                    <tr>
                        <th>Nazwa sklepu</th>
                        <th>Adres</th>
                        <th>Notatka</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //show($points);die;
                    if(isset($data["drivers"])) {
                        $arr = [];
                        foreach($points as $point) {
                            if($point["delivery_time"] >= 2) {
                                if(!isset($arr["evening"])) {
                                    $arr["evening"] = 0;
                                }
                                $arr["evening"]++;
                            } else {
                                if(!isset($arr[$point["driver_id"]])) {
                                    $arr[$point["driver_id"]] = 0;
                                }
                                $arr[$point["driver_id"]]++;
                            }
                        }
                        foreach($data["drivers"] as $shop_id => $shop_val) {
                            echo "<tr>";
                            echo '<th colspan="3" style="background-color: lightgray;">'.$shop_val->first_name.' '.$shop_val->last_name.'</th>';
                            echo "</tr>";
                            
                            
                            foreach($points as $point) {
                                //show($points);die;
                                if($point["delivery_time"] < 2 && $point["driver_id"] == $shop_val->int) {
                                    echo "<tr>";
                                    echo '<td>'.$point["name"].'</td>';
                                    echo '<td>'.$point["address"].'</td>';
                                    echo '<td>'.$point["description"].'</td>';
                                    echo "</tr>";
                                } 
                            }
                        }
                        echo "<tr>";
                        echo '<th colspan="3" style="background-color: lightgray;">Popołudnie</th>';
                        echo "</tr>";
                        
                        
                        foreach($points as $point) {
                            //show($points);die;
                            if($point["delivery_time"] >= 2) {
                                echo "<tr>";
                                echo '<td>'.$point["name"].'</td>';
                                echo '<td>'.$point["address"].'</td>';
                                echo '<td>'.$point["description"].'</td>';
                                echo "</tr>";
                            } 
                        }


                        echo "<tr>";
                        echo '<th colspan="3" style="background-color: lightgray;">Brak opiekuna</th>';
                        echo "</tr>";
                        
                        
                        foreach($points as $point) {
                            //show($points);die;
                            if($point["driver_id"] == 0) {
                                echo "<tr>";
                                echo '<td>'.$point["name"].'</td>';
                                echo '<td>'.$point["address"].'</td>';
                                echo '<td>'.$point["description"].'</td>';
                                echo "</tr>";
                            } 
                        }
                    }
                
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    }
?>


<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $data["api_key"];?>&callback=initMap" async
    defer></script>
<script>
let pointsInZones = {};
const num_zones = <?php if(isset($data["zones"])) echo $data["zones"]; else echo 4;?>;
 /*    //mapa z zaznaczaniem punktów
async function initMap() {
    const { Map } = await google.maps.importLibrary("maps");

    const center = { lat: 51.40328, lng: 21.1486 };
    const map = new Map(document.getElementById("map"), {
        zoom: 15,
        center,
        mapId: "e6dc69ca24aac8ed",
    });

    let tempCoords = [];
    let tempMarkers = [];
    let tempPolygon = null;

    // Obsługa kliknięć - dodawanie punktów do nowej strefy
    map.addListener("click", (event) => {
        const latLng = event.latLng;
        console.log(`Kliknięto: { lat: ${latLng.lat()}, lng: ${latLng.lng()} },`);

        // Dodanie punktu do tablicy
        tempCoords.push({ lat: latLng.lat(), lng: latLng.lng() });

        // Stworzenie markera
        const marker = new google.maps.Marker({
            position: latLng,
            map: map,
            label: `${tempCoords.length}`, // Numer punktu
        });

        tempMarkers.push(marker);

        // Jeśli jest co najmniej 3 punkty, rysujemy tymczasowy polygon
        if (tempCoords.length >= 3) {
            if (tempPolygon) tempPolygon.setMap(null); // Usunięcie poprzedniego
            tempPolygon = new google.maps.Polygon({
                paths: tempCoords,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map: map
            });
        }
    });

    // Przycisk do pobrania współrzędnych
    const getCoordsButton = document.createElement("button");
    getCoordsButton.textContent = "Pobierz współrzędne";
    getCoordsButton.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(getCoordsButton);

    getCoordsButton.addEventListener("click", () => {
        console.log("Współrzędne strefy:", JSON.stringify(tempCoords, null, 2));
        alert("Współrzędne zapisane w konsoli!");
    });

    // Przycisk do resetowania rysowania
    const resetButton = document.createElement("button");
    resetButton.textContent = "Resetuj";
    resetButton.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetButton);

    resetButton.addEventListener("click", () => {
        tempCoords = [];
        tempMarkers.forEach(marker => marker.setMap(null));
        tempMarkers = [];
        if (tempPolygon) tempPolygon.setMap(null);
        tempPolygon = null;
    });
    addZonesToMap(map);
}*/
async function initMap() {
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    await google.maps.importLibrary("geometry");

    const center = { lat: 51.40328, lng: 21.1486 };
    const map = new Map(document.getElementById("map"), {
        zoom: 15,
        center,
        mapId: "e6dc69ca24aac8ed",
    });

    for (const property of properties) {
        const marker = new google.maps.marker.AdvancedMarkerElement({
            map,
            content: buildContent(property),
            position: property.position,
            title: property.description,
        });

        marker.addListener("click", () => {
            toggleHighlight(marker, property);
        });
    }

    infoWindow2 = new google.maps.InfoWindow();

    const locationButton = document.createElement("button");
    locationButton.textContent = "Pokaż moją lokalizację";
    locationButton.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

    locationButton.addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    infoWindow2.setPosition(pos);
                    infoWindow2.setContent("Lokacja znaleziona");
                    infoWindow2.open(map);
                    map.setCenter(pos);
                },
                () => {
                    handleLocationError(true, infoWindow2, map.getCenter());
                }
            );
        } else {
            handleLocationError(false, infoWindow2, map.getCenter());
        }
    });

    // Wywołanie funkcji do dodania polygonów
    addZonesToMap(map, num_zones);
}


function addZonesToMap(map, izo) {
        const zones4 = [
            {
                name: "Strefa 1",
                coords: [
                    { lat: 51.39897230123595, lng: 21.14034508622955 }, //wspólny 1  = 3 = 4
  
                    { lat: 51.39921617244218, lng: 21.153178280869376 }, //wspólny 1 = 2 = 3 NOWY
                    { lat: 51.4038144493784, lng: 21.157088227336576 }, //wspólny 1 = 2 NOWY

                    { lat: 51.40194942645369, lng: 21.36829188054551 }, //wspólny 1 = 2
                    { lat: 51.52258912025264, lng: 21.375844981131447 }, 
                    { lat: 51.510901738823165, lng: 21.145960601255744 },//wspólny 1 = 4
                ],
                color: "#00FF00", //
            },
            {
                name: "Strefa 2",
                coords: [
                    //{ lat: 51.39897230123595, lng: 21.14034508622955  }, //wspólny 1 = 3 = 4

                    { lat: 51.39921617244218, lng: 21.153178280869376 }, //wspólny 1 = 2 = 3 NOWY
                    { lat: 51.4038144493784, lng: 21.157088227336576 }, //wspólny 1 = 2 NOWY

                    { lat: 51.40194942645369, lng: 21.36829188054551 }, //wspólny 1 = 2
                    { lat: 51.29983637563959, lng: 21.359921497058618 },
                    { lat: 51.30836818386306, lng: 21.152942410158456 }, //wspólny 2 = 3
                ],
                color: "#ffff00", //
            },
            {
                name: "Strefa 3",
                coords: [
                    { lat: 51.39897230123595, lng: 21.14034508622955 }, //wspólny 1 = 2 = 3 = 4
                    { lat: 51.39921617244218, lng: 21.153178280869376 }, //wspólny 1 = 2 = 3 NOWY
                    { lat: 51.30836818386306, lng: 21.152942410158456 }, //wspólny 2 = 3
                    { lat: 51.32575156242881, lng: 20.903150226102966 },
                    { lat: 51.40763247153663, lng: 20.93130269192328 }, //wspólny 3 = 4
    
                ],
                color: "#0000FF", // 
            },
            {
                name: "Strefa 4",
                coords: [
                    { lat: 51.39897230123595, lng: 21.14034508622955 }, //wspólny 1 = 2 = 3 = 4
                    { lat: 51.40763247153663, lng: 20.93130269192328 }, //wspólny 3 = 4
                    { lat: 51.50219216524154, lng: 20.91698723283829 },
                    { lat: 51.510901738823165, lng: 21.145960601255744 }, // wspólny 1 = 4
                ],
                color: "#ff0000", // 
            }
        ];




        const zones3 = [
            {
                name: "Strefa 1",
                coords: [
                    { lat: 51.38580232517116, lng: 21.145281501377273 }, //wspólny 1 = 2 = 3
                    { lat: 51.40194942645369, lng: 21.36829188054551 }, //wspólny 1 = 2
                    { lat: 51.52258912025264, lng: 21.375844981131447 },
                    { lat: 51.510901738823165, lng: 21.145960601255744 },//wspólny 1 = 4
                ],
                color: "#00FF00", // Czerwony
            },
            {
                name: "Strefa 2",
                coords: [
                    { lat: 51.38580232517116, lng: 21.145281501377273 }, //wspólny 1 = 2 = 3
                    { lat: 51.40194942645369, lng: 21.36829188054551 }, //wspólny 1 = 2
                    
                    { lat: 51.29983637563959, lng: 21.359921497058618 },
                    { lat: 51.32575156242881, lng: 20.903150226102966 },
                    { lat: 51.40763247153663, lng: 20.93130269192328 }, //wspólny 2 = 3


                ],
                color: "#ffff00", // Niebieski
            },
            {
                name: "Strefa 3",
                coords: [
                    { lat: 51.38580232517116, lng: 21.145281501377273 }, //wspólny 1 = 2 = 3
                    { lat: 51.40763247153663, lng: 20.93130269192328 }, //wspólny 2 = 3
                    { lat: 51.50219216524154, lng: 20.91698723283829 },
                    { lat: 51.510901738823165, lng: 21.145960601255744 }, // wspólny 1 = 3
    
                ],
                color: "#0000FF", // 
            }
        ];
        const zones2 = [
            {
                name: "Strefa 1",
                coords: [
                    { lat: 51.39897230123595, lng: 21.14034508622955 }, //wspólny 1 = 2
                    { lat: 51.510901738823165, lng: 21.145960601255744 },//wspólny 1 = 2
                    { lat: 51.52258912025264, lng: 21.375844981131447 }, 
                    { lat: 51.29983637563959, lng: 21.359921497058618 },
                    { lat: 51.30836818386306, lng: 21.152942410158456 }, //wspólny 1 = 2
                ],
                color: "#00ff00", // Czerwony
            },
            {
                name: "Strefa 2",
                coords: [
                    { lat: 51.39897230123595, lng: 21.14034508622955 }, //wspólny 1 = 2
                    { lat: 51.510901738823165, lng: 21.145960601255744 },//wspólny 1 = 2
                    { lat: 51.50219216524154, lng: 20.91698723283829 },
                    { lat: 51.32575156242881, lng: 20.903150226102966 },
                    { lat: 51.30836818386306, lng: 21.152942410158456 }, //wspólny 1 = 2


                ],
                color: "#ffff00", // Niebieski
            }
        ];

        if(izo == 2) {
            const polygons = zones2.map(zone => {
                return {
                    name: zone.name,
                    polygon: new google.maps.Polygon({
                        paths: zone.coords,
                        strokeColor: zone.color,
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: zone.color,
                        fillOpacity: 0.35,
                        map: map
                    })
                };
            });
            pointsInZones = {};  
            polygons.forEach(zone => pointsInZones[zone.name] = []);
            pointsInZones["Poza strefami"] = [];
            properties.forEach(point => {
                const latLng = new google.maps.LatLng(point.position.lat, point.position.lng);
                let insideAnyZone = false;
        
                polygons.forEach(zone => {
                    if (google.maps.geometry.poly.containsLocation(latLng, zone.polygon)) {
                        pointsInZones[zone.name].push(point);
                        insideAnyZone = true;
                    }
                });
        
                if (!insideAnyZone) {
                    pointsInZones["Poza strefami"].push(point);
                }
            });
            console.log("Punkty w strefach:", pointsInZones);
        }
        if(izo == 3) {
            const polygons = zones3.map(zone => {
                return {
                    name: zone.name,
                    polygon: new google.maps.Polygon({
                        paths: zone.coords,
                        strokeColor: zone.color,
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: zone.color,
                        fillOpacity: 0.35,
                        map: map
                    })
                };
            });
            pointsInZones = {};  
            polygons.forEach(zone => pointsInZones[zone.name] = []);
            pointsInZones["Poza strefami"] = [];
            properties.forEach(point => {
                const latLng = new google.maps.LatLng(point.position.lat, point.position.lng);
                let insideAnyZone = false;
        
                polygons.forEach(zone => {
                    if (google.maps.geometry.poly.containsLocation(latLng, zone.polygon)) {
                        pointsInZones[zone.name].push(point);
                        insideAnyZone = true;
                    }
                });
        
                if (!insideAnyZone) {
                    pointsInZones["Poza strefami"].push(point);
                }
            });
            console.log("Punkty w strefach:", pointsInZones);
        }
        if(izo == 4) {
            const polygons = zones4.map(zone => {
                return {
                    name: zone.name,
                    polygon: new google.maps.Polygon({
                        paths: zone.coords,
                        strokeColor: zone.color,
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: zone.color,
                        fillOpacity: 0.35,
                        map: map
                    })
                };
            });
            pointsInZones = {};  
            polygons.forEach(zone => pointsInZones[zone.name] = []);
            pointsInZones["Poza strefami"] = [];
            properties.forEach(point => {
                const latLng = new google.maps.LatLng(point.position.lat, point.position.lng);
                let insideAnyZone = false;
        
                polygons.forEach(zone => {
                    if (google.maps.geometry.poly.containsLocation(latLng, zone.polygon)) {
                        pointsInZones[zone.name].push(point);
                        insideAnyZone = true;
                    }
                });
        
                if (!insideAnyZone) {
                    pointsInZones["Poza strefami"].push(point);
                }
            });
            console.log("Punkty w strefach:", pointsInZones);
        }
        
            
        
            
            

        

}



    function toggleHighlight(markerView, property) {
        if (markerView.content.classList.contains("highlight")) {
            markerView.content.classList.remove("highlight");
            markerView.zIndex = null;
        } else {
            markerView.content.classList.add("highlight");
            markerView.zIndex = 1;
        }
    }

    function buildContent(property) {
        const content = document.createElement("div");

        content.classList.add("property");
        let type_icon = property.type;
        let styleshop = "";
        if(property.type == "store" || property.type == "shop") {// || property.type == "grocery_or_supermarket"
            type_icon = "shop";
        }

        if(property.type == "grocery_or_supermarket") {
            if(property.visited == "new") {
                type_icon = "clipboard-question";
            } else {
                if(property.status == 2) {
                    type_icon = "thumbs-up";
                } else if(property.status == 9) {
                    type_icon = "phone";
                } else {
                    type_icon = "ban";
                }
            }
        }
        if(type_icon == "shop") {
            styleshop = `shop my-shop-${property.driver_id}-${property.delivery_time}`;
        } else {
            styleshop = type_icon;
        }
        console.log(styleshop);
        content.innerHTML = `
    <div class="icon">
        <i aria-hidden="true" class="fa fa-icon fa-${styleshop}" title="${type_icon}"></i>
        <span class="fa-sr-only">${type_icon}</span>
    </div>
    <div class="details">
        <div class="price"><a target='blank' href='${property.url}'>${property.name}</a></div>
        <div class="address">${property.address}</div>
        <div class="address">Notatka: ${property.description}</div>
        <div class="features">
            <div>
                <i aria-hidden="true" class="fa fa-info-circle fa-lg bath" title="Edycja"></i>
                <span class="fa-sr-only">Edytuj</span>
                <span><a target="_blank" href="<?php echo ROOT;?>/company/edit/${property.id}">Edytuj</a></span>
            </div>
            <div>
                <i aria-hidden="true" class="fa fa-info-circle fa-lg bath" title="Data wizyty"></i>
                <span class="fa-sr-only">Data wizyty</span>
                <span>${property.visit_date}</span>
            </div>
            <div>
                <i aria-hidden="true" class="fa fa-calendar-day fa-lg gr" title="Status"></i>
                <span class="fa-sr-only">Status</span>
                <span>${property.status_name}</span>
            </div>
            <div>
                <i aria-hidden="true" class="fa fa-person fa-lg gr" title="Kierowca"></i>
                <span class="fa-sr-only">Kierowca</span>
                <span>${property.driver_name}</span>
            </div>
        </div>
    </div>
    `;
        return content;
    }

    const properties = [
        <?php
        foreach ($points as $k => $point) {
            $lat = $point["lat"];
            $lng = $point["lng"];
            if($lat == "") {
                $lat = 0;
            }
            if($lng == "") {
                $lng = 0;
            }
            $name = "<b>" . $point["name"] . "</b></br></br><a href='https://www.google.com/maps/dir//" . $lat . "," . $lng . "'>Pokaż na mapie</a>";
            echo ' 
            {
                position: {lat: ' . $lat . ', lng: ' . $lng . '},
                title: "' . $name . '",
                id: "' . $point["id"] . '",
                name: "' . $point["name"] . '",
                visited: "' . $point["visited"] . '",
                type: "' . $point["type"] . '",
                status: "' . $point["status"] . '",
                address: "' . $point["address"] . '",
                description: "' . $point["description"] . '",
                visit_date: "' . $point["visit_date"] . '",
                status_name: "' . $point["status_name"] . '",
                driver_id: "' . $point["driver_id"] . '",
                driver_name: "' . $point["driver_name"] . '",
                delivery_time: "' . $point["delivery_time"] . '",
                url: "https://www.google.com/maps/dir//' . $lat . ',' . $lng . '"
            },';
        }
        ?>
    ];
    console.log(properties);


    function handleLocationError(browserHasGeolocation, infoWindow2, pos) {
        infoWindow2.setPosition(pos);
        infoWindow2.setContent(
            browserHasGeolocation
                ? "Error: The Geolocation service failed."
                : "Error: Your browser doesn't support geolocation.",
        );
        infoWindow2.open(map);
    }



    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("saveroute").addEventListener("click", async () => {
            try {
                const data = JSON.stringify(pointsInZones);

                const response = await fetch("<?php echo ROOT."/reports/saveroute";?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: data
                });

                const result = await response.text();
                alert("Odpowiedź z serwera: " + result);
                location.reload();
                console.log("Odpowiedź z serwera:", result);
            } catch (error) {
                console.error("Błąd podczas wysyłania danych:", error);
                alert("Wystąpił błąd podczas zapisu.");
            }
        });
    });
</script>




<?php
$to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
$subject = "Raport odwiedzonych punktów - $dates";

if ($send == 1) {
    $mailer = new Mailer($to, $subject, $mess);
    if (SEND_ON === TRUE && $to_send) {
        if ($mailer->send()) {
            echo 'Wiadomość została wysłana pomyślnie.';
        } else {
            echo 'Wystąpił problem podczas wysyłania wiadomości. Błąd: ' . print_r($mailer->getLastError(), true);
        }
    } else {
        if (!$to_send) {
            echo "Brak treści wiadomości";
        }
        show($mailer);
    }
} else {
    //echo $mess;
}
?>