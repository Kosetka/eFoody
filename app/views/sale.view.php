<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <form method="get">

                <h1 class="h3 mb-3 fw-normal">Parametry historii sprzedaży</h1>
                <?php
                $date_from = "";
                $date_to = "";
                $user = "";
                if (isset($data["date_from"])) {
                    $date_from = $data["date_from"];
                }
                if (isset($data["date_to"])) {
                    $date_to = $data["date_to"];
                }
                if (isset($data["get"]["user"])) {
                    $user_id = $data["get"]["user"];
                }
                ?>


                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="<?php echo $date_from; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="<?php echo $date_to; ?>" required>
                        </div>
                    </div>
                    <script>
                        const date = new Date();
                        let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
                        let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date);
                        let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);

                        let currentDate = `${year}-${month}-${day}`;

                        <?php
                        if (!isset($data["date_from"])) {
                            echo "document.getElementById('date_from').setAttribute('value', currentDate);";
                        }
                        if (!isset($data["date_to"])) {
                            echo "document.getElementById('date_to').setAttribute('value', currentDate);";
                        }
                        ?>
                    </script>
                    <?php /*<div class="form-group row m-3">
<label class="col-sm-2 col-form-label" for="u_id">Pracownik:</label>
<div class="col-sm-8">
<select class="form-control" id="u_id" name="u_id">
<?php
echo "<option value='" . $_SESSION["USER"]->id . "'>" . $_SESSION["USER"]->first_name . " " . $_SESSION["USER"]->last_name . "</option>";
foreach ($data["users"] as $user) {
$full_name = $user["first_name"] . " " . $user["last_name"];
$id = $user["id"];
if ($id == $user_id) {
$selected = "selected";
} else {
$selected = "";
}
echo "<option value='$id' $selected>$full_name [id: $id]</option>";
}
?>
</select>
</div>
</div>*/ ?>

                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit" name="search" value=1>Pokaż dane
                    sprzedażowe</button>
            </form>
            <div class="card-body" style="margin-top:30px">
                <div class="card-header">
                    <h2 class="">Historia sprzedaży</h2>
                </div>
                <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
                <?php

                $c_id_list = []; //list firm gdzie była sprzedaż
                
                $products = [];
                $products_sold = []; //ustawienie ID produktów sprzedanych
                $products_sold_day = []; //ustawienie ID produktów sprzedanych
                
                if (!is_bool($data["products"])) {
                    foreach ($data["products"] as $key => $value) {
                        $products[$value->id] = $value;
                    }

                    // tutaj do zmiany guardian, gdyby chcieć uwzględnić zmiany opiekuna firmy
                    $companies = [];
                    if (!is_bool($data["companies"])) {
                        foreach ($data["companies"] as $key => $value) {
                            $companies[$value->id] = $value;
                            if ($value->guardian == $data["user_id"]) {
                                $c_id_list[$value->id] = $value->id;
                            }
                        }
                    }
                    if (!is_bool($data["sold"])) {
                        foreach ($data["sold"] as $key => $value) {
                            $value->date = substr($value->date, 0, 10);
                            $c_id_list[$value->c_id] = $value->c_id;
                        }
                    }

                    if (!is_bool($data["dates"])) {
                        foreach ($data["dates"] as $date) {
                            foreach ($c_id_list as $company) {
                                foreach ($products as $product) {
                                    $products_sold[$date][$company][$product->id] = 0;
                                    $total_sold_day[$date][$product->id]["amount"] = 0;
                                }
                            }
                        }
                    }
                    if (!is_bool($data["sold"])) {
                        foreach ($data["sold"] as $key => $value) {
                            $value->date = substr($value->date, 0, 10);
                            $products_sold[$value->date][$value->c_id][$value->p_id] += $value->s_amount;
                        }
                    }

                    $product_number = count($products) + 1;
                    $companies_number = count($c_id_list) + 2;
                    $dateOffset = ($companies_number - 1) * $product_number + 1;
                }
                ?>
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Firma</th>
                            <th scope="col">Adres firmy</th>
                            <th scope="col">Nazwa produktu</th>
                            <?php //<th scope="col">Dane</th>                                ?>
                            <th scope="col">Sprzedana ilość</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (!$data) {
                            echo "<tr><th colspan='6'>Brak danych do wyświetlenia</th></tr>";
                        } else {
                            $total_sold_day = [];
                            if (!is_bool($data["dates"])) {
                                foreach ($data["dates"] as $date) {
                                    echo "<tr>";
                                    echo "<th scope='row' rowspan='$dateOffset'>" . $date . "</th>";
                                    $total_sold = [];
                                    foreach ($c_id_list as $c_id) {
                                        echo "<tr>";
                                        if ($c_id == 0) {
                                            $city_full_name = "Inne";
                                            $city_address = "";
                                        } else {
                                            $city_full_name = $companies[$c_id]->full_name;
                                            $city_address = $companies[$c_id]->address;
                                        }

                                        echo "<td scope='row' rowspan='$product_number'>" . $city_full_name . "</td>";
                                        echo "<td scope='row' rowspan='$product_number'>" . $city_address . "</td>";
                                        foreach ($products as $product) {
                                            echo "<tr>";
                                            if (!empty($product->p_photo)) {
                                                $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $product->p_photo . "'>";
                                            } else {
                                                $photo = "";
                                            }
                                            echo "<td scope='row'>" . $photo . " " . $product->p_name . "</td>";
                                            //echo "<td scope='row'>EAN: " . $product->ean . "</br>SKU: " . $product->sku . "</td>";
                                            $sold_number = $products_sold[$date][$c_id][$product->id];
                                            if ($sold_number > 0)
                                                $bold = "style='color: green; font-weight: bold'";
                                            else if ($sold_number < 0)
                                                $bold = "style='color: green; font-weight: bold'";
                                            else
                                                $bold = "";
                                            if (!empty($total_sold_day)) {
                                                $total_sold_day[$date][$product->id]['amount'] += $sold_number;
                                            }
                                            echo "<td scope='row' $bold>" . $sold_number . " " . $product->p_unit . "</td>";
                                            echo "</tr>";
                                        }
                                        echo "</tr>";
                                    }
                                    echo "<tr style='background: lightgray; font-weight: bold'>";
                                    echo "<td scope='row' rowspan='$product_number' colspan='2'>TOTAL</td>";
                                    foreach ($products as $product) {
                                        echo "<tr style='background: lightgray; font-weight: bold'>";

                                        echo "<td scope='row'>" . $product->p_name . "</td>";
                                        if (!empty($total_sold_day)) {
                                            $total_sh = $total_sold_day[$date][$product->id]['amount'];
                                        } else {
                                            $total_sh = 0;
                                        }
                                        echo "<td scope='row' style='color: green; font-weight: bold'>" . $total_sh . " " . $product->p_unit . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tr>";
                                    echo "</tr>";




                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>