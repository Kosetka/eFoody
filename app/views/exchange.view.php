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

            <h1 class="h3 mb-3 fw-normal">Moje oferty</h1>
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="text-start">
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">Ilość</th>
                                    <th scope="col">Jednostka</th>
                                    <th scope="col">Dla kogo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Akcja</th>
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
                                if (!empty($data["exchange_my"])) {
                                    foreach ($data["exchange_my"] as $key => $value) {
                                        if (!empty($value->p_id)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $products_list2[$value->p_id]->p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        $style = "";
                                        if ($value->result == 0) {
                                            $style = "bg-warning";
                                        } else if ($value->result == 1) {
                                            $style = "bg-success";
                                        } else if ($value->result == 2) {
                                            $style = "bg-danger";
                                        } else if ($value->result == 3) {
                                            $style = "bg-info";
                                        } else if ($value->result == 4) {
                                            $style = "bg-danger";
                                        }
                                        echo "  <tr><td>$photo</td>
                                            <td>" . $products_list2[$value->p_id]->p_name . "</td>
                                            <td>$value->amount</td>
                                            <td>" . $products_list2[$value->p_id]->p_unit . "</td>
                                            <td>" . $data["users"][$value->u_id_target]->first_name . " " . $data["users"][$value->u_id_target]->last_name . "</td>
                                            <td class='$style'>" . EXCHANGESTATUS[$value->result] . "</td>
                                            <td>" . $value->date_init . "</td>
                                            <td>";
                                        //echo '<a href="'.ROOT .'/exchange/cancel/'.$value->id.'" class="btn btn-danger" name="p_id[' . $value->id . ']">Anuluj</a>';
                                        if ($value->result == 0) {
                                            echo "<a class='btn btn-danger' onClick = 'clicked(4, $value->id)' data-el=$value->id 
                                                role='button'>Anuluj</a>";
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="<?php echo ROOT . '/exchange/new' ?>" class="w-40 btn btn-lg btn-primary"
                style="margin-bottom: 40px;" type="submit">Dodaj nową ofertę przekazania</a>
            <h1 class="h3 mb-3 fw-normal">Oferty dla mnie</h1>
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="text-start">
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">Ilość</th>
                                    <th scope="col">Jednostka</th>
                                    <th scope="col">Od kogo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Akcja</th>
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
                                if (!empty($data["exchange_to_me"])) {
                                    foreach ($data["exchange_to_me"] as $key => $value) {
                                        if (!empty($value->p_id)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $products_list2[$value->p_id]->p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        $style = "";
                                        if ($value->result == 0) {
                                            $style = "bg-warning";
                                        } else if ($value->result == 1) {
                                            $style = "bg-success";
                                        } else if ($value->result == 2) {
                                            $style = "bg-danger";
                                        } else if ($value->result == 3) {
                                            $style = "bg-info";
                                        } else if ($value->result == 4) {
                                            $style = "bg-danger";
                                        }
                                        echo "  <tr><td>$photo</td>
                                                <td>" . $products_list2[$value->p_id]->p_name . "</td>
                                                <td>$value->amount</td>
                                                <td>" . $products_list2[$value->p_id]->p_unit . "</td>
                                                <td>" . $data["users"][$value->u_id_init]->first_name . " " . $data["users"][$value->u_id_init]->last_name . "</td>
                                                <td class='$style'>" . EXCHANGESTATUS[$value->result] . "</td>
                                                <td>" . $value->date_init . "</td>
                                                <td>";
                                        if ($value->result == 0) {
                                            // echo '<a href="'.ROOT .'/exchange/accept/'.$value->id.'" class="btn btn-success" name="p_id[' . $value->id . ']">Akceptuj</a> ';
                                            // echo '<a href="'.ROOT .'/exchange/reject/'.$value->id.'" class="btn btn-danger" name="p_id[' . $value->id . ']">Odrzuć</a>';
                                            echo "<a class='btn btn-success' onClick = 'clicked(1, $value->id)' data-el=$value->id 
                                                role='button'>Akceptuj</a> ";
                                            echo "<a class='btn btn-danger' onClick = 'clicked(2, $value->id)' data-el=$value->id 
                                                role='button'>Odrzuć</a>";
                                        }

                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><th colspan='8'>Brak ofert</th></tr>";
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                function clicked(id, ex) {
                    let lin = "test";
                    if (id == 1) lin = "accept";
                    if (id == 2) lin = "reject";
                    if (id == 4) lin = "cancel";
                    $.ajax({
                        url: '<?php echo ROOT . "/exchange/" ?>' + lin + '/' + ex,
                        success: function (data) {
                            alert("Akcja pomyślna");
                            window.location.href = window.location.href
                        }
                    });
                }
            </script>
        </main>
        <?php require_once 'landings/footer.view.php' ?>