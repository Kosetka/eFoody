<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
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


            <div class="card-header">
                <h1 class="h3 mb-3 fw-normal">Lista receptur</h1>
                <a type="button" class="btn btn-primary" href="<?php echo ROOT ?>/recipes/new">Dodaj
                    recepturę</a>
            </div>

            <div class="text-start">
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
                                    <th scope="col">Nazwa receptury</th>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Pracownik</th>
                                    <th scope="col">Data dodania</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" colspan="2">Akcja</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data["recipes"] as $key => $value) {
                                    $product = $data["products"][$value->p_id];
                                    $uu_id = $data["recipes"][$key]->u_id;
                                    $user = $data["users"][$uu_id];
                                    if (!empty($product->p_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $product->p_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    echo "  <tr><td>$value->r_name [ID: $value->id]</td>
                                            <td>$photo</td>
                                            <td>$product->p_name</td>
                                            <td>$product->sku</td>
                                            <td>$user->first_name $user->last_name</td>
                                            <td>$value->date</td>
                                            <td>" . STATUSNAME[$value->active] . "</td>
                                            <td><a href='" . ROOT . "/recipes/edit/$value->id'>Edytuj</a></td>";
                                    echo '<td><button type="button" class = "btn btn-info" data-bs-toggle="collapse"
                                    data-bs-target="#collapse' . $value->id . '" aria-expanded="true" aria-controls="collapse' . $value->id . '">
                                    Szczegóły
                                </button></td>';
                                    echo "</tr>";
                                    echo '
                                <tr id="collapse' . $value->id . '" class="collapse" data-bs-parent="#accordionExample">
                                    <th class="accordion-body"></th>
                                    <th class="accordion-body">Zdjęcie</th>
                                    <th class="accordion-body">Półprodukt</th>
                                    <th class="accordion-body">SKU</th>
                                    <th class="accordion-body">Ilość</th>
                                    <th class="accordion-body">Jednostka</th>
                                    <th class="accordion-body"></th>
                                    <th class="accordion-body"></th>
                                    <th class="accordion-body"></th>
                                </tr>';
                                    foreach ($data["productsDetails"] as $k => $recipe) {
                                        if ($recipe->r_id == $value->id) {
                                            $p = $data["products"][$recipe->sub_prod];
                                            if (!empty($p->p_photo)) {
                                                $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $p->p_photo . "'>";
                                            } else {
                                                $photo = "";
                                            }

                                            echo '
                                    <tr id="collapse' . $value->id . '" class="collapse" data-bs-parent="#accordionExample">
                                        <td class="accordion-body"></td>
                                        <td class="accordion-body">' . $photo . '</td>
                                        <td class="accordion-body">' . $p->p_name . '</td>
                                        <td class="accordion-body">' . $p->sku . '</td>
                                        <td class="accordion-body">' . $recipe->amount . '</td>
                                        <td class="accordion-body">' . $p->p_unit . '</td>
                                        <td class="accordion-body"></td>
                                        <td class="accordion-body"></td>
                                        <td class="accordion-body"></td>
                                    </tr>';

                                        }
                                    }



                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>