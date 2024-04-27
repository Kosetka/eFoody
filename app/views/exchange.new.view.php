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

                <h1 class="h3 mb-3 fw-normal">Tworzenie nowej oferty przekazania</h1>

                <div class="text-start">
                    <?php /*<div class="form-group row m-3">
<label for="u_id" class="col-sm-2 col-form-label">Sprzedawca:</label>
<div class="col-sm-10">
<?php echo $_SESSION["USER"]->first_name . " " . $_SESSION["USER"]->last_name ?>
</div>
</div>*/ ?>

                    <div class="form-group row m-3">
                        <label for="u_id_target" class="col-sm-2 col-form-label">Przekaż dla:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="u_id_target" name="u_id_target">
                                <?php
                                $me = $_SESSION["USER"]->id;
                                foreach ($data["users"] as $user) {
                                    if ($me != $user->id) {
                                        $full_name = $user->first_name . " " . $user->last_name;
                                        $id = $user->id;
                                        echo "<option value='$id'>$full_name</option>";
                                    }
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
                                        <th scope="col">EAN</th>
                                        <th scope="col">Ilość</th>
                                        <th scope="col">Jednostka</th>
                                        <th scope="col">Stan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $products_list = [];
                                    $products_list2 = []; //pozmieniane ID
                                    foreach ($data["products"] as $key => $value) {
                                        $products_list[$value->id] = 0;
                                        $products_list2[$value->id] = $value;
                                    }
                                    if (!is_bool($data["cargo"])) {
                                        foreach ($data["cargo"] as $key => $value) {
                                            $products_list[$value->p_id] += $value->amount;
                                        }
                                    }
                                    if (!is_bool($data["sold"])) {
                                        foreach ($data["sold"] as $key => $value) {
                                            $products_list[$value->p_id] -= $value->s_amount;
                                        }
                                    }
                                    if (!is_bool($data["return"])) {
                                        foreach ($data["return"] as $key => $value) {
                                            $products_list[$value->p_id] -= $value->amount;
                                        }
                                    }
                                    //inne oferty wymiay tutaj
                                    if (!is_bool($data["exchange_my"])) {
                                        foreach ($data["exchange_my"] as $key => $value) {
                                            $products_list[$value->p_id] -= $value->amount;
                                        }
                                    }

                                    if (!is_bool($data["exchange_to_me"])) {
                                        foreach ($data["exchange_to_me"] as $key => $value) {
                                            $products_list[$value->p_id] += $value->amount;
                                        }
                                    }
                                    // pobrana ilość z magazynu
                                    //trzeba odcjąc to już zaraportowane
                                    
                                    //show($products_list);
                                    //show($products_list2);
                                    
                                    //show($data);
                                    foreach ($products_list2 as $key => $value) {
                                        $max = $products_list["$value->id"];
                                        if ($max > 0) { //wyświetla tylko te produkty, które mam ze sobą
                                            if (!empty($value->p_photo)) {
                                                $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                            } else {
                                                $photo = "";
                                            }
                                            echo "  <tr><td>$photo</td>
                                                <td>$value->p_name</td>
                                                <td>$value->sku</td>
                                                <td>$value->ean</td>
                                                <td>";
                                            echo '<input type="number" class="form-check-input p-2" style="width: 80px; height: 30px" id="p_id" name="p_id[' . $value->id . ']" value="0" min=0 max=' . $max . '>';
                                            echo "</td>
                                                <td>$value->p_unit</td>
                                                <td>" . $max . "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit">Wyslij ofertę</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>