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
                <h1 class="h3 mb-3 fw-normal">Ceny półproduktów</h1>
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
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Jednostka</th>
                                    <th scope="col">Cena zakupu</th>
                                    <th scope="col">Ostatnia aktualizacja</th>
                                    <th scope="col">Akcje</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data["products"] as $key => $value) {
                                    if (!empty($value->p_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    if (isset($data["prices"][$value->id])) {
                                        $production_cost = $data["prices"][$value->id]->production_cost;
                                        $date_from = $data["prices"][$value->id]->date_from;
                                    } else {
                                        $price = "";
                                        $production_cost = "";
                                        $date_from = "";
                                    }
                                    $no_production_cost = "";
                                    if($production_cost == "") {
                                        $no_production_cost = "style='background-color: red;' ";
                                    }
                                    echo "  <tr><td>$photo</td>
                                            <td $no_production_cost>$value->p_name</td>
                                            <td>$value->p_description</td>
                                            <td>$value->sku</td>
                                            <td>$value->p_unit</td>
                                            <td $no_production_cost>$production_cost zł</td>
                                            <td>$date_from</td>";
                                    echo '<td>
                                    <a href= "' . ROOT . '/subprices/edit/' . $value->id . '" class = "btn btn-success">
                                        Edytuj
                                    </a>
                                    </td>';
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