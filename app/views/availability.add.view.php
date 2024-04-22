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

                <h1 class="h3 mb-3 fw-normal">Dodaj stan magazynowy produktu</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="w_id" class="col-sm-2 col-form-label">Magazyn:</label>
                        <label for="w_id" class="col-sm-10 col-form-label">
                            <?php
                            $wid = $data["user_warehouse"];
                            $full_name_warehouse = "[" . $data["cities"][$wid]["c_name"] . "_" . $data["cities"][$wid]["wh_name"] . "] " . $data["cities"][$wid]["c_fullname"] . " " . $data["cities"][$wid]["wh_fullname"];
                            echo $full_name_warehouse;
                            ?>
                        </label>
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
                                        <th scope="col">Typ produktu</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">EAN</th>
                                        <th scope="col">Ilość</th>
                                        <th scope="col">Jednostka</th>
                                        <th scope="col">Stan na magazynie</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($data["product_quantity"] as $key => $value) {
                                        $product = $data["products"][$key];
                                        $product_p_photo = $product["p_photo"];
                                        if (!empty($product_p_photo)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $product_p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        $product_p_name = $product["p_name"];
                                        $product_type = $product["prod_type"];
                                        $product_sku = $product["sku"];
                                        $product_ean = $product["ean"];
                                        $product_p_unit = $product["p_unit"];

                                        $prod_set = $value["set"];
                                        $prod_scan = $value["scan"];
                                        $prod_add = $value["add"];
                                        $prod_sub = $value["sub"];
                                        $prod_cargo = $value["cargo"];
                                        $prod_return = $value["return"];
                                        $amount_left = $prod_set + $prod_scan + $prod_add - $prod_sub - $prod_cargo;
                                        echo "  <tr><td>$photo</td>
                                            <td>$product_p_name</td>
                                            <td>" . PRODUCTTYPENAMES[$product_type] . "</td>
                                            <td>$product_sku</td>
                                            <td>$product_ean</td>
                                            <td>";
                                        echo '<input type="number" class="form-check-input p-2" style="width: 80px; height: 30px" id="p_id" name="p_id[' . $key . ']" value="0">';
                                        echo '<input type="number" hidden class="form-check-input p-2" style="width: 80px; height: 30px" id="p_id" name="p_id_old[' . $key . ']" value="' . $amount_left . '">';
                                        echo "</td>
                                            <td>$product_p_unit</td>";
                                        echo "<td>" . $amount_left . "</td>";
                                        echo "</tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit">Rozlicz</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>