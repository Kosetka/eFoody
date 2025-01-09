<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
  <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <?php
                if($data["edit"] === True) {
                    $edit = True;
                    $head2 = "Edytowanie punktów";
                    $button2 = "Zapisz zmiany";
                    $hidden = "";
                    if($data["comp"]->moved == 1) {
                        $blocked = " disabled";
                        $hidden = " hidden";
                    } else {
                        $blocked = "";
                        $hidden = "";
                    }
                } else {
                    $head2 = "Dodawanie nowego punktu";
                    $button2 = "Dodaj punkt";
                    $edit = False;
                    $blocked = "";
                    $hidden = "";
                }
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class=""><?= $head2;?></h2>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="text-start">
                        <div class="form-group row m-3">
                            <label for="name" class="col-sm-2 col-form-label">Nazwa sklepu:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" required <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->name."'"; }?>>
                            </div>
                        </div>
                        <div class="row m-3 align-items-center">
                            <label for="street" class="col-sm-2 col-form-label">Ulica:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="street" name="street" <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->street."'"; }?>>
                            </div>
                            <label for="street_number" class="col-sm-2 col-form-label text-end">Numer:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="street_number" name="street_number" <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->street_number."'"; }?>>
                            </div>
                        </div>
                        <div class="row m-3 align-items-center">
                            <label for="postal_code" class="col-sm-2 col-form-label">Kod pocztowy:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="postal_code" name="postal_code" <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->postal_code."'"; }?>>
                            </div>
                            <label for="city" class="col-sm-2 col-form-label text-end">Miejscowość:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="city" name="city" <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->city."'"; }?>>
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="fuel_type" class="col-sm-2 col-form-label">Rodzaj punktu:</label>
                            <div class="col-sm-10">
            <?php
                $checked = "checked";
                foreach (COMPANYTYPE as $f_type_key => $f_type_val) {
                    if($edit) {
                        if ($data["comp"]->type == $f_type_key) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                    }
                    
                    echo "  <div class='form-check'>
                                <input class='form-check-input' type='radio' name='type' id='type$f_type_key' value='$f_type_key' $checked $blocked>
                                <label class='form-check-label' for='type$f_type_key'>
                                $f_type_val
                                </label>
                            </div>";
                    $checked = "";
                }
            ?>
                        
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="phone_number" class="col-sm-2 col-form-label">Numer telefonu:</label>
                            <div class="col-sm-2">
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->phone_number."'"; }?>>
                            </div>
                        </div>
                        <div class="row m-3 align-items-center">
                            <label for="latitude" class="col-sm-2 col-form-label">Długość geograficzna:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="latitude" name="latitude" <?php //echo $blocked;?> <?php if($edit) {echo " value='".$data["comp"]->latitude."'"; }?>>
                            </div>
                            <label for="longitude" class="col-sm-2 col-form-label text-end">Szerokość geograficzna:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="longitude" name="longitude" <?php //echo $blocked;?> <?php if($edit) {echo " value='".$data["comp"]->longitude."'"; }?>>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primary" <?=$blocked;?> onclick="getLocation()">Pobierz współrzędne</button>
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="status" class="col-sm-2 col-form-label">Status:</label>
                            <div class="col-sm-10">
            <?php
                $checked = "checked";
                foreach (COMPANYVISIT as $f_type_key => $f_type_val) {
                    if($edit) {
                        if ($data["comp"]->status == $f_type_key) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                    }
                    
                    echo "  <div class='form-check'>
                                <input class='form-check-input' type='radio' name='status' id='status$f_type_key' value='$f_type_key' $checked $blocked>
                                <label class='form-check-label' for='status$f_type_key'>
                                $f_type_val
                                </label>
                            </div>";
                    $checked = "";
                }
            ?>
                        
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="description" class="col-sm-2 col-form-label">Opis:</label>
                            <div class="col-sm-10">
                                <input type="textarea" class="form-control" id="description" name="description" <?=$blocked;?> <?php if($edit) {echo " value='".$data["comp"]->description."'"; }?>>
                            </div>
                        </div>
                        
                    




                    <?php 
                        if($edit) {
                            ?>
                            <div id="div-moved" class="form-group row m-3" style="display: none;">
                                <label for="moved" class="col-sm-2 col-form-label" style ="color: green;">Zamień na sklep:</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" class="form-check-input" id="moved" name="moved" value="1" <?=$blocked;?> <?php if($edit) {if($data["comp"]->moved == 1) {echo " checked"; }}?>>
                                </div>
                            </div>


                            <div id="div-moved2" class="form-group row m-3" style="display: none;" <?=$hidden;?>>
                            <label for="driver" class="col-sm-2 col-form-label">Kierowca:</label>
                            <div class="col-sm-10">
            <?php
                $checked = "checked";
                foreach ($data["drivers"] as $f_type_key => $f_type_val) {
                    echo "  <div class='form-check'>
                                <input class='form-check-input' type='radio' name='driver' id='driver$f_type_key' value='$f_type_key' $checked $blocked>
                                <label class='form-check-label' for='driver$f_type_key'>
                                $f_type_val->first_name $f_type_val->last_name 
                                </label>
                            </div>";
                            $checked = "";
                }
            ?>
                        
                            </div>
                        </div>

                        <div id="div-moved3" class="form-group row m-3" style="display: none;" <?=$hidden;?>>
                            <label for="hours" class="col-sm-2 col-form-label">Godziny dostawy:</label>
                            <div class="col-sm-10">
            <?php
                $checked = "checked";
                foreach (DELIVERYHOUR as $f_type_key => $f_type_val) {
                    if(!$f_type_key == 0) {
                        echo "  <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='hours' id='hours$f_type_key' value='$f_type_key' $checked $blocked>
                                    <label class='form-check-label' for='hours$f_type_key'>
                                    $f_type_val
                                    </label>
                                </div>";
                        $checked = "";
                    }
                }
            ?>
                        
                            </div>
                        </div>

                            <div id="div-to-delete" class="form-group row m-3" style="display: none;">
                                <label for="to_delete" class="col-sm-2 col-form-label" style ="color: red;">Do usunięcia?:</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" class="form-check-input" id="to_delete" name="to_delete" value="1" <?=$blocked;?> <?php if($edit) {if($data["comp"]->to_delete == 1) {echo " checked"; }}?>>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                const statusRadios = document.querySelectorAll('input[name="status"]');
                                const divMoved = document.getElementById("div-moved");
                                const divMoved2 = document.getElementById("div-moved2");
                                const divMoved3 = document.getElementById("div-moved3");
                                const divToDelete = document.getElementById("div-to-delete");

                                function handleStatusChange() {
                                    const selectedStatus = document.querySelector('input[name="status"]:checked').value;

                                    // Jeśli status = 3, pokaż "Zamień na sklep", ukryj "do usunięcia"
                                    if (selectedStatus == "2") {
                                        divMoved.style.display = "flex";
                                        divMoved2.style.display = "flex";
                                        divMoved3.style.display = "flex";
                                        divToDelete.style.display = "none";
                                    } 
                                    // Jeśli status jest inny niż 0 lub 3, pokaż "do usunięcia", ukryj "Zamień na sklep"
                                    else if (selectedStatus != "0") {
                                        divMoved.style.display = "none";
                                        divMoved2.style.display = "none";
                                        divMoved3.style.display = "none";
                                        divToDelete.style.display = "flex";
                                    } 
                                    // W przeciwnym razie ukryj oba
                                    else {
                                        divMoved.style.display = "none";
                                        divMoved2.style.display = "none";
                                        divMoved3.style.display = "none";
                                        divToDelete.style.display = "none";
                                    }
                                }

                                // Nasłuchuj zmiany na wszystkich przyciskach typu radio
                                statusRadios.forEach(function (radio) {
                                    radio.addEventListener("change", handleStatusChange);
                                });

                                // Uruchom na początku, aby ustawić widoczność na podstawie wstępnie wybranego statusu
                                handleStatusChange();
                            });
                            </script>
                    <?php
                        }
                    ?>



                    </div>
                        <?php 
                            if($blocked<>"") {
                                echo '<input hidden type="input" id="is_added" name="is_added" value="1">';                         
                            }
                        
                        ?>
                        <button class="w-100 btn btn-lg btn-primary" type="submit" <?php //echo $blocked;?> name="newadd"><?=$button2;?></button>
                    </form>
                </div>
            </div>
            <script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // Pobierz współrzędne
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Uzupełnij inputy w formularzu
                    document.getElementById("latitude").value = latitude;
                    document.getElementById("longitude").value = longitude;
                },
                (error) => {
                    // Obsługa błędów
                    let errorMessage = '';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = "Brak zgody na udostępnienie lokalizacji.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = "Dane lokalizacji są niedostępne.";
                            break;
                        case error.TIMEOUT:
                            errorMessage = "Przekroczono czas oczekiwania na lokalizację.";
                            break;
                        default:
                            errorMessage = "Wystąpił nieznany błąd.";
                            break;
                    }
                    alert(errorMessage);
                }
            );
        } else {
            alert("Geolokalizacja nie jest obsługiwana przez Twoją przeglądarkę.");
        }
    }
