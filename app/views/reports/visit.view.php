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
        //POPRAWIĆ wyświetlanie godzin po przesłaniu formularza, sprawdzić czy działa dla godzin porannych (6:00, 7:00, 8:00, 9:00)
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
    </div>
    <button class="w-40 btn btn-lg btn-primary" style="margin-bottom: 40px;" type="submit" name="search" value=1>Wyświetl
        raport</button>
    </form>
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

    if (isset($data["companies_new"])) {
        foreach ($data["companies_new"] as $kkey => $vvalue) {
            $compaid = $vvalue->id;
            if (isset($vvalue->latitude) && $vvalue->longitude) {
                $points["n" . $compaid] = ["name" => $vvalue->name, "visit_date" => "", "status_name" => "", "description" => $vvalue->description, "address" => $vvalue->address, "lat" => $vvalue->latitude, "lng" => $vvalue->longitude, "type" => $vvalue->type, "status" => 0, "visited" => "new"];
            }
        }
    }
    if (isset($data["company_old"])) {
        foreach ($data["company_old"] as $kkey => $vvalue) {
            $compaid = $vvalue->id;
            if (isset($vvalue->latitude) && $vvalue->longitude) {
                $points["o" . $compaid] = ["name" => $vvalue->full_name, "visit_date" => "", "status_name" => "", "description" => $vvalue->description, "address" => "$vvalue->address", "lat" => $vvalue->latitude, "lng" => $vvalue->longitude, "type" => $vvalue->c_type, "status" => $vvalue->active, "visited" => "old"];
            }
        }
    }
    
    foreach ($data["companies"] as $company_id => $compval) {
        $inserted = "";
        if ($compval->inserted == 1) {
            $inserted = "<b>[NOWA]</b> ";
        }
        if ($compval->visit_date == "0000-00-00 00:00:00" || $compval->visit_date == NULL) {
            $points[$company_id] = ["name" => $compval->name, "visit_date" => $compval->visit_date, "status_name" => COMPANYVISIT[$compval->status], "description" => $compval->description, "address" => $compval->address, "lat" => $compval->latitude, "lng" => $compval->longitude, "type" => $compval->type, "status" => $compval->status, "visited" => "false"];
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
            $points[$company_id] = ["name" => $compval->name, "visit_date" => $compval->visit_date, "status_name" => COMPANYVISIT[$compval->status], "description" => $compval->description, "address" => $compval->address, "lat" => $compval->latitude, "lng" => $compval->longitude, "type" => $compval->type, "status" => $compval->status, "visited" => "true"];
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
echo $mess;

$to_send = false;
if ($mess != "") {
    $to_send = true;
}

?>



<div class="card mb-4">
    <div class="card-header">
        <h2 class="">Mapa</h2>
    </div>
    <div class="form-group row m-3">
        <div class="col-sm-12">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $data["api_key"];?>&callback=initMap" async
    defer></script>
<script>
    async function initMap() {
        // Request needed libraries.
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
        const center = { lat: 51.40328, lng: 21.1486 };
        const map = new Map(document.getElementById("map"), {
            zoom: 15,
            center,
            mapId: "e6dc69ca24aac8ed",
        });

        for (const property of properties) {
            const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                map,
                content: buildContent(property),
                position: property.position,
                title: property.description,
            });

            AdvancedMarkerElement.addListener("click", () => {
                toggleHighlight(AdvancedMarkerElement, property);
            });
        }

        infoWindow2 = new google.maps.InfoWindow();

        const locationButton = document.createElement("button");

        locationButton.textContent = "Pokaż moją lokalizację";
        locationButton.classList.add("custom-map-control-button");
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
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
                    },
                );
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow2, map.getCenter());
            }
        });
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
        content.innerHTML = `
    <div class="icon">
        <i aria-hidden="true" class="fa fa-icon fa-${type_icon}" title="${type_icon}"></i>
        <span class="fa-sr-only">${type_icon}</span>
    </div>
    <div class="details">
        <div class="price"><a target='blank' href='${property.url}'>${property.name}</a></div>
        <div class="address">${property.address}</div>
        <div class="address">Notatka: ${property.description}</div>
        <div class="features">
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
            $name = "<b>" . $point["name"] . "</b></br></br><a href='https://www.google.com/maps/dir//" . $lat . "," . $lng . "'>Pokaż na mapie</a>";
            echo ' 
            {
                position: {lat: ' . $lat . ', lng: ' . $lng . '},
                title: "' . $name . '",
                name: "' . $point["name"] . '",
                visited: "' . $point["visited"] . '",
                type: "' . $point["type"] . '",
                status: "' . $point["status"] . '",
                address: "' . $point["address"] . '",
                description: "' . $point["description"] . '",
                visit_date: "' . $point["visit_date"] . '",
                status_name: "' . $point["status_name"] . '",
                url: "https://www.google.com/maps/dir//' . $lat . ',' . $lng . '"
            },';
        }
        ?>
    ];


    function handleLocationError(browserHasGeolocation, infoWindow2, pos) {
        infoWindow2.setPosition(pos);
        infoWindow2.setContent(
            browserHasGeolocation
                ? "Error: The Geolocation service failed."
                : "Error: Your browser doesn't support geolocation.",
        );
        infoWindow2.open(map);
    }
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