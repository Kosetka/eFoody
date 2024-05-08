<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
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

                <h1 class="h3 mb-3 fw-normal">Edycja receptury</h1>

                <?php
                $product_id = $data["recipes"][0]->p_id;
                $product_r_name = $data["recipes"][0]->r_name;
                $product_description = $data["recipes"][0]->description;
                $product_active = $data["recipes"][0]->active;
                if ($product_active == 1) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                ?>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="r_name" class="col-sm-2 col-form-label">Nazwa receptury:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="r_name" name="r_name"
                                value="<?php echo $product_r_name; ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_id" class="col-sm-2 col-form-label">Produkt:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="p_id" name="p_id">
                                <?php

                                foreach ($data["products"] as $product) {
                                    $full_name = $product->p_name;
                                    $id = $product->id;
                                    if ($product_id == $id) {
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
                    <div class="form-group row m-3">
                        <label for="description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="description" name="description"
                                value="<?php echo $product_description; ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="active" class="col-sm-3 col-form-label">Receptura aktywna:</label>
                        <div class="col-sm-9">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php echo $checked; ?>>
                        </div>
                    </div>


                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit" name="recipeEdit" value="1">Zapisz</button>
            </form>




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

                <h1 class="h3 mb-3 fw-normal" style="padding-top: 30px;">Szczegółowa receptura</h1>

                <?php
                $product_id = $data["recipes"][0]->p_id;
                $product_r_name = $data["recipes"][0]->r_name;
                $product_description = $data["recipes"][0]->description;
                $product_active = $data["recipes"][0]->active;
                if ($product_active == 1) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                ?>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Zdjęcie</th>
                                        <th scope="col">Półprodukt</th>
                                        <th scope="col">Ilość</th>
                                        <th scope="col">Aktywny</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($data["sub_products"] as $key => $value) {
                                        if (!empty($value->p_photo)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }

                                        if (isset($data["productsDetails"][$value->id]->id)) {
                                            $checked = "checked";
                                            $val = $data["productsDetails"][$value->id]->amount;
                                        } else {
                                            $checked = "";
                                            $val = 0;
                                        }

                                        echo "  <tr><td>$photo</td>
                                            <td>$value->p_name</td>
                                            <td>";
                                        echo '<input type="number" class="form-check-input p-2" style="width: 80px; height: 30px" id="amount" name="amount[' . $value->id . ']" value="' . $val . '" step="any" min=0>';
                                        echo "<p style='margin-left: 70px; margin-top:5px;'>$value->p_unit</p>";
                                        echo "</td>";
                                        echo "<td>";
                                        echo "<input type='checkbox' class='form-check-input' id='sub_prod' name='sub_prod[" . $value->id . "]' value='1' $checked>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit" name="detailsEdit" value="1">Zapisz</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>