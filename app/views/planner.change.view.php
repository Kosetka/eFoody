<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<style>
    .arrow-icon {
        font-size: 3rem;
    }
</style>

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
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                    if($data["show_list"] == 1 || $data["show_list"] == 2 || $data["show_list"] == 3) {
                        $date_show = $date;
                    } else {
                        $date_show = "";
                    }
                ?>
                    <h2 class="">Podmiana produktu w planowaniu: <?= $date_show?></h2>
                    <?php
                        if($data["show_list"] == 0 || $data["show_list"] == 1) {    
                    ?>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Wybierz dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
                </div>
                <?php
                    if($data["show_list"] == 1|| $data["show_list"] == 3) {    
                ?>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Zdjęcie</th>
                                            <th>Nazwa produktu</th>
                                            <th>SKU</th>
                                            <th>Planowana ilość</th>
                                            <th>Przygotowana ilość</th>
                                            <th>Akcja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                $created = 0;
                                                if(isset($data["producted"][$product["p_id"]]["amount"])) {
                                                    $created = $data["producted"][$product["p_id"]]["amount"];
                                                }
                                                $vege = "";
                                                if($data["fullproducts"][$product["p_id"]]["vege"] == 1) {
                                                    $vege = "<span style='color: green; font-weight: bold;'>VEGE </span>";
                                                }
                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$vege.' '.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td>'.$product["amount"].'</td>
                                                <td>'.$created.'</td>
                                                <td><a class="btn btn-info" data-pid="'.$product["p_id"].'" href=" ' . ROOT . '/planner/change/'.$date.'/'.$data["fullproducts"][$product["p_id"]]["id"].'"
                                                role="button" title="Edytuj">Edytuj</a></td>';

                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                    if($data["show_list"] == 2) {
                        //show($data);
                        $total_split = 0;
                        $total_planned = 0;
                        $total_producted = 0;
                        if(isset($data["producted"][$data["product_id"]]["amount"])) {
                            $total_producted = $data["producted"][$data["product_id"]]["amount"];
                        }
                        if(isset($data["split"])) {
                            foreach($data["split"] as $user) {
                                foreach($user as $prod) {
                                    if($prod["p_id"] == $data["product_id"]) {
                                        $total_split += $prod["amount"];
                                    }
                                }
                            }
                        }
                        if(isset($data["planned"])) {
                            foreach($data["planned"] as $plan) {
                                if($plan["p_id"] == $data["product_id"]) {
                                    $total_planned += $plan["amount"];
                                }
                            }
                        }
                        
                    ?>
                    <div class="container mt-5">
                        <form method="POST" action="">
                            <div class="row">
                                <!-- Informacje o produkcie -->
                                <div class="col-md-5">
                                    <h5><?php echo $data["fullproducts"][$data["product_id"]]["p_name"];?></h5>
                                    <?='<img width="150" height="150" class="obrazek" id="imageBox" src="'.IMG_ROOT.''.$data["fullproducts"][$data["product_id"]]["p_photo"].'">';?>
                                    <p>SKU: <?php echo $data["fullproducts"][$data["product_id"]]["sku"];?></p>
                                    <p>Planowana ilość: <?=$total_planned?></p>
                                    <p>Przygotowana ilość: <?=$total_producted?></p>
                                    <p>Podzielona ilość: <?=$total_split?></p>
                                </div>

                                <!-- Strzałka w prawo -->
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <span class="arrow-icon">&#10140;</span>
                                </div>
                        <?php
                            $list_planned = [];
                            foreach($data["planned"] as $pl) {
                                $list_planned[$pl["p_id"]] = $pl["p_id"];
                            }       
                        ?>
                                <!-- Lista wybieralna -->
                                <div class="col-md-5">
                                    <h5>Docelowy produkt</h5>
                                    <select class="form-control" id="wyborOpcji" name="wyborOpcji" onchange="pokazInformacje()">
                                        <option value="" disabled selected>Wybierz...</option>
                                        <?php
                                            foreach($data["fullproducts"] as $product) {
                                                if(!in_array($product["id"], $list_planned)) {
                                                    echo '<option value="'.$product["id"].'" data-nazwa="'.$product["p_name"].'" 
                                                    data-zdjecie="'.IMG_ROOT.''.$product["p_photo"].'" 
                                                    data-sku="'.$product["sku"].'">'.$product["p_name"].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <div id="informacje" class="mt-3" style="display: none;">
                                        <h6 id="nazwaProduktu"></h6>
                                        <img id="zdjecieProduktu" src="" id="imageBox" width="150" height="150" class="img-fluid obrazek" alt="Zdjęcie produktu">
                                        <p id="skuProduktu"></p>
                                        <button type="submit" class="btn btn-primary" style="margin: 30px;">Zapisz zmiany</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
<?php }?>
            
        </main>

        <script>
            function pokazInformacje() {
                const select = document.getElementById("wyborOpcji");
                const wybranaOpcja = select.options[select.selectedIndex];

                if (wybranaOpcja.value) {
                    document.getElementById("nazwaProduktu").innerText = wybranaOpcja.getAttribute("data-nazwa");
                    document.getElementById("zdjecieProduktu").src = wybranaOpcja.getAttribute("data-zdjecie");
                    document.getElementById("skuProduktu").innerText = "SKU: " + wybranaOpcja.getAttribute("data-sku");
                    document.getElementById("informacje").style.display = "block";
                } else {
                    document.getElementById("informacje").style.display = "none";
                }
            }
        </script>

        <?php require_once 'landings/footer.view.php' ?>