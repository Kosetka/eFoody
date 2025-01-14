<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
  #map {
    height: 600px;
    width: 100%;
  }

  #points-list {
    margin-top: 20px;
  }

  #points-list ul {
    list-style-type: none;
    padding: 0;
  }

  #points-list li {
    margin: 5px 0;
  }
</style>
<?php
$msg = "";
$comp_des = [];

foreach ($data["cargo_comp"] as $comp_id => $comp_val) {
  $fr_name = "";
  if (isset($data["companies_sorted"][$comp_id]->full_name)) {
    $fr_name = $data["companies_sorted"][$comp_id]->full_name;
    if ($data["companies_sorted"][$comp_id]->friendly_name) {
      $fr_name .= " (" . $data["companies_sorted"][$comp_id]->friendly_name . ")";

    }
  }
  $msg .= $fr_name . ": ";
  $msg .= "</br>";
  $p_01 = [];
  $p_02 = [];
  $p_03 = [];
  foreach ($comp_val as $prod_val) {
    if (substr($prod_val->sku, 0, 4) == "1-01") {
      $p_01[] = $prod_val;
    } else if (substr($prod_val->sku, 0, 4) == "1-02") {
      $p_02[] = $prod_val;
    } else {
      $p_03[] = $prod_val;
    }
  }
  $title_set = false;
  foreach ($p_01 as $prod_val) {
    $f_name = $prod_val->p_name;
    if ($prod_val->friendly_name != "") {
      $f_name = $prod_val->friendly_name;
    }
    if (!$title_set) {
      $msg .= "S.: ";
      $msg .= "</br>";
      $title_set = true;
    }
    $msg .= $f_name . " x" . $prod_val->amount;
    $msg .= "</br>";
  }
  $title_set = false;
  foreach ($p_02 as $prod_val) {
    $f_name = $prod_val->p_name;
    if ($prod_val->friendly_name != "") {
      $f_name = $prod_val->friendly_name;
    }
    if (!$title_set) {
      $msg .= "K.: ";
      $msg .= "</br>";
      $title_set = true;
    }
    $msg .= $f_name . " x" . $prod_val->amount;
    $msg .= "</br>";
  }
  $title_set = false;
  foreach ($p_03 as $prod_val) {
    $f_name = $prod_val->p_name;
    if ($prod_val->friendly_name != "") {
      $f_name = $prod_val->friendly_name;
    }
    if (!$title_set) {
      $msg .= "Inne: ";
      $msg .= "</br>";
      $title_set = true;
    }
    $msg .= $f_name . " x" . $prod_val->amount;
    $msg .= "</br>";
  }
  $comp_des[$comp_id] = $msg;

  $msg = "";
}
?>
<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
      <div class="container-fluid px-4">
        <div class="card mb-4">
          <div class="card-header">
            <h2 class="">Lista sklepów</h2>
              <div class="form-group row m-3">
                  <label for="delivery_hour" class="col-sm-2 col-form-label">Termin dostawy:</label>
                  <div class="col-sm-2" style="text-align: left;">
                      <?php
                      $selected = "checked";
                      echo "<div class='form-check'>
                              <input class='form-check-input' type='radio' name='delivery_hour' id='delivery_hour99' value='99' $selected>
                              <label class='form-check-label' for='delivery_hour99'>
                              Wszystkie
                              </label>
                              </div>";
                              
                      $selected = "";
                      foreach (DELIVERYHOUR as $key => $value) {
                          echo "<div class='form-check'>
                              <input class='form-check-input' type='radio' name='delivery_hour' id='delivery_hour$key' value='$key' $selected>
                              <label class='form-check-label' for='delivery_hour$key'>
                              $value
                              </label>
                              </div>";
                      }
                      ?>
                  </div>
              </div>
              <div class="form-group row m-3">
                  <label for="drivers" class="col-sm-2 col-form-label">Kierowca:</label>
                  <div class="col-sm-2" style="text-align: left;">
                      <?php
                      $selected = "checked";

                      echo "<div class='form-check'>
                              <input class='form-check-input' type='radio' name='drivers' id='drivers0' value='0' $selected>
                              <label class='form-check-label' for='drivers0'>
                              Wszyscy
                              </label>
                              </div>";
                      $selected = "";
                      foreach ($data["drivers"] as $key => $value) {
                          echo "<div class='form-check'>
                              <input class='form-check-input' type='radio' name='drivers' id='drivers$key' value='$key' $selected>
                              <label class='form-check-label' for='drivers$key'>
                              $value->first_name $value->last_name
                              </label>
                              </div>";
                          
                      }
                      ?>
                      <button id="select-shops" class="btn btn-primary" onclick="selectShops()">Zaznacz wybrane</button>
                  </div>
              </div>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Nazwa sklepu</th>
                  <th scope="col">Adres</th>
                  <th scope="col">Osoba kontaktowa</th>
                  <th scope="col">Numer telefonu</th>
                  <th scope="col">Kierowca</th>
                  <th scope="col">Notatka</th>
                  <th scope="col">Preferowany termin dostawy</th>
                  <th scope="col">Godziny otwarcia</th>
                  <th scope="col">Lokalizacja</th>
                  <th scope="col">Ostatnia dostawa</th>
                  <th scope="col">Dodaj do trasy</th>
                </tr>
              </thead>
              <tbody>

                <?php
                if (!$data) {
                  echo "<tr><th colspan='10'>Brak danych do wyświetlenia</th></tr>";
                } else {
                  foreach ($data["companies"] as $company) {
                    $gps_link = "#";
                    if (isset($company->latitude) && $company->latitude != "") {
                      if (isset($company->longitude) && $company->longitude != "") {
                        $gps_link = "https://www.google.com/maps?q=" . $company->latitude . "," . $company->longitude;
                      }
                    }
                    $fname = "";
                    if (isset($company->friendly_name)) {
                      if ($company->friendly_name != "") {
                        $fname = "(" . $company->friendly_name . ")";
                      }
                    }
                    $delivery = "";
                    if(isset($company->delivery_hour)) {
                      $delivery = DELIVERYHOUR[$company->delivery_hour];
                    }
                    $guard = "";
                    if(isset($company->guardian) && $company->guardian <> "") {
                      if(isset($data["users"][$company->guardian])) {
                        $guard = $data["users"][$company->guardian]["first_name"]." ".$data["users"][$company->guardian]["last_name"];
                      } else {
                        $guard = "Brak";
                      }
                    }
                    
                    if(isset($data["users"][$company->guardian]["int"])) {
                      $class_color = " class='shop-".$data["users"][$company->guardian]["int"]." drivers".$company->guardian."' ";
                      $group_class = " class='delivery-type".$company->delivery_hour." drivers".$company->guardian."'";
                    } else {
                      $class_color = " class='drivers0' ";
                      $group_class = " class='delivery-type".$company->delivery_hour." drivers".$company->guardian."'";
                    }
                    if(empty($company->open_hour)) {
                      $company->open_hour = "07:00";
                    } 
                    if(empty($company->close_hour)) {
                      $company->close_hour = "18:00";
                    }
                    $hours = $company->open_hour." - ".$company->close_hour;
                    echo "<tr $group_class>
                                                <td>$company->full_name $fname</td>
                                                <td>$company->address</td>
                                                <td>$company->contact_first_name $company->contact_last_name</td>
                                                <td>$company->phone_number</td>
                                                <td $class_color>$guard</td>
                                                <td>$company->description</td>
                                                <td class='delivery-type".$company->delivery_hour."'>$delivery</td>
                                                <td>$hours</td>";
                    if ($gps_link == "#") {
                      echo "<td></td>";
                    } else {
                      echo "<td><a href='$gps_link' target='_blank'>Pokaż na mapie</a></td>";
                    }
                    $last_da = "";
                    if (isset($data["cargo"][$company->id])) {
                      $last_da = $data["cargo"][$company->id]->latest_date;
                    }
                    echo "<td>$last_da</td>";
                    if ($gps_link == "#") {
                      echo "<td></td>";
                    } else {
                      echo "<td><input type='checkbox' checked class='location-checkbox form-check-input' data-latitude='{$company->latitude}' data-longitude='{$company->longitude}'></td>";
                    }

                    echo "</tr>";
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="container-fluid px-4">
        <div class="card mb-4">
          <div class="card-header">
            <h2 class="">Wyznaczanie optymalnej trasy</h2>
          </div>
          <div class="card-body card-half">
            <div style="width: 30%;">
              <!-- Lista wyboru punktu startowego -->
              
              <div class="card-body">
                <div class="alert alert-info alert-dismissible">
                  <h5>Uwaga!</h5>Przy zaznaczeniu powyżej 25 punktów, trasa nie jest w 100% optymalna.
                </div>
              </div><label>Ustawienia</label>
              <div id="start-point-options">
                <!-- Przykładowe punkty startowe - zastąp je swoimi -->
                <?php
                $countrow = 1;
                foreach ($data["warehouse"] as $wh) {
                  $countrow++;
                }
                ?>
                <table class="table">
                  <tbody>
                    <tr>
                      <th rowspan="<?= $countrow; ?>">Punkt startowy:</th>
                    </tr>
                    <?php
                    foreach ($data["warehouse"] as $wh) {
                      echo "<tr>";
                      echo '<td><label><input type="radio" name="start-point" value="' . $wh->w_lat . ',' . $wh->w_lon . '"> ' . $wh->c_fullname . ' ' . $wh->wh_fullname . '</label></td>';
                      echo "</tr>";
                    }

                    ?>
                    <tr>
                      <th rowspan="2">Godzina wyjazdu:</th>
                    </tr>
                    <tr>
                      <td><input class="form-control w-50" type="time" name="departure-time" value="06:00" required>
                      </td>
                    </tr>
                    <tr>
                      <th rowspan="2">Czas na punkt:</th>
                    </tr>
                    <tr>
                      <td><input class="form-control w-50" type="number" name="point-time" min="1" max="15" step="1"
                          value="3" required></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Przycisk do generowania trasy i link do Google Maps -->
              <button id="generate-route" class="btn btn-primary" onclick="generateNewRoute()">Generuj trasę</button>
              <a id="route-link" href="#" target="_blank" style="display:none;">Zobacz trasę na Google Maps</a>
            </div>
            <div style="width: 70%; background-color: grey;">
              <div id="map"></div>
            </div>
          </div>

          <div class="card-body">
            <!-- Tutaj powinien znajdować się kod generujący listę firm z checkboxami, tak jak wcześniej -->
          </div>
        </div>
      </div>

      <div class="container-fluid px-4">
        <div class="card mb-4">
          <div class="card-header">
            <h3>Optymalna trasa:</h3>
            <p id="summary_opti"></p>
            <ul id="points-ul"></ul>
          </div>
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Lp.</th>
                  <th scope="col">Nazwa sklepu</th>
                  <th scope="col">Adres</th>
                  <th scope="col">Godziny otwarcia</th>
                  <th scope="col">Czas przyjazdu</th>
                  <th scope="col">Czas odjazdu</th>
                  <th scope="col">Odległość</th>
                  <th scope="col">Czas przejazdu</th>
                </tr>
              </thead>
              <tbody id="table-list">

              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="container-fluid px-4">
        <div class="card mb-4">
          <div class="card-header">
            <h3>Treść wiadomości:</h3>
          </div>
          <div>
            <p id="txt_msg">
              <?php
              //show($comp_des);
              ?>

            </p>
          </div>
        </div>
      </div>

      <script>
function selectShops() {
    // Pobierz zaznaczoną wartość z radio buttonów `delivery_hour`
    const selectedDeliveryHour = document.querySelector('input[name="delivery_hour"]:checked').value;
    console.log(selectedDeliveryHour);

    // Pobierz zaznaczoną wartość z radio buttonów `drivers`
    const selectedDriver = document.querySelector('input[name="drivers"]:checked')?.id?.replace('drivers', '');
    console.log(selectedDriver);

    // Pobierz wszystkie checkboxy w tabeli
    const checkboxes = document.querySelectorAll('.location-checkbox');

    // Najpierw odznacz wszystkie checkboxy
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Jeśli wartość `selectedDeliveryHour` wynosi 99, zaznacz wszystkie checkboxy
    if (selectedDeliveryHour === '99') {
        checkboxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            // Jeśli kierowca to 0 (zaznacz wszystkich) lub pasuje do wybranego
            if (!selectedDriver || selectedDriver === '0' || row.classList.contains(`drivers${selectedDriver}`)) {
                checkbox.checked = true;
            }
        });
        return; // Zakończ działanie funkcji
    }

    // Iteruj przez każdy checkbox i sprawdź, czy odpowiada wybranym kryteriom
    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr'); // Pobierz wiersz tabeli z checkboxem

        // Pobierz kolumnę z klasą `delivery-typeX` w tym wierszu
        const deliveryTypeCell = row.querySelector('[class^="delivery-type"]');

        if (deliveryTypeCell) {
            // Wyciągnij klasę `delivery-typeX` i uzyskaj numer
            const deliveryClass = [...deliveryTypeCell.classList].find(cls => cls.startsWith('delivery-type'));
            const deliveryHour = deliveryClass.replace('delivery-type', '');

            // Sprawdź, czy checkbox odpowiada wybranemu `delivery_hour` oraz wybranemu kierowcy
            if (
                deliveryHour === selectedDeliveryHour &&
                (!selectedDriver || selectedDriver === '0' || row.classList.contains(`drivers${selectedDriver}`))
            ) {
                checkbox.checked = true;
            }
        }
    });
}

      </script>