</script>
      <script>
        // Funkcja sprawdzająca stan select i blokująca przycisk submit
        function checkSelectAndDisableSubmit(formId, selectId, submitId) {
            const selectElement = document.getElementById(selectId);
            const submitButton = document.getElementById(submitId);
            
            // Jeśli wartość wybrana w select to 0 i tekst to "-", zablokuj przycisk submit
            selectElement.addEventListener('change', function() {
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

        const companyVisit = <?php echo json_encode(COMPANYVISIT, JSON_HEX_TAG | JSON_HEX_QUOT); ?>;

      </script>

      <div class="card mb-4">
        <div class="card-header">
          <h2 class="">Najbliższe punkty</h2>
          <button class="btn btn-secondary" onclick="sortLocations(points)">Pokaż najbliższe punkty</button>
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
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $link = "https://www.google.com/maps/dir//";
                    $points = [];
                    /*foreach ($data["companies_sorted"] as $key => $value) {
                        echo "<tr>
                                <td></td>
                                <td>$value->name</td>
                                <td>$value->address</td>
                                <td>$value->phone_number</td>
                                <td>" . COMPANYTYPE[$value->type] . "</td>";

                        echo "<form method='POST' action='' id='form_$key'>"; // Dodanie unikalnego ID do formularza
                        echo "
                                <td>
                                <select name='status' class='form-control' id='status_$key'>"; // Dodanie unikalnego ID do selecta
                        foreach(COMPANYVISIT as $kk => $vv) {
                            echo "<option value='$kk'>$vv</option>";
                        }
                        echo "  </select>
                                <input type='text' class='form-control' style='margin: 20px 0 !important;' name='description' placeholder='Dodaj notatkę' />
                                    <input type='hidden' name='id' value='$key' />
                                    <button type='submit' class='btn btn-primary' id='submit_$key'>Zapisz</button> <!-- Unikalny ID przycisku -->
                                </td>
                            </form>";

                        echo "</tr>";
                    }*/
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
    distances.slice(0, 10).forEach(point => {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${point.distance.toFixed(3)} km</td>
        <td>${point.name}</td>
        <td>${point.address}</td>
        <td>${point.phone_number}</td>
        <td>${point.type}</td>
        <td>${point.status}</td>
    `;
    tbody.appendChild(row);

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


<?php
    echo "const points = [";
    foreach ($data["companies_sorted"] as $company) {
        $full_name = $company->name;
        $address = $company->address;
        $phone = $company->phone_number;
        $type = COMPANYTYPE[$company->type];
        $status = COMPANYVISIT[$company->status];
        
        $id = $company->id;
        echo "{ lat: $company->latitude, lng: $company->longitude, id: $id, name: '$full_name', address: '$address', phone_number: '$phone', type: '$type', status: '$status' },";
    }
    echo "];";
?>
        //console.log(points);



    </script>
    
    <?php require_once 'landings/footer.view.php' ?>