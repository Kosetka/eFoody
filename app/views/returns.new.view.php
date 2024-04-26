<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <form method="post">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?= implode("<br>", $errors) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <h1 class="h3 mb-3 fw-normal">Rozlicz niesprzedany towaru</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="w_id" class="col-sm-2 col-form-label">Magazyn zwrotu:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="w_id" name="w_id">
                                <?php
                                $user_city = $_SESSION["USER"]->u_warehouse;
                                foreach ($data["cities"] as $city) {
                                    $full_tag = $city["c_name"] . "_" . $city["wh_name"];
                                    $full_name = $city["c_fullname"] . " -> " . $city["wh_fullname"];
                                    $id = $city["id"];
                                    if ($user_city == $id) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='$id' $selected>$full_tag : $full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="modal" class="modal">
                        <span class="close">&times;</span>
                        <div class="modal-content">
                            <img id="modal-image" src="" alt="Modal Image">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Zdjęcie</th>
                                        <th scope="col">Produkt</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Ilość</th>
                                        <th scope="col">Jednostka</th>
                                        <th scope="col">Pobrane</th>
                                        <th scope="col">Sprzedane</th>
                                        <th scope="col">Zwrócone</th>
                                        <th scope="col">Otrzymane</th>
                                        <th scope="col">Przekazane</th>
                                        <th scope="col">W ofercie</th>
                                        <th scope="col">Gratisy</th>
                                        <th scope="col">Zniszczone</th>
                                        <th scope="col">Aktualny stan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($data["products"] as $key => $value) {
                                        $pr = $data['prod_availability'][$value->id];
                                        $prs = $data['prod_availability_sold'][$value->id];
                                        $prz = $data['prod_availability_returned'][$value->id];
                                        $pef = $data['prod_availability_exchange_from'][$value->id];
                                        $pet = $data['prod_availability_exchange_to'][$value->id];
                                        $pep = $data['prod_availability_exchange_pending'][$value->id];
                                        $pag = $data['prod_availability_gratis'][$value->id];
                                        $pad = $data['prod_availability_destroy'][$value->id];
                                        $amount_left = $pr - $prs - $prz + $pef - $pet - $pep - $pag - $pad;
                                        if (!empty($value->p_photo)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        if ($amount_left > 0) {
                                            echo "  <tr><td>$photo</td>
                                                <td>$value->p_name</td>
                                                <td>$value->sku</td>
                                                <td>";
                                            echo '<input type="number" class="form-check-input p-2" style="width: 80px; height: 30px" id="p_id" name="p_id[' . $value->id . ']" value="' . $amount_left . '" min=0 max = "' . $amount_left . '">';
                                            echo "</td>
                                                <td>$value->p_unit</td>
                                                <td>$pr</td>
                                                <td>$prs</td>
                                                <td>$prz</td>
                                                <td>$pef</td>
                                                <td>$pet</td>
                                                <td>$pep</td>
                                                <td>$pag</td>
                                                <td>$pad</td>";
                                            echo "<td>" . $amount_left . "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit">Zatwierdź rozliczenie</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>