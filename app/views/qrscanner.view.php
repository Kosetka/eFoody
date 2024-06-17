<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="row">
                <div class="col-md-12">
                    <video
                        style="min-height: 100px; max-height:200px; background-color: lightgrey;box-shadow: 0px 8px 20px 8px rgba(66, 68, 90, 1); margin-bottom: 30px;"
                        id="preview"></video>
                </div>
                <h1 class="h3 mb-3 fw-normal"><button class="btn btn-primary" id="gpsButton">GPS</button> Dane skanu:</h1>
                <p hidden id="lat">Lat: </p>
                <p hidden id="long">Long: </p>
                <form method="post">

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-start">
                        <div class="form-group row m-3">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                            <label for="c_id" class="col-sm-2 col-form-label">Firma:</label>
                            <div class="col-sm-10">
                                <select class="c_id" style="width: 100%" id="c_id" name="c_id" onchange="companyChange()" placeholder="Wybierz firmę...">
                                    <?php
                                    if (isset($_SESSION["selected_company"])) {
                                        $my_company = $_SESSION["selected_company"];
                                    } else {
                                        $my_company = 0;
                                    }
                                    ?>
                                    <option value='0' <?php if ($my_company == 0)
                                        echo "selected"; ?>>Inna </option>
                                    <?php
                                    foreach ($data["companies"] as $company) {
                                        $full_name = $company->full_name . " | " . $company->address;
                                        $id = $company->id;
                                        if ($my_company == $id) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='$id' $selected>$full_name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <script>
    <?php
    echo "const points = [";
    foreach ($data["companies"] as $company) {
        $full_name = $company->full_name . " | " . $company->address;
        $id = $company->id;
        echo "{ lat: $company->latitude, lng: $company->longitude, id: $id, name: '$full_name' },";
    }
    echo "];";
    ?>

    function calculateDistance(lat1, lng1, lat2, lng2) {
      const R = 6371000; // Promień Ziemi w metrach
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLng = (lng2 - lng1) * Math.PI / 180;
      const a = 
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      const distance = R * c; // Odległość w metrach
      return distance;
    }

    function compareCurrentPositionWithPoints() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            const currentLat = position.coords.latitude;
            const currentLng = position.coords.longitude;

            document.getElementById('lat').textContent = 'Lat: ' + currentLat;
            document.getElementById('long').textContent = 'Long: ' + currentLng;

            points.forEach(point => {
              point.distance = calculateDistance(currentLat, currentLng, point.lat, point.lng);
            });

            points.sort((a, b) => a.distance - b.distance);

            const selectElement = document.getElementById('c_id');
            const myCompany = <?php echo isset($_SESSION["selected_company"]) ? $_SESSION["selected_company"] : 0; ?>;
            
            selectElement.innerHTML = "";

            let selectedOption = null;

            points.forEach((point, index) => {
              const option = document.createElement("option");
              option.value = point.id;
              option.text = `${point.distance.toFixed(1)}m | ${point.name}`;

              if (point.id == myCompany) {
                option.selected = true;
                selectedOption = option;
              }

              selectElement.appendChild(option);
            });

            const otherOption = document.createElement("option");
            otherOption.value = '0';
            otherOption.text = 'Inna';

            if (selectedOption === null) {
              otherOption.selected = true;
            }

            selectElement.insertBefore(otherOption, selectElement.firstChild);

            if (selectedOption !== null) {
              selectElement.insertBefore(selectedOption, selectElement.firstChild);
            }
          },
          function(error) {
            console.error("Błąd podczas pobierania pozycji:", error);
          }
        );
      } else {
        console.error("Twoja przeglądarka nie obsługuje Geolocation API.");
      }
    }

    document.getElementById('gpsButton').addEventListener('click', compareCurrentPositionWithPoints);
  </script>



                        <script>
                            let arr = [];
                            let arrid = [];
                            let products = [];
                            <?php
                            if(isset($data["companies"])) {
                                foreach ($data["companies"] as $company) {
                                    echo "arr[" . $company->id . "] = '" . $company->address . "';";
                                    echo "arrid[" . $company->id . "] = '" . $company->id . "';";
                                    //echo "arr.push({'".$company->id."' :'".$company->address."' });";
                                }
                            }
                            foreach ($data["products"] as $prod) {
                                echo "products['" . $prod->sku . "'] = ['name', '" . $prod->p_name . "'];";
                                echo "products['" . $prod->sku . "']['ean'] = '" . $prod->ean . "';";
                                echo "products['" . $prod->sku . "']['sku'] = '" . $prod->sku . "';";
                                echo "products['" . $prod->sku . "']['p_id'] = '" . $prod->id . "';";
                            }
                            ?>
                            function companyChange() {
                                var x = document.getElementById("c_id").value;
                                document.getElementById("c_fullname").value = arr[x];
                                document.getElementById("c_fullname_id").value = arrid[x];
                                console.log(x);
                            }
                        </script>
                        <div class="form-group row m-3">
                            <label for="c_fullname" class="col-sm-2 col-form-label">Adres:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="c_fullname" name="c_fullname" readonly
                                    value="<?php echo $_SESSION["selected_company_fullname"]; ?>">
                                <input hidden type="text" class="form-control" id="c_fullname_id" name="c_fullname_id"
                                    readonly value="<?php echo $_SESSION["selected_company"]; ?>">
                            </div>
                        </div>
                        <?php /*<div class="form-group row m-3">
<label for="c_id" class="col-sm-2 col-form-label">Handlowiec:</label>
<div class="col-sm-10">
<input type="text" class="form-control" id="c_id" name="c_id" readonly <?php echo "value = '" . $_SESSION["USER"]->first_name ." ".$_SESSION["USER"]->last_name . "'" ?>>
</div>
</div>*/ ?>
                        <div class="form-group row m-3">
                            <label for="c_fullname" class="col-sm-2 col-form-label">QR Code:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="text" name="text" readonly>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <table id="tab-show" style="display: none">
                                <tr>
                                    <th>Nazwa</th>
                                    <td> <input type="text" class="form-control" id="prod_name" name="prod_name"
                                            readonly value="">
                                </tr>
                                <tr>
                                    <th>EAN</th>
                                    <td> <input type="text" class="form-control" id="prod_ean" name="prod_ean" readonly
                                            value=""></td>
                                </tr>
                                <tr>
                                    <th>SKU</th>
                                    <td> <input type="text" class="form-control" id="prod_sku" name="prod_sku" readonly
                                            value=""></td>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <td> <input type="text" class="form-control" id="prod_p_id" name="prod_p_id"
                                            readonly value=""></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" id="sendButton" type="submit" hidden>Dodaj skan</button>
                </form>
                <?php
                ?>
            </div>


            <div class="card mb-4" style="margin-top: 50px;">
        <div class="card-header">
          <h2 class="">Ostatnie skanowania QR Code</h2>
        </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th scope="col">Nazwa firmy</th>
                  <th scope="col">Adres</th>
                  <?php /*<th scope="col">QR Code</th>*/ ?>
                  <th scope="col">Produkt</th>
                  <th scope="col">Data</th>
                  <th scope="col">Akcje</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($data["scans"])) {
                    foreach ($data["scans"] as $key => $value) {
                        $prodd = $data["products"][$value->p_id];
                        if($value->c_id == 0) {
                            $city_name = "Inna";
                            $city_address = "";
                        } else {
                            $city_name = $data["companies"][$value->c_id]->full_name;
                            $city_address = $data["companies"][$value->c_id]->address;
                        }
                      echo "<tr><td>$city_name</td>";
                      echo "<td>$city_address</td>";
                      //echo "<td>$prodd->sku</td>";
                      echo "<td>$prodd->p_name</td>";
                      echo "<td>$value->date</td>";
                      echo "<td><a class='btn btn-danger' onClick = 'clicked($key)' data-el=$key role='button'>Usuń</a></td>";
                      echo "</tr>";
                    }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <script>
            function clicked(id) {
                $.ajax({
                    url: '<?php echo ROOT . "/qrscanner/delete/" ?>' + id,
                    success: function (data) {
                        //alert("Pomyślnie usunięto skan");
                        window.location.href = window.location.href
                    }
                });
            }
        </script>
<?php
if(isset($_SESSION["USER"]->camera)) {
    $cam = $_SESSION["USER"]->camera;
} else {
    $cam = 2;
}
?>
        </main>
        <script type="text/javascript"
            src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <script type="text/javascript">
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });

            function startScanner(camIndex) {
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                console.log(cameras);
                if (camIndex >= cameras.length) {
                    console.log("Invalid camera index");
                    return;
                }
                scanner.start(cameras[camIndex]).catch(function (e) {
                    console.error("Error starting camera:", e);
                    console.log("Error starting camera: " + e.message);
                });
                } else {
                    console.log("No cameras found.");
                }
            }).catch(function (e) {
                console.error(e);
            });
            }

            function stopScanner() {
            scanner.stop().then(function () {
                console.log("Scanner stopped.");
            }).catch(function (e) {
                console.error("Error stopping scanner:", e);
            });
            }

            startScanner(<?=$cam?>); // Pass the camera index dynamically

            document.addEventListener("visibilitychange", function () {
            if (document.visibilityState === 'hidden') {
                stopScanner();
            } else if (document.visibilityState === 'visible') {
                startScanner(<?=$cam?>);
            }
            });

            window.addEventListener("blur", function () {
            stopScanner();
            });

            window.addEventListener("focus", function () {
            startScanner(<?=$cam?>);
            });

            window.addEventListener("beforeunload", function () {
            stopScanner();
            });



            //scan then qr code part
            scanner.addListener('scan', function (c) {
            document.getElementById("tab-show").style.display = "";
            document.getElementById("text").value = c;
            document.getElementById("prod_name").innerHTML = products[c]["1"];
            document.getElementById("prod_name").value = products[c]["1"];
            document.getElementById("prod_ean").innerHTML = products[c]["ean"];
            document.getElementById("prod_ean").value = products[c]["ean"];
            document.getElementById("prod_sku").innerHTML = products[c]["sku"];;
            document.getElementById("prod_sku").value = products[c]["sku"];
            document.getElementById("prod_p_id").innerHTML = products[c]["p_id"];
            document.getElementById("prod_p_id").value = products[c]["p_id"];

            let sendButton = document.getElementById("sendButton");
            sendButton.click();
            });
        </script>
        <?php $select2_above = true; ?>
        <?php require_once 'landings/footer.view.php' ?>