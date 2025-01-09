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
                      foreach (DELIVERYHOUR as $key => $value) {
                          echo "<div class='form-check'>
                              <input class='form-check-input' type='radio' name='delivery_hour' id='delivery_hour$key' value='$key' $selected>
                              <label class='form-check-label' for='delivery_hour$key'>
                              $value
                              </label>
                              </div>";
                          $selected = "";
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
                      $class_color = " class='shop-".$data["users"][$company->guardian]["int"]."' ";
                    } else {
                      $class_color = "";
                    }
                    echo "<tr>
                                                <td>$company->full_name $fname</td>
                                                <td>$company->address</td>
                                                <td>$company->contact_first_name $company->contact_last_name</td>
                                                <td>$company->phone_number</td>
                                                <td $class_color>$guard</td>
                                                <td>$company->description</td>
                                                <td class='delivery-type".$company->delivery_hour."'>$delivery</td>";
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
                      <td><input class="form-control w-50" type="time" name="departure-time" value="16:00" required>
                      </td>
                    </tr>
                    <tr>
                      <th rowspan="2">Czas na punkt:</th>
                    </tr>
                    <tr>
                      <td><input class="form-control w-50" type="number" name="point-time" min="1" max="15" step="1"
                          value="5" required></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Przycisk do generowania trasy i link do Google Maps -->
              <button id="generate-route" class="btn btn-primary" onclick="generateRoute()">Generuj trasę</button>
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
                  <th scope="col">Nazwa sklepu</th>
                  <th scope="col">Adres</th>
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
    // Pobierz zaznaczoną wartość z radio buttonów
    const selectedDeliveryHour = document.querySelector('input[name="delivery_hour"]:checked').value;

    // Pobierz wszystkie checkboxy w tabeli
    const checkboxes = document.querySelectorAll('.location-checkbox');

    // Najpierw odznacz wszystkie checkboxy
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Iteruj przez każdy checkbox i sprawdź, czy jego wiersz odpowiada wybranemu `delivery_hour`
    checkboxes.forEach(checkbox => {
        // Pobierz wiersz, w którym znajduje się checkbox
        const row = checkbox.closest('tr');

        // Znajdź kolumnę z klasą `delivery-typeX` w tym wierszu
        const deliveryTypeCell = row.querySelector('[class^="delivery-type"]');

        if (deliveryTypeCell) {
            // Wyciągnij klasę `delivery-typeX` i uzyskaj numer
            const deliveryClass = [...deliveryTypeCell.classList].find(cls => cls.startsWith('delivery-type'));
            const deliveryHour = deliveryClass.replace('delivery-type', '');

            // Jeśli numer odpowiada wybranemu radio, zaznacz checkbox
            if (deliveryHour === selectedDeliveryHour) {
                checkbox.checked = true;
            }
        }
    });
}

      </script>
<script>
    let map;
    let directionsService;
    let directionsRenderer;
    let time_onsite = 300; // 300 sekund = 5 minut
    let time_start = "16:00"; // godzina wyjazdu
    let full_msg = "";
    let num_pos = 0;

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
    }
</script>

      <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $data["token"]; ?>&callback=initMap"></script>

    </main>
    <?php require_once 'landings/footer.view.php' ?>