<script>
    /*let map;
    let directionsService;
    let directionsRenderer;
    let time_onsite = 300; //  sekund = 5 minut
    let time_start = "06:00"; // godzina wyjazdu
    let full_msg = "";
    let num_pos = 0;


function timeToMinutes(time) {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 60 + minutes;
}
    // Funkcja pomocnicza do dodawania minut do czasu w formacie HH:MM
    function addMinutesToTime(time, minutes) {
        const [hours, mins] = time.split(":").map(Number);
        const date = new Date();
        date.setHours(hours);
        date.setMinutes(mins + minutes);
        return `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
    }

    const shops = <?php echo json_encode($data["companies"]); ?>; // Przekazanie danych o sklepach do JavaScript
    const shop_des = <?php echo json_encode($comp_des); ?>; // Przekazanie danych o sklepach do JavaScript
    console.log(shop_des);

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: { lat: 52.229675, lng: 21.012230 } // Domyślny środek (Warszawa)
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true }); // Ukryj domyślne markery
        directionsRenderer.setMap(map);
    }

    function generateRoute() {
        const timeStartInput = document.querySelector('input[name="departure-time"]').value;
        const timeOnsiteInput = parseInt(document.querySelector('input[name="point-time"]').value);

        time_start = timeStartInput;
        time_onsite = timeOnsiteInput * 60;

        const startPointRadio = document.querySelector('input[name="start-point"]:checked');
        if (!startPointRadio) {
            alert("Wybierz punkt startowy.");
            return;
        }

        const [startLat, startLng] = startPointRadio.value.split(',');

        const checkboxes = document.querySelectorAll('.location-checkbox:checked');
        const waypoints = Array.from(checkboxes).map(checkbox => {
            const latitude = checkbox.getAttribute('data-latitude');
            const longitude = checkbox.getAttribute('data-longitude');
            return {
                location: new google.maps.LatLng(latitude, longitude),
                stopover: true
            };
        });

        if (waypoints.length > 0) {
            const maxWaypoints = 25;
            const segments = [];
            let segmentStart = new google.maps.LatLng(startLat, startLng);

            // Podział na segmenty
            for (let i = 0; i < waypoints.length; i += maxWaypoints) {
                const segmentWaypoints = waypoints.slice(i, i + maxWaypoints);
                const segmentEnd =
                    i + maxWaypoints >= waypoints.length
                        ? new google.maps.LatLng(startLat, startLng) // Ostatni segment wraca do punktu startowego
                        : segmentWaypoints[segmentWaypoints.length - 1].location;
                segments.push({ start: segmentStart, waypoints: segmentWaypoints, end: segmentEnd });
                segmentStart = segmentEnd; // Ustawienie nowego punktu startowego dla kolejnego segmentu
            }
            

            processSegments(segments);
        } else {
            alert("Wybierz przynajmniej jeden punkt pośredni.");
        }
    }

    function processSegments(segments) {
        const allLegs = [];
        let currentArrivalTime = time_start;
        const renderers = []; // Lista rendererów dla każdego segmentu

        function processNextSegment(index) {
            if (index >= segments.length) {
                // Wszystkie segmenty zostały przetworzone
                updateSummary(allLegs);
                return;
            }

            const segment = segments[index];
            const request = {
                origin: segment.start,
                destination: segment.end,
                waypoints: segment.waypoints,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            };

            directionsService.route(request, function (result, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    const legs = result.routes[0].legs;
                    legs.forEach(leg => {
                        allLegs.push(leg); // Dodaj nogi trasy do wszystkich nóg
                    });
                    const sortedWaypoints = result.routes[0].waypoint_order;
                    displaySortedPoints(sortedWaypoints, segment.waypoints, legs, currentArrivalTime);
                    currentArrivalTime = calculateNewArrivalTime(legs, currentArrivalTime);

                    // Dodanie renderera dla segmentu
                    const segmentRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        suppressMarkers: true, // Ukryj domyślne markery
                        polylineOptions: {
                            strokeColor: getRandomColor(), // Różne kolory dla segmentów
                            strokeWeight: 5
                        }
                    });
                    segmentRenderer.setDirections(result);
                    renderers.push(segmentRenderer);

                    processNextSegment(index + 1); // Przetwarzaj kolejny segment
                } else {
                    alert("Nie udało się wygenerować segmentu trasy.");
                }
            });
        }

        processNextSegment(0); // Rozpocznij przetwarzanie od pierwszego segmentu
    }

    function calculateNewArrivalTime(legs, startTime) {
        let arrivalTime = startTime;
        legs.forEach(leg => {
            const durationMinutes = parseInt(leg.duration.text.split(" ")[0]);
            arrivalTime = addMinutesToTime(arrivalTime, durationMinutes + time_onsite / 60);
        });
        return arrivalTime;
    }

    function displaySortedPoints(sortedWaypoints, waypoints, legs, arrivalTime) {
    const pointsList = document.getElementById("table-list");
    let currentArrivalTime = arrivalTime;
    let ppoint = 1;
    let deferredWaypoints = []; // Punkty do odwiedzenia później

    sortedWaypoints.forEach((waypointIndex, index) => {
        const waypoint = waypoints[waypointIndex];
        const leg = legs[index];
        const latLng = waypoint.location;
        const distance = leg.distance.text;
        const duration = leg.duration.text;

        const shop = findShopByLatLng(latLng.lat(), latLng.lng());
        const shopDescription = shop ? shop_des[shop.id] : "Brak opisu";
        full_msg += shopDescription + "</br>";
        console.log(full_msg);

        const durationMinutes = parseInt(duration.split(" ")[0]);
        currentArrivalTime = addMinutesToTime(currentArrivalTime, durationMinutes);

        // Sprawdzanie godzin otwarcia
        const shopOpen = shop.open_hour;
        const shopClose = shop.close_hour;

        if (currentArrivalTime < shopOpen || currentArrivalTime > shopClose) {
            console.log(`Punkt zamknięty: ${shop.full_name}. Dodano do późniejszego odwiedzenia.`);
            deferredWaypoints.push(waypoint); // Dodaj do kolejki
            return; // Pomijamy ten punkt
        }

        const endTime = addMinutesToTime(currentArrivalTime, time_onsite / 60);
        const li = document.createElement("tr");
        let fname = "";
        if (shop) {
            if (shop.friendly_name != "") {
                fname = "(" + shop.friendly_name + ")";
            }
        }
        num_pos++;
        li.innerHTML = `
            <td>${num_pos}</td>
            <td>${shop ? shop.full_name : "N/A"} ${fname}</td>
            <td>${shop ? shop.address : "N/A"}</td>
            <td>${shop.open_hour} - ${shop.close_hour}</td>
            <td>${currentArrivalTime}</td>
            <td>${endTime}</td>
            <td>${distance}</td>
            <td>${duration}</td>
        `;
        pointsList.appendChild(li);

        currentArrivalTime = endTime;

        let txt_msg = document.getElementById("txt_msg");
        txt_msg.innerHTML = full_msg;

        addNumberedMarker(latLng, num_pos);
    });

    // Obsługa pominiętych punktów
    if (deferredWaypoints.length > 0) {
        console.log("Ponowne przetwarzanie punktów zamkniętych...");
        processDeferredWaypoints(deferredWaypoints, currentArrivalTime);
    }
}
function processDeferredWaypoints(deferredWaypoints, arrivalTime) {
    const remainingWaypoints = [];

    deferredWaypoints.forEach((waypoint) => {
        const shop = findShopByLatLng(waypoint.location.lat(), waypoint.location.lng());
        const shopOpen = shop.open_hour;
        const shopClose = shop.close_hour;

        // Jeśli punkt jest już otwarty, odwiedź go
        if (arrivalTime >= shopOpen && arrivalTime <= shopClose) {
            console.log(`Odwiedzam punkt ponownie: ${shop.full_name}`);
            displayFinalPoint(waypoint, arrivalTime);
        } else {
            console.log(`Punkt ${shop.full_name} nadal zamknięty. Dodano do trasy końcowej.`);
            remainingWaypoints.push(waypoint); // Dodaj do ostatecznej trasy
        }
    });

    // Jeśli pozostały punkty, wygeneruj dla nich trasę mimo godzin zamknięcia
    if (remainingWaypoints.length > 0) {
        console.log("Generowanie ostatecznej trasy dla punktów zamkniętych...");
        generateFinalRoute(remainingWaypoints, arrivalTime);
    }
}
function generateFinalRoute(waypoints, arrivalTime) {
    const request = {
        origin: waypoints[0].location, // Pierwszy punkt jako początek
        destination: waypoints[waypoints.length - 1].location, // Ostatni punkt jako koniec
        waypoints: waypoints.slice(1, -1), // Wszystkie pozostałe punkty jako przystanki
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING
    };

    directionsService.route(request, function (result, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            const legs = result.routes[0].legs;
            legs.forEach((leg, index) => {
                const waypoint = waypoints[index];
                const shop = findShopByLatLng(waypoint.location.lat(), waypoint.location.lng());
                const durationMinutes = parseInt(leg.duration.text.split(" ")[0]);

                arrivalTime = addMinutesToTime(arrivalTime, durationMinutes);
                displayFinalPoint(waypoint, arrivalTime);

                // Dodaj znacznik na mapie
                addNumberedMarker(waypoint.location, num_pos);
            });

            // Renderowanie ostatecznej trasy
            const finalRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: "#0000FF", // Niebieska trasa dla punktów zamkniętych
                    strokeWeight: 5
                }
            });
            finalRenderer.setDirections(result);
        } else {
            console.error("Nie udało się wygenerować ostatecznej trasy.");
        }
    });
}

function displayFinalPoint(waypoint, arrivalTime) {
    const pointsList = document.getElementById("table-list");
    const shop = findShopByLatLng(waypoint.location.lat(), waypoint.location.lng());
    const endTime = addMinutesToTime(arrivalTime, time_onsite / 60);

    const li = document.createElement("tr");
    num_pos++;
    li.innerHTML = `
        <td>${num_pos}</td>
        <td>${shop ? shop.full_name : "N/A"}</td>
        <td>${shop ? shop.address : "N/A"}</td>
        <td>${shop.open_hour} - ${shop.close_hour}</td>
        <td>${arrivalTime}</td>
        <td>${endTime}</td>
        <td>N/A</td>
        <td>N/A</td>
    `;
    pointsList.appendChild(li);
}

    function findShopByLatLng(lat, lng) {
        return shops.find(shop => shop.latitude == lat && shop.longitude == lng);
    }

    function updateSummary(legs) {
        let totalDistance = 0;
        let totalDuration = 0;

        legs.forEach(leg => {
            const distanceText = leg.distance.text;
            const distanceValue = parseFloat(distanceText.replace(" km", "").replace(",", "."));
            totalDistance += distanceValue;
            const durationText = leg.duration.text;
            const durationValue = parseInt(durationText.replace(" min", ""));
            totalDuration += durationValue;
        });

        totalDistance = totalDistance.toFixed(2);

        const summaryElement = document.getElementById("summary_opti");
        summaryElement.innerHTML = `<b>Trasa:</b> ${totalDistance} km</br><b>Czas jazdy:</b> ${totalDuration} min`;
    }

    // Funkcja generująca losowe kolory dla segmentów
    function getRandomColor() {
        const letters = 'E';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function addNumberedMarker(position, number) {
        const marker = new google.maps.Marker({
            position: position,
            map: map,
            label: {
                text: number.toString(),
                color: "white",
                fontSize: "14px",
                fontWeight: "bold"
            },
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 20,
                fillColor: "#FF0000", // Ten sam kolor co trasa
                fillOpacity: 1,
                strokeColor: "#FFFFFF",
                strokeWeight: 2
            }
        });
    }*/

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: { lat: 52.229675, lng: 21.012230 } // Domyślny środek (Warszawa)
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true }); // Ukryj domyślne markery
        directionsRenderer.setMap(map);
    }

   let shops = [
         <?php
           foreach($data["companies"] as $cp) {
             $open_hour = "07:00";
             if(!empty($cp->open_hour)) {
               $open_hour = $cp->open_hour;
             }
             $close_hour = "18:00";
             if(!empty($cp->close_hour)) {
               $close_hour = $cp->close_hour;
             }
             $full_name = $cp->full_name;
             if(!empty($cp->friendly_name)) {
               $full_name .= " (".$cp->friendly_name.")";
             }
             $lat = "";
             if(!empty($cp->latitude)) {
               $lat = $cp->latitude;
             }
             $lng = "";
             if(!empty($cp->longitude)) {
               $lng = $cp->longitude;
             }
             
             if($lat <> "" && $lng <> "") {
               $sms = "";
               if(isset($comp_des[$cp->id])) {
                 $sms = $comp_des[$cp->id];
               }
               echo '
                 {
                     name: "'.$full_name.'",
                     address: "'.$cp->address.'",
                     lat: '.$lat.',
                     lng: '.$lng.',
                     open_hour: "'.$open_hour.'",
                     close_hour: "'.$close_hour.'",
                     arrival_time: "",
                     departed_time: "",
                     distance: "",
                     onsite: "",
                     sms: "'.$sms.'",
                     c_id: "'.$cp->id.'"
                 },
               ';
             }
           }
         ?>
   ];


