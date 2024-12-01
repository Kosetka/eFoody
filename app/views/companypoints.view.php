<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
      <div class="card mb-4">

        <!---<div id="map" style="height: 400px;"></div>!-->

        <div class="card-header">
          <h2 class="">Miejsca do odwiedzenia</h2>
          <button class="btn btn-secondary" onclick="sortLocations(points)">Sortuj punkty według odległości</button>
          <a href="<?php echo ROOT . "/company/pointadd"; ?>" class="btn btn-primary">Dodaj nowy punkt</a>
        </div>
        <div class="form-group row m-3">
          <div class="col-sm-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Odległość</th>
                  <th scope="col">Nazwa firmy</th>
                  <th scope="col">Adres</th>
                  <th scope="col">Telefon</th>
                  <th scope="col">Typ punktu</th>
                  <th scope="col">Mapa</th>
                  <th scope="col">Akcje</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $link = "https://www.google.com/maps/dir//";
                $points = [];
                foreach ($data["companies_sorted"] as $key => $value) {
                  echo "<tr>
                    <td></td>
                    <td>$value->name</td>
                    <td>$value->address</td>
                    <td>$value->phone_number</td>
                    <td>" . COMPANYTYPE[$value->type] . "</td>
                    <td><a target='blank' href='$link" . $value->latitude . "," . $value->longitude . "'>Nawiguj</a></td>";

                  echo "<form method='POST' action='' id='form_$key'>"; // Dodanie unikalnego ID do formularza
                  echo "
                    <td>
                    <select name='status' class='form-control' id='status_$key'>"; // Dodanie unikalnego ID do selecta
                  foreach (COMPANYVISIT as $kk => $vv) {
                    echo "<option value='$kk'>$vv</option>";
                  }
                  echo "  </select>
                    <input type='text' class='form-control' style='margin: 20px 0 !important;' name='description' placeholder='Dodaj notatkę' />
                        <input type='hidden' name='id' value='$key' />
                        <button type='submit' class='btn btn-primary' id='submit_$key'>Zapisz</button> <!-- Unikalny ID przycisku -->
                    </td>
                </form>";

                  echo "</tr>";

                  $points[$key] = [
                    "name" => $value->name,
                    "lat" => $value->latitude,
                    "lng" => $value->longitude,
                    "type" => "$value->type"
                  ];
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <script>
        // Funkcja sprawdzająca stan select i blokująca przycisk submit
        function checkSelectAndDisableSubmit(formId, selectId, submitId) {
          const selectElement = document.getElementById(selectId);
          const submitButton = document.getElementById(submitId);

          // Jeśli wartość wybrana w select to 0 i tekst to "-", zablokuj przycisk submit
          selectElement.addEventListener('change', function () {
            if (selectElement.value === '0' && selectElement.options[selectElement.selectedIndex].text === '-') {
              submitButton.disabled = true; // Blokujemy przycisk
            } else {
              submitButton.disabled = false; // Odblokowujemy przycisk
            }
          });

          // Inicjalizacja stanu przycisku na podstawie początkowej wartości selecta
          if (selectElement.value === '0' && selectElement.options[selectElement.selectedIndex].text === '-') {
            submitButton.disabled = true; // Blokujemy przycisk, jeśli warunki są spełnione
          }
        }

        // Inicjalizacja dla wszystkich formularzy
        window.onload = function () {
          <?php foreach ($data["companies_sorted"] as $key => $value): ?>
            checkSelectAndDisableSubmit('form_<?php echo $key; ?>', 'status_<?php echo $key; ?>', 'submit_<?php echo $key; ?>');
          <?php endforeach; ?>
        };
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAJHFF9bGryg9sEfdgy5ukLAai8nRMKcU&callback=initMap"
        async defer></script>
      <script>

        /*async function initMap() {
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
        <div class="price"><a target='blank' href='${property.url}'>${property.name}</a></div>
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
          /*foreach ($points as $k => $point) {
            $lat = $point["lat"];
            $lng = $point["lng"];
            $name = "<b>" . $point["name"] . "</b></br></br><a href='https://www.google.com/maps/dir//" . $lat . "," . $lng . "'>Pokaż na mapie</a>";
            echo ' 
            {
                position: {lat: ' . $lat . ', lng: ' . $lng . '},
                title: "' . $name . '",
                name: "' . $point["name"] . '",
                type: "' . $point["type"] . '",
                free: "",
                url: "https://www.google.com/maps/dir//' . $lat . ',' . $lng . '"
            },';
          }*/
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
          // Tutaj możesz dodać więcej znaczników na mapie, jeśli jest taka potrzeba
        }*/

        function generateOptions(companyVisit) {
          let options = '';
          for (const [key, value] of Object.entries(companyVisit)) {
            options += `<option value="${key}">${value}</option>`;
          }
          return options;
        }
        const companyVisit = <?php echo json_encode(COMPANYVISIT, JSON_HEX_TAG | JSON_HEX_QUOT); ?>;

        const selectHtml = `${generateOptions(companyVisit)}`;
        console.log(selectHtml);
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
                foreach (COMPANYVISIT as $k => $v) {
                  if ($k == 0)
                    $type[$k] = "secondary";
                  if ($k == 1)
                    $type[$k] = "danger";
                  if ($k == 2)
                    $type[$k] = "success";
                  if ($k == 3)
                    $type[$k] = "danger";
                  if ($k == 4)
                    $type[$k] = "secondary";
                  if ($k == 5)
                    $type[$k] = "info";
                  if ($k == 6)
                    $type[$k] = "secondary";
                  if ($k == 7)
                    $type[$k] = "info";
                  if ($k == 8)
                    $type[$k] = "info";
                  if ($k == 9)
                    $type[$k] = "warning";
                }

                if (isset($data["companies_visited"])) {
                  foreach ($data["companies_visited"] as $key => $value) {
                    echo "  <tr><td>$value->name</td>
                                                <td>$value->address</td>
                                                <td>$value->description</td>
                                                <td>$value->visit_date</td>
                                                <td><span class='btn btn-" . $type[$value->status] . "'>" . COMPANYVISIT[$value->status] . "<span></td>
                                                <td><a target='blank' href='" . $link . $value->latitude . "," . $value->longitude . "'>Przejdź do mapy</a></td>";
                    echo "</tr>";
                  }
                }

                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
    <script>


      // Funkcja do obliczania odległości między dwoma punktami geograficznymi (Haversine formula)
      function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Promień Ziemi w kilometrach
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a =
          Math.sin(dLat / 2) * Math.sin(dLat / 2) +
          Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
          Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Odległość w kilometrach
      }

      // Funkcja do sortowania tabeli
      function sortTableByDistance(userLat, userLng, points) {
        const distances = points.map(point => {
          const distance = calculateDistance(userLat, userLng, point.lat, point.lng);
          return { ...point, distance };
        });

        // Sortuj punkty według odległości
        distances.sort((a, b) => a.distance - b.distance);

        // Znajdź element tbody i wyczyść jego zawartość
        const tbody = document.querySelector(".table tbody");
        tbody.innerHTML = "";

        // Dodaj posortowane wiersze
        distances.forEach(point => {
          const row = document.createElement("tr");
          row.innerHTML = `
        <td>${point.distance.toFixed(3)} km</td>
        <td>${point.name}</td>
        <td>${point.address}</td>
        <td>${point.phone_number}</td>
        <td>${point.type}</td>
        <td>
            <form method="POST" action="" id="form_${point.type}">
                <select name="status" class="form-control" id="status_${point.type}">
                    ${selectHtml}
                </select>
                <input type="text" class="form-control" style="margin: 20px 0 !important;" name="description" placeholder="Dodaj notatkę" />
                <input type="hidden" name="id" value="${point.id}" />
                <button type="submit" class="btn btn-primary" id="submit_${point.type}">Zapisz</button>
            </form>
        </td>
    `;
          tbody.appendChild(row);

          // Funkcja do blokowania przycisku submit
          function checkSelectAndDisableSubmit(selectId, submitId) {
            const selectElement = document.getElementById(selectId);
            const submitButton = document.getElementById(submitId);

            // Dodanie nasłuchiwania na zmianę wyboru
            selectElement.addEventListener('change', function () {
              if (selectElement.value === '0' && selectElement.options[selectElement.selectedIndex].text === '-') {
                submitButton.disabled = true; // Blokowanie przycisku
              } else {
                submitButton.disabled = false; // Odblokowywanie przycisku
              }
            });

            // Inicjalizacja na podstawie początkowej wartości selecta
            if (selectElement.value === '0' && selectElement.options[selectElement.selectedIndex].text === '-') {
              submitButton.disabled = true; // Blokowanie przycisku, jeśli warunki są spełnione
            }
          }

          // Inicjalizacja dla wygenerowanego formularza
          checkSelectAndDisableSubmit(`status_${point.type}`, `submit_${point.type}`);
        });
      }

      // Funkcja wywoływana po kliknięciu przycisku
      function sortLocations(points) {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(position => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            // Wywołanie sortowania tabeli
            sortTableByDistance(userLat, userLng, points);
          }, error => {
            console.error("Nie udało się pobrać lokalizacji:", error);
            alert("Nie udało się pobrać lokalizacji. Upewnij się, że udostępniasz swoją lokalizację.");
          });
        } else {
          alert("Twoja przeglądarka nie wspiera geolokalizacji.");
        }
      }

      // Przykład danych z PHP (wstawiane przez backend)

      <?php
      echo "const points = [";
      foreach ($data["companies_sorted"] as $company) {
        $full_name = $company->name;
        $address = $company->address;
        $phone = $company->phone_number;
        $type = COMPANYTYPE[$company->type];

        $id = $company->id;
        echo "{ lat: $company->latitude, lng: $company->longitude, id: $id, name: '$full_name', address: '$address', phone_number: '$phone', type: '$type' },";
      }
      echo "];";
      ?>
      //console.log(points);



    </script>

    <?php require_once 'landings/footer.view.php' ?>