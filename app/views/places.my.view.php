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
                                        $total_gratis_amount = 0;
                                        $total_regular_amount = 0;
                                        if(!empty($data["soldCompany"][$key])) {
                                            $total_gratis_amount = $data["soldCompany"][$key]->total_gratis_amount;
                                        }
                                        if(!empty($data["soldCompany"][$key])) {
                                            $total_regular_amount = $data["soldCompany"][$key]->total_regular_amount;
                                        }
                                        echo "  <tr><td>$value->full_name</td>
                                            <td>$value->address</td>
                                            <td>$value->description</td>
                                            <td><a target='blank' href='".$link.$value->latitude.",".$value->longitude."'>Przejdź do mapy</a></td>
                                            <td><a class='btn btn-warning' onClick = 'clicked($key)' data-el=$key 
                                            role='button'>Oznacz jako odwiedzony</a></td>";
                                        echo "</tr>";
                                

                                        $points[$key] = ["name" => $value->full_name, "lat" => $value->latitude, "lng"=> $value->longitude, "workers" => "$value->workers", "yesterday" => $total_regular_amount,"free"=>$total_gratis_amount, "type" => "$value->c_type"];
                                    }
                                    ?>
                                    <script>
                                function clicked(id, user) {
                                    $.ajax({
                                        url: '<?php echo ROOT . "/places/setvisit/" ?>' + id,
                                        success: function (data) {
                                            //alert("Oznaczono jako odwiedzone.");
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
  content.innerHTML = `
    <div class="icon">
        <i aria-hidden="true" class="fa fa-icon fa-${property.type}" title="${property.type}"></i>
        <span class="fa-sr-only">${property.type}</span>
    </div>
    <div class="details">
        <div class="price">${property.name}</div>
        <div class="address"><a target='blank' href='${property.url}'>Pokaż na mapie</a></div>
        <div class="features">
        <div>
            <i aria-hidden="true" class="fa fa-credit-card fa-lg bed" title="Sprzedane"></i>
            <span class="fa-sr-only">Sprzedane</span>
            <span>${property.yesterday}</span>
        </div>
        <div>
            <i aria-hidden="true" class="fa fa-gift fa-lg gift" title="Prezenty"></i>
            <span class="fa-sr-only">Prezenty</span>
            <span>${property.free}</span>
        </div>
        <div>
            <i aria-hidden="true" class="fa fa-users fa-lg bath" title="Pracownicy"></i>
            <span class="fa-sr-only">Pracownicy</span>
            <span>${property.workers}</span>
        </div>
        </div>
    </div>
    `;
  return content;
}

const properties = [
    <?php
        foreach($points as $k => $point) {
            $lat = $point["lat"];
            $lng = $point["lng"];
            $name = "<b>".$point["name"] . "</b></br></br><a href='https://www.google.com/maps/dir//".$lat.",".$lng."'>Pokaż na mapie</a>";
            echo ' 
            {
                position: {lat: '.$lat.', lng: '.$lng.'},
                title: "'.$name.'",
                name: "'.$point["name"].'",
                workers: "'.$point["workers"].'",
                yesterday: "'.$point["yesterday"].'",
                type: "'.$point["type"].'",
                free: "",
                url: "https://www.google.com/maps/dir//'.$lat.','.$lng.'"
            },';
        }
      ?>
  
    /*address: "215 Emily St, MountainView, CA",
    description: "Single family house with modern design",
    price: "$ 3,889,000",
    type: "home",
    bed: 5,
    bath: 4.5,
    size: 300,
    position: {
      lat: 37.50024109655184,
      lng: -122.28528451834352,
    },*/
];


function handleLocationError(browserHasGeolocation, infoWindow2, pos) {
infoWindow2.setPosition(pos);
infoWindow2.setContent(
  browserHasGeolocation
    ? "Error: The Geolocation service failed."
    : "Error: Your browser doesn't support geolocation.",
);
infoWindow2.open(map);
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
                                        <th scope="col">Rezultat wizyty</th>
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