let wait_time = 180;
let shops_sorted = [];
let sms_text = "";
let us_totalDistance = 0;
let us_totalDuration = 0;
let us_totalDurationBreak = 0;
let us_checked = 0;

let shop_to_check = shops;
let shops_copy = shops;

let us_to_check = shop_to_check.length;

let i_max = 288;
let shops_left = shop_to_check.length;


let num_pos = 0;

let globalhour = 6*60*60; // czas wyjazdu

let origin = { lat: 51.41426849316346, lng: 21.153932682504852 };  // Twoje współrzędne początkowe
let originStr = `${origin.lat},${origin.lng}`; // punkt startowy ZMIENIĆ

let destinationsSubset = shop_to_check.map(shop_to_check => `${shop_to_check.lat},${shop_to_check.lng}`).join('|');



function generateNewRoute() {
  shops = shops_copy;
  const startPointRadio = document.querySelector('input[name="start-point"]:checked');
  let [startLat, startLng] = startPointRadio.value.split(',');
  //console.log(startLat+"" +startLng);
  origin = { lat: startLat, lng: startLng };  // Twoje współrzędne początkowe
  originStr = `${origin.lat},${origin.lng}`; // punkt startowy ZMIENIĆ
  shops_sorted.push({
    name: "Start",
    address: "adres",
    lat: origin.lat,
    lng: origin.lng
  });

    let timeStartInput = document.querySelector('input[name="departure-time"]').value;
    let timeOnsiteInput = parseInt(document.querySelector('input[name="point-time"]').value);

    globalhour = timeToSeconds(timeStartInput);
    wait_time = timeOnsiteInput * 60;

    
    if (!startPointRadio) {
        alert("Wybierz punkt startowy.");
        return;
    }

    

    let checkboxes = document.querySelectorAll('.location-checkbox:checked');
    let waypoints = Array.from(checkboxes).map(checkbox => {
      let latitude = checkbox.getAttribute('data-latitude');
      let longitude = checkbox.getAttribute('data-longitude');
        return {
            location: new google.maps.LatLng(latitude, longitude),
            stopover: true
        };
    });

    // Filtracja tablicy `shops`
    shops = shops.filter(shop => {
        return Array.from(checkboxes).some(checkbox => {
            const latitude = checkbox.getAttribute('data-latitude');
            const longitude = checkbox.getAttribute('data-longitude');
            return parseFloat(shop.lat) === parseFloat(latitude) && parseFloat(shop.lng) === parseFloat(longitude);
        });
    });
    console.log(shops);

    if (waypoints.length > 0) {
      let maxWaypoints = 25;
      if(waypoints.length > maxWaypoints){
        alert("Za dużo punktów.");
        return;
      } else {
        shop_to_check = shops;
        us_to_check = shop_to_check.length;
        shops_left = shop_to_check.length;
        destinationsSubset = shop_to_check.map(shop_to_check => `${shop_to_check.lat},${shop_to_check.lng}`).join('|');

        console.log(shop_to_check);
        console.log(destinationsSubset);
        executeMultipleRequests();
      }
    } else {
        alert("Wybierz przynajmniej jeden punkt pośredni.");
    }

}

