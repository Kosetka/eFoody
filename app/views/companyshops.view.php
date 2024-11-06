<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
  #map {
    height: 500px;
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
<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
      <div class="container-fluid px-4">
        <div class="card mb-4">
          <div class="card-header">
            <h2 class="">Lista miast</h2>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Nazwa sklepu</th>
                  <th scope="col">Adres</th>
                  <th scope="col">Osoba kontaktowa</th>
                  <th scope="col">Numer telefonu</th>
                  <th scope="col">Adres mailowy</th>
                  <th scope="col">Status</th>
                  <th scope="col">Notatka</th>
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
                    if ($company->active) {
                      $active = "<td><span class='btn btn-success'>Aktywny</span></td>";
                    } else {
                      $active = "<td><span class='btn btn-danger'>Nieaktywny</span></td>";
                    }
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
                    echo "<tr>
                                                <td>$company->full_name $fname</td>
                                                <td>$company->address</td>
                                                <td>$company->contact_first_name $company->contact_last_name</td>
                                                <td>$company->phone_number</td>
                                                <td>$company->email</td>
                                                $active
                                                <td>$company->description</td>";
                    if ($gps_link == "#") {
                      echo "<td></td>";
                    } else {
                      echo "<td><a href='$gps_link' target='_blank'>Pokaż na mapie</a></td>";
                    }
                    echo "<td></td>";
                    if ($gps_link == "#") {
                      echo "<td></td>";
                    } else {
                      echo "<td><input type='checkbox' class='location-checkbox form-check-input' data-latitude='{$company->latitude}' data-longitude='{$company->longitude}'></td>";
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
              <label>Ustawienia</label>
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
                      <td><input type="time" name="departure-time" value="16:00" required></td>
                    </tr>
                    <tr>
                      <th rowspan="2">Czas na punkt:</th>
                    </tr>
                    <tr>
                      <td><input type="number" name="point-time" min="1" max="15" step="1" value="5" required></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Przycisk do generowania trasy i link do Google Maps -->
              <button id="generate-route" onclick="generateRoute()">Generuj trasę</button>
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

      <div id="points-list">
        <h3>Optymalna trasa:</h3>
        <p id="summary_opti"></p>
        <ul id="points-ul"></ul>
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

      <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let time_onsite = 300; // 300 sekund = 5 minut
        let time_start = "16:00"; // godzina wyjazdu

        // Funkcja pomocnicza do dodawania minut do czasu w formacie HH:MM
        function addMinutesToTime(time, minutes) {
          const [hours, mins] = time.split(":").map(Number);
          const date = new Date();
          date.setHours(hours);
          date.setMinutes(mins + minutes);
          return `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
        }

        const shops = <?php echo json_encode($data["companies"]); ?>; // Przekazanie danych o sklepach do JavaScript
        //console.log(shops);

        function initMap() {
          map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: { lat: 52.229675, lng: 21.012230 } // Domyślny środek (Warszawa)
          });

          directionsService = new google.maps.DirectionsService();
          directionsRenderer = new google.maps.DirectionsRenderer();
          directionsRenderer.setMap(map);
        }

        function generateRoute() {
          // Pobieramy wybrany punkt startowy z listy radio buttonów
          const timeStartInput = document.querySelector('input[name="departure-time"]').value;
          const timeOnsiteInput = parseInt(document.querySelector('input[name="point-time"]').value);

          // Podmiana wartości w zmiennych globalnych
          time_start = timeStartInput;
          time_onsite = timeOnsiteInput * 60; // Konwersja minut na sekundy


          const startPointRadio = document.querySelector('input[name="start-point"]:checked');
          if (!startPointRadio) {
            alert("Wybierz punkt startowy.");
            return;
          }

          // Wyodrębniamy współrzędne punktu startowego
          const [startLat, startLng] = startPointRadio.value.split(',');

          // Zbieramy zaznaczone checkboxy jako punkty pośrednie
          const checkboxes = document.querySelectorAll('.location-checkbox:checked');
          const waypoints = [];

          checkboxes.forEach(checkbox => {
            const latitude = checkbox.getAttribute('data-latitude');
            const longitude = checkbox.getAttribute('data-longitude');
            if (latitude && longitude) {
              //console.log("lat: " + latitude + "long: " + longitude);
              waypoints.push({
                location: new google.maps.LatLng(latitude, longitude),
                stopover: true
              });
            }
          });

          // Jeśli mamy przynajmniej jeden punkt pośredni
          if (waypoints.length > 0) {
            // Dodajemy punkt końcowy (to będzie punkt startowy)
            /*waypoints.push({
              location: new google.maps.LatLng(startLat, startLng),
              stopover: true
            });*/

            // Przed wysłaniem do API, logujemy wszystkie punkty
            //console.log("Punkty wysyłane do API:");
            //console.log("Punkt startowy: ", { lat: startLat, lng: startLng });
            //waypoints.forEach((waypoint, index) => {
            //  console.log(`Punkt ${index + 1}: `, waypoint.location);
            //});

            // Konstruujemy żądanie do API Directions
            const request = {
              origin: new google.maps.LatLng(startLat, startLng),
              destination: new google.maps.LatLng(startLat, startLng), // Punkt końcowy to ten sam co startowy
              waypoints: waypoints,
              optimizeWaypoints: true, // Optymalizowanie punktów pośrednich
              travelMode: google.maps.TravelMode.DRIVING
            };

            // Wywołanie Directions API
            directionsService.route(request, function (result, status) {
              if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.setDirections(result);
                result.routes[0].legs.pop();

                // Wyświetlamy posortowane punkty
                const sortedWaypoints = result.routes[0].waypoint_order; // Kolejność punktów pośrednich po optymalizacji
                displaySortedPoints(sortedWaypoints, waypoints, result.routes[0].legs);
                //console.log(result.routes[0].legs);
                updateSummary(result.routes[0].legs);

              } else {
                alert("Nie udało się wygenerować trasy.");
              }
            });
          } else {
            alert("Wybierz przynajmniej jeden punkt pośredni.");
          }
        }

        // Funkcja do wyszukania sklepu po współrzędnych
        function findShopByLatLng(lat, lng) {
          //console.log(lat);
          //console.log(lng);
          return shops.find(shop => shop.latitude == lat && shop.longitude == lng);
        }

        function updateSummary(legs) {
          let totalDistance = 0; // Łączna odległość w metrach
          let totalDuration = 0; // Łączny czas przejazdów w minutach

          // Iterujemy przez wszystkie odcinki trasy
          legs.forEach(leg => {
            // Parsujemy odległość na liczbę, zakładając, że wartość jest podana w kilometrach, np. "5.2 km"
            const distanceText = leg.distance.text;
            const distanceValue = parseFloat(distanceText.replace(" km", "").replace(",", "."));
            totalDistance += distanceValue;
            //console.log(distanceValue);

            // Parsujemy czas na liczbę, zakładając, że wartość jest podana w minutach, np. "8 min"
            const durationText = leg.duration.text;
            const durationValue = parseInt(durationText.replace(" min", ""));
            totalDuration += durationValue;
          });

          // Zaokrąglamy łączną odległość do dwóch miejsc po przecinku
          totalDistance = totalDistance.toFixed(2);

          // Aktualizujemy element z id "summary_opti"
          const summaryElement = document.getElementById("summary_opti");
          summaryElement.innerHTML = `<b>Trasa:</b> ${totalDistance} km</br><b>Czas jazdy:</b> ${totalDuration} min`;
        }


        function displaySortedPoints(sortedWaypoints, waypoints, legs) {
          // Usuwamy poprzednią listę punktów
          const pointsList = document.getElementById("table-list");
          pointsList.innerHTML = '';

          // Ustawiamy czas przyjazdu do pierwszego punktu na wartość startową
          let arrivalTime = time_start;

          // Wyświetlamy posortowane punkty z informacjami o odległości i czasie
          sortedWaypoints.forEach((waypointIndex, index) => {
            const waypoint = waypoints[waypointIndex];
            const leg = legs[index];
            const latLng = waypoint.location;
            const distance = leg.distance.text; // Odległość
            const duration = leg.duration.text; // Czas przejazdu jako tekst np. "8 min"

            // Znajdź sklep na podstawie współrzędnych
            const shop = findShopByLatLng(latLng.lat(), latLng.lng());

            // Parsujemy wartość czasu przejazdu na minuty
            const durationMinutes = parseInt(duration.split(" ")[0]);

            // Obliczamy czas przyjazdu jako czas rozpoczęcia plus czas przejazdu
            arrivalTime = addMinutesToTime(arrivalTime, durationMinutes);

            // Obliczamy czas zakończenia jako czas przyjazdu plus czas na miejscu
            const endTime = addMinutesToTime(arrivalTime, time_onsite / 60);

            // Tworzymy element tabeli dla obecnego punktu z danymi sklepu
            const li = document.createElement("tr");
            let fname = "";
            if (shop) {
              if (shop.friendly_name != "") {
                fname = "(" + shop.friendly_name + ")";
              }
            }
            li.innerHTML = `
      <td>${shop ? shop.full_name : 'N/A'} ${fname}</td>
      <td>${shop ? shop.address : 'N/A'}</td>
      <td>${arrivalTime}</td>
      <td>${endTime}</td>
      <td>${distance}</td>
      <td>${duration}</td>
      `;
            //<td>${latLng.lat()}, ${latLng.lng()}</td>
            pointsList.appendChild(li);

            // Ustawiamy nowy czas przyjazdu na czas zakończenia dla kolejnego punktu
            arrivalTime = endTime;
          });
        }
      </script>
      <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $data["token"]; ?>&callback=initMap"></script>

    </main>
    <?php require_once 'landings/footer.view.php' ?>