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
                                        if(isset($company->latitude) && $company->latitude != "") {
                                            if(isset($company->longitude) && $company->longitude != "") {
                                                $gps_link = "https://www.google.com/maps?q=".$company->latitude.",".$company->longitude;
                                            }
                                        }
                                        echo "<tr>
                                                <td>$company->full_name</td>
                                                <td>$company->address</td>
                                                <td>$company->contact_first_name $company->contact_last_name</td>
                                                <td>$company->phone_number</td>
                                                <td>$company->email</td>
                                                $active
                                                <td>$company->description</td>";
                                        if($gps_link == "#") {
                                            echo "<td></td>";
                                        } else {
                                            echo "<td><a href='$gps_link' target='_blank'>Pokaż na mapie</a></td>";
                                        }
                                        echo "<td></td>";
                                        if($gps_link == "#") {
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
                    <div class="card-body">
                        <!-- Lista wyboru punktu startowego -->
                        <label>Wybierz punkt startowy:</label>
                        <div id="start-point-options">
                            <!-- Przykładowe punkty startowe - zastąp je swoimi -->
                             <?php
                                foreach($data["warehouse"] as $wh) {
                                    echo '<label><input type="radio" name="start-point" value="'.$wh->w_lat.','.$wh->w_lon.'"> '.$wh->c_fullname .' '.$wh->wh_fullname.'</label><br>';
                                }
                             ?>
                        </div>

                        <!-- Przycisk do generowania trasy i link do Google Maps -->
                        <button id="generate-route" onclick="generateRoute()">Generuj trasę</button>
                        <a id="route-link" href="#" target="_blank" style="display:none;">Zobacz trasę na Google Maps</a>
                    </div>

                    <div class="card-body">
                    <!-- Tutaj powinien znajdować się kod generujący listę firm z checkboxami, tak jak wcześniej -->
                    </div>
                </div>
            </div>
            <div id="map"></div>
            <div id="points-list">
    <h3>Posortowane punkty:</h3>
    <ul id="points-ul"></ul>
  </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$data["token"];?>&callback=initMap" async defer></script>
   

    <script>
  let map;
  let directionsService;
  let directionsRenderer;

  const shops = <?php echo json_encode($data["companies"]); ?>; // Przekazanie danych o sklepach do JavaScript


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
        console.log("lat: " + latitude + "long: " + longitude);
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
      console.log("Punkty wysyłane do API:");
      console.log("Punkt startowy: ", { lat: startLat, lng: startLng });
      waypoints.forEach((waypoint, index) => {
        console.log(`Punkt ${index + 1}: `, waypoint.location);
      });

      // Konstruujemy żądanie do API Directions
      const request = {
        origin: new google.maps.LatLng(startLat, startLng),
        destination: new google.maps.LatLng(startLat, startLng), // Punkt końcowy to ten sam co startowy
        waypoints: waypoints,
        optimizeWaypoints: true, // Optymalizowanie punktów pośrednich
        travelMode: google.maps.TravelMode.DRIVING
      };

      // Wywołanie Directions API
      directionsService.route(request, function(result, status) {
        if (status === google.maps.DirectionsStatus.OK) {
          directionsRenderer.setDirections(result);

          // Wyświetlamy posortowane punkty
          const sortedWaypoints = result.routes[0].waypoint_order; // Kolejność punktów pośrednich po optymalizacji
          displaySortedPoints(sortedWaypoints, waypoints, result.routes[0].legs);
        } else {
          alert("Nie udało się wygenerować trasy.");
        }
      });
    } else {
      alert("Wybierz przynajmniej jeden punkt pośredni.");
    }
  }

  function displaySortedPoints(sortedWaypoints, waypoints, legs) {
    // Usuwamy poprzednią listę punktów
    const pointsList = document.getElementById("points-ul");
    pointsList.innerHTML = '';

    // Wyświetlamy posortowane punkty z informacjami o odległości i czasie
    sortedWaypoints.forEach((waypointIndex, index) => {
      const waypoint = waypoints[waypointIndex];
      const leg = legs[index];

      const latLng = waypoint.location;
      const distance = leg.distance.text; // Odległość
      const duration = leg.duration.text; // Czas przejazdu

      const li = document.createElement("li");
      li.innerHTML = `Punkt ${index + 1}: ${latLng.lat()}, ${latLng.lng()}<br>Odległość: ${distance}, Czas: ${duration}`;
      pointsList.appendChild(li);
    });
  }
</script>

        </main>
        <?php require_once 'landings/footer.view.php' ?>