function drawRoute2(map, start, waypoints, end) {
    // Tworzenie instancji DirectionsService i DirectionsRenderer
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        map: map, // Mapa, na której trasa ma być rysowana
        suppressMarkers: true // Ukrywa automatycznie generowane znaczniki (używamy własnych)
    });

    // Przygotowanie danych dla trasy
    const request = {
        origin: start, // Punkt początkowy
        destination: end, // Punkt końcowy
        waypoints: waypoints.map(point => ({ location: point, stopover: true })), // Punkty pośrednie
        travelMode: google.maps.TravelMode.DRIVING // Tryb podróży (np. DRIVING, WALKING)
    };

    // Wywołanie DirectionsService
    directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            // Rysowanie trasy na mapie
            directionsRenderer.setDirections(result);
        } else {
            console.error("Nie udało się obliczyć trasy:", status);
        }
    });
}




function timeToSeconds(time) {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 3600 + minutes * 60;
}


// Funkcja obliczająca czas dotarcia w minutach
const calculateTravelTime = (durationInSeconds) => {
    return durationInSeconds / 60; // czas w minutach
};

// Funkcja sprawdzająca, czy sklep jest otwarty
const isShopOpen = (openHour, timeOfArrival) => {
    const [openHourH, openHourM] = openHour.split(':').map(Number);
    const shopOpenTime = openHourH * 3600 + openHourM * 60;
//console.log("przybedzie: "+timeOfArrival+" otwarcie o: "+shopOpenTime);
    return timeOfArrival >= shopOpenTime;
};

