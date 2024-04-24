<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
        <div class="card mb-4">

  <div id="map" style="height: 400px;"></div>


                <div class="card-header">
                    <h2 class="">Miejsca do odwiedzenia</h2>
                </div>
                <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nazwa firmy</th>
                                        <th scope="col">Adres</th>
                                        <th scope="col">Opis</th>
                                        <th scope="col">Mapa</th>
                                        <th scope="col">Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $link = "https://www.google.com/maps/dir//";
                                    $points = [];
                                    foreach ($data["not_visited"] as $key => $value) {
                                        echo "  <tr><td>$value->full_name</td>
                                            <td>$value->address</td>
                                            <td>$value->description</td>
                                            <td><a target='blank' href='".$link.$value->latitude.",".$value->longitude."'>Przejdź do mapy</a></td>
                                            <td><a class='btn btn-warning' onClick = 'clicked($key)' data-el=$key 
                                            role='button'>Oznacz jako odwiedzony</a></td>";
                                        echo "</tr>";
                                        $points[$key] = ["name" => $value->full_name, "lat" => $value->latitude, "lng"=> $value->longitude];
                                    }
                                    ?>
                                    <script>
                                function clicked(id, user) {
                                    $.ajax({
                                        url: '<?php echo ROOT . "/places/setvisit/" ?>' + id,
                                        success: function (data) {
                                            alert("Oznaczono jako odwiedzone.");
                                            window.location.href = window.location.href
                                        }
                                    });
                                }
                            </script>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAJHFF9bGryg9sEfdgy5ukLAai8nRMKcU&callback=initMap" async defer></script>
            <script>
    // Inicjalizacja mapy
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 51.40328, lng: 21.1486}, // Współrzędne centrum mapy 51.40328140169251, 21.14867948697794
        zoom: 15, // Poziom przybliżenia
        mapId: 'e6dc69ca24aac8ed'
      });

      // Tworzenie znaczników
      //var marker1 = new google.maps.Marker({
      //  position: {lat: 51.5111, lng: -0.1234}, // Współrzędne pierwszego znacznika
      //  map: map,
      //  title: 'Znacznik 1' // Nazwa znacznika
      //});
      <?php
        foreach($points as $k => $point) {
            $lat = $point["lat"];
            $lng = $point["lng"];
            $name = $point["name"];
            echo ' 
            var marker'.$k.' = new google.maps.Marker({
                position: {lat: '.$lat.', lng: '.$lng.'},
                map: map,
                title: "'.$name.'",
                //optimized: true,
                url: "https://www.google.com/maps/dir//'.$lat.','.$lng.'"
              });
              ';
        }
      ?>
infoWindow = new google.maps.InfoWindow();

const locationButton = document.createElement("button");

locationButton.textContent = "Pokaż swoją lokalizację";
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

        infoWindow.setPosition(pos);
        infoWindow.setContent("Lokacja znaleziona");
        infoWindow.open(map);
        map.setCenter(pos);
      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      },
    );
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
});
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
infoWindow.setPosition(pos);
infoWindow.setContent(
  browserHasGeolocation
    ? "Error: The Geolocation service failed."
    : "Error: Your browser doesn't support geolocation.",
);
infoWindow.open(map);
      // Tutaj możesz dodać więcej znaczników na mapie, jeśli jest taka potrzeba
    }
  </script>

            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Historia odwiedzonych miejsc</h2>
                </div>
                <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nazwa firmy</th>
                                        <th scope="col">Adres</th>
                                        <th scope="col">Opis</th>
                                        <th scope="col">Data wizyty</th>
                                        <th scope="col">Rezultant wizyty</th>
                                        <th scope="col">Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $link = "https://www.google.com/maps/dir//";
                                    foreach ($data["places"] as $key => $value) {
                                        echo "  <tr><td>$value->full_name</td>
                                            <td>$value->address</td>
                                            <td>$value->description</td>
                                            <td>$value->pl_date</td>
                                            <td>".VISITSTATUSES[$value->sold]."</td>
                                            <td><a target='blank' href='".$link.$value->latitude.",".$value->longitude."'>Przejdź do mapy</a></td>";
                                        echo "</tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>