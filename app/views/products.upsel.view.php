<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="alert alert-info">
                <h2>UWAGA!</h2>
                <span>Na zielono zaznaczone są aktywne produkty Upsell, na szaro produkty, które mogą być upsellami ale w tej chcwili nie są.</span>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Lista produktów Upsell</h2>
                </div>
                <div class=""></div>
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="orderedProductsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Zdjęcie</th>
                                        <th>Nazwa produktu</th>
                                        <th>SKU</th>
                                        <th>Data od</th>
                                        <th>Data do</th>
                                        <th>Cena zakupu</th>
                                        <th>Cena sprzedaży</th>
                                        <th>Akcja</th>
                                    </tr>
                                </thead>
                                <tbody>
                <?php

                if(!empty($data["upsels_available"])) {
                    $date_now = date("Y-m-d H:i:s");
                    foreach ($data["upsels_available"] as $pid) {
                        $date_from = "";
                        $date_to = "";
                        $active = "upsel-inactive";
                        $btn_txt = "Dodaj";
                        $status = 0;
                        if (!empty($pid->p_photo)) {
                            $photo = "<img width='40' height='40' class='obrazek' id='imageBox$pid->id' src='" . IMG_ROOT . "" . $pid->p_photo . "'>";
                        } else {
                            $photo = "";
                        }
                        if(isset($data["upsels"][$pid->id])) {
                            $date_from = $data["upsels"][$pid->id]->date_from;
                            $date_to = $data["upsels"][$pid->id]->date_to;
                            if($date_to >= $date_now || $date_to == NULL) {
                                $active = "upsel-active";
                            } 
                            $btn_txt = "Zapisz zmiany";
                            $status = 1;
                        }
                        $cost = "";
                        $sell = "";
                        if(isset($data["prices"][$pid->id])) {
                            $cost = number_format($data["prices"][$pid->id]->production_cost,2);
                            $sell = number_format($data["prices"][$pid->id]->price,2);
                        }
                        echo "<tr class='$active'>";
                        echo "<form method='POST' action=''>";
                        echo "<td><input type='hidden' name='status' value='$status'><input type='hidden' name='id' value='".$pid->id."'>".$pid->id."</td>";
                        echo "<td>".$photo."</td>";
                        echo "<td>".$pid->p_name."</td>";
                        echo "<td>".$pid->sku."</td>";
                        echo "<td><input type='date' name='date_from' class='form-control' value='".htmlspecialchars($date_from, ENT_QUOTES, 'UTF-8')."'></td>";
                        echo "<td><input type='date' name='date_to' class='form-control' value='".htmlspecialchars($date_to, ENT_QUOTES, 'UTF-8')."'></td>";
                        echo "<td>$cost zł</td>";
                        echo "<td>$sell zł</td>";
                        echo "<td><button type='submit' class='btn btn-primary'>$btn_txt</button></td>";
                        echo "</form>";
                        echo "</tr>";

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