const getDistanceMatrix = async (os, ds) => {
    try {
        let response = await fetch(`<?php echo ROOT;?>/company/company_get_matrix?origins=${os}&destinations=${ds}`);
        let data = await response.json();
        //console.log(data["rows"]);
        
        if (data && data["rows"][0] && data["rows"][0].elements) {
            const temporaryTable = []; // Tymczasowa tabela do przechowywania danych
            console.log(data);
            for (let i = 0; i < shop_to_check.length; i++) {
              const element = data["rows"][0].elements[i];
              let travelTimeName = element.duration.text;
              let travelLength = element.distance.value;
              let travelTime = convertTime(travelTimeName);
              let destinationTime = globalhour + travelTime;
              let lat = shop_to_check[i].lat;
              let lng = shop_to_check[i].lng;
              
                if (element && element.distance && element.duration) {
                    if (isShopOpen(shop_to_check[i].open_hour, destinationTime)) {
                        console.log(`${shop_to_check[i].name} is open when you arrive!`);
                        temporaryTable.push({
                            shopName: shop_to_check[i].name,
                            address: shop_to_check[i].address,
                            travelTime,
                            lat: shop_to_check[i].lat,
                            lng: shop_to_check[i].lng,
                            destinationTime,
                            open_hour: shop_to_check[i].open_hour,
                            close_hour: shop_to_check[i].close_hour,
                            arrival_time: shop_to_check[i].arrival_time,
                            departed_time: shop_to_check[i].departed_time,
                            distance: travelLength,
                            onsite: shop_to_check[i].onsite,
                            sms: shop_to_check[i].sms,
                            c_id: shop_to_check[i].c_id
                        });
                    } else {
                        console.log(`${shop_to_check[i].name} will be closed when you arrive.`);
                    }
                } else {
                    console.error(`Brak danych dla sklepu ${shop_to_check[i].name}`);
                }
            }
            if (temporaryTable.length > 0) {
              const minTravelTimeShop = temporaryTable.reduce((min, shop) => {
                  return shop.travelTime < min.travelTime ? shop : min;
              });
              console.log(minTravelTimeShop.travelTime);

            let shopData = {
                  shopName: minTravelTimeShop.shopName,
                  address: minTravelTimeShop.address,
                  travelTime: minTravelTimeShop.travelTime,
                  lat: minTravelTimeShop.lat,
                  lng: minTravelTimeShop.lng,
                  destinationTime: minTravelTimeShop.destinationTime,
                  open_hour: minTravelTimeShop.open_hour,
                  close_hour: minTravelTimeShop.close_hour,
                  arrival_time: globalhour,
                  departed_time: minTravelTimeShop.departed_time,
                  distance: minTravelTimeShop.distance,
                  onsite: minTravelTimeShop.onsite,
                  sms: minTravelTimeShop.sms,
                  c_id: minTravelTimeShop.c_id
              };
              shops_sorted.push(shopData);

              shop_to_check = shop_to_check.filter(shop => !(shop.lat === minTravelTimeShop.lat && shop.lng === minTravelTimeShop.lng));
              console.log(shop_to_check);
              globalhour += minTravelTimeShop.travelTime + wait_time;
              console.log(globalhour);
              originStr = `${minTravelTimeShop.lat},${minTravelTimeShop.lng}`
              destinationsSubset = shop_to_check.map(shop_to_check => `${shop_to_check.lat},${shop_to_check.lng}`).join('|');
              shops_left--;
              sms_text += minTravelTimeShop.sms;
              sms_text += "</br>";
              displayFinalPoints(shopData);
              updateSummary2(minTravelTimeShop.distance, minTravelTimeShop.travelTime);
              updateSmsText();
              pos = `${minTravelTimeShop.lat},${minTravelTimeShop.lng}`;
              let poss = new google.maps.LatLng(
                  parseFloat(minTravelTimeShop.lat),
                  parseFloat(minTravelTimeShop.lng)
              );
              addNumberedMarker(poss,num_pos);
                //console.log(`Sklep z najmniejszym czasem dotarcia: ${minTravelTimeShop.shopName}, Czas: ${minTravelTimeShop.travelTime}`);
            } else {
                console.log("Brak sklepów, które będą otwarte przy twoim przyjeździe.");
                globalhour += wait_time;
            }
        } else {
            console.error("Brak danych w odpowiedzi API lub nieprawidłowa struktura odpowiedzi");
            console.log(shops_left);
        }
    } catch (error) {
        console.error("Error fetching distance matrix:", error);
    }
};
const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

async function executeMultipleRequests() {
    for(i = 0; i <= i_max; i++) {
      if(shops_left == 0) {
        break;
      }
      getDistanceMatrix(originStr, destinationsSubset);
      await delay(600);
    }
    console.log(shops_sorted);
    console.log(shops_sorted[0].lat);
    console.log(shops_sorted[shops_sorted.length - 1].lat);
    const start = new google.maps.LatLng(shops_sorted[0].lat, shops_sorted[0].lng); // Przykładowe współrzędne startu (Warszawa)
    const end = new google.maps.LatLng(shops_sorted[shops_sorted.length - 1].lat, shops_sorted[shops_sorted.length - 1].lng);   // Przykładowe współrzędne końca (Poznań)

    const middleWaypoints = [];
    console.log(shops_sorted);
    for (let i = 1; i < shops_sorted.length - 1; i++) { // Pomiń pierwszy i ostatni
        const point = shops_sorted[i];
        middleWaypoints.push(new google.maps.LatLng(point.lat, point.lng)); // Dodaj do tablicy
    }

    console.log(middleWaypoints);

    // Rysowanie trasy
    addNumberedMarker(start,"S");
    drawRoute2(map, start, middleWaypoints, end);

    //tutaj punkty na mape
    
}

function addNumberedMarker(position, number) {
        const marker = new google.maps.Marker({
            position: position,
            map: map,
            label: {
                text: number.toString(),
                color: "white",
                fontSize: "14px",
                fontWeight: "bold"
            },
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 20,
                fillColor: "#FF0000", // Ten sam kolor co trasa
                fillOpacity: 1,
                strokeColor: "#FFFFFF",
                strokeWeight: 2
            }
        });
    }

function displayFinalPoints(waypoint) {
  console.log(waypoint);
    const pointsList = document.getElementById("table-list");
    //const shop = findShopByLatLng(waypoint.location.lat(), waypoint.location.lng()); //??

    const li = document.createElement("tr");
    num_pos++;
    li.innerHTML = `
        <td>${num_pos}</td>
        <td>${waypoint.shopName}</td>
        <td>${waypoint.address}</td>
        <td>${waypoint.open_hour} - ${waypoint.close_hour}</td>
        <td>`+formatSecondsToCustomTime(waypoint.destinationTime)+`</td>
        <td>`+formatSecondsToCustomTime(waypoint.destinationTime + wait_time)+`</td>
        <td>`+formatMetersToKilometers(waypoint.distance)+`</td>
        <td>`+formatSecondsToMinutes(waypoint.travelTime)+`</td>
    `;
    pointsList.appendChild(li);
}



function updateSummary2(totalDistance, totalDuration) {

  us_checked++;
  us_totalDistance += totalDistance;
  us_totalDuration += totalDuration;
  us_totalDurationBreak += totalDuration + wait_time;

  totalDistance = totalDistance.toFixed(2);

  const summaryElement = document.getElementById("summary_opti");
  summaryElement.innerHTML = `<b>Sprawdzone punkty:</b> ${us_checked} / ${us_to_check}</br><b>Trasa:</b> `+formatMetersToKilometers(us_totalDistance)+`</br><b>Czas jazdy:</b> `+formatSecondsToCustomTime(us_totalDuration)+` min</br><b>Czas całej trasy:</b> `+formatSecondsToCustomTime(us_totalDurationBreak)+` min`;
}
function updateSmsText() {
  let txt_msg = document.getElementById("txt_msg");
  txt_msg.innerHTML = sms_text;
}



function convertTime(timeString) {
    const timeParts = timeString.split(' ');
    //console.log(timeParts);
    if (timeParts.length === 2) {
        const minutes = parseInt(timeParts[0]);
        return (minutes * 60);
    } else if (timeParts.length === 4) {
        const hours = parseInt(timeParts[0]);
        const minutes = parseInt(timeParts[2]);
        return (hours * 3600) + (minutes * 60);
    } else {
        return 0;
    }
}
function formatSecondsToMinutes(seconds) {
    // Obliczanie minut
    const minutes = Math.floor(seconds / 60);
    
    // Zwracanie w formacie "x min"
    return `${minutes} min`;
}
function formatSecondsToCustomTime(seconds) {
    // Obliczanie godzin i minut
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    
    // Formatujemy godziny i minuty do 2 cyfr
    const formattedHours = hours.toString().padStart(2, '0');
    const formattedMinutes = minutes.toString().padStart(2, '0');
    
    // Zwracamy wynik w formacie "hh-ii"
    return `${formattedHours}:${formattedMinutes}`;
}
function formatMetersToKilometers(meters) {
    // Przekształcanie metrów na kilometry i zaokrąglanie do dwóch miejsc po przecinku
    const kilometers = (meters / 1000).toFixed(1);
    
    // Zwracamy wynik w formacie "x km"
    return `${kilometers} km`;
}

//generateNewRoute();
</script>

      <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $data["token"]; ?>&callback=initMap"></script>

    </main>
    <?php require_once 'landings/footer.view.php' ?>