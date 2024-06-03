<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<?php
    //show($data["planned"]);
?>
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
            <?php
                //show($data["warehouse"]);

                $wh = "[".$data["warehouse"][0]->c_name."_".$data["warehouse"][0]->wh_name."] -> ".$data["warehouse"][0]->c_fullname." ".$data["warehouse"][0]->wh_fullname;

                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                ?>
            <div class="alert alert-info">
                <h3>Legenda:</h3>
                <p>Niebieski przycisk <a class="btn btn-primary" href="#" role="button" title="Etykieta"><i class="fa-solid fa-tag"></i></a> pobiera plik LBX, który pozwala na edytowanie etykiety w specjalnym programie Brother na komputerze.</p>
                <p>Zielony przycisk drukarki <a target="" class="btn btn-success print-pdf" href="#" role="button" title="Drukuj pdf"><i class="fa-solid fa-print"></i></a> otwiera w nowym oknie plik PDF z etykietą produktu. Data produkcji jest tam automatycznie ustawiana na naspeny dzień (w przypadku piątku i soboty - jest ustawiona data najbliższego poniedziałku).</p>
                <p>Żółty przycisk kalendarza <a target="" class="btn btn-warning print-pdf" href="" role="button" title="Drukuj pdf"><i class="fas fa-calendar-alt"></i></a> podobnie jak przycisk drukarki otwiera plik PDF z etykietą, jednak data jest pobierana z tego pola:</p>
                <p><b>Data produkcji: </b> <input type='date' style='padding: 5px; margin: 2px;border-radius: 8px;' id='date_prod' name='date_prod' value='<?php echo $date; ?>'></p>
                <p>Po kliknięciu przycisku <a target="" class="btn btn-success print-pdf" href="#" role="button" title="Drukuj pdf"><i class="fa-solid fa-print"></i></a> lub <a target="" class="btn btn-warning print-pdf" href="" role="button" title="Drukuj pdf"><i class="fas fa-calendar-alt"></i></a> komórka podświetla się na jasnozielony, co oznacza że dany produkt ma już wydrukowane etykiety. Podświetlenie działa tylko do odświeżenia strony.</p>
                
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Plan produkcji: <?php echo $date;?> - Magazyn: <?=$wh?></h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Wybierz dzień:</label>
                                <input type='date' class='form-control col-sm-1' name='date'
                                    value='<?php echo $date; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                                            <th>% Realizacji</th>
                                            <th>Alergeny</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tot_plan = 0;
                                        $tot_pro = 0;
                                            //show($data["producted"]);
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                $ids = "";
                                                if(!empty($data["prod_alergens"][$product["p_id"]]->lista_a_id)) {
                                                    $numbers = explode(",", $data["prod_alergens"][$product["p_id"]]->lista_a_id);
                                                    foreach ($numbers as $number) {
                                                        $ids .=$number.", ";
                                                    }
                                                }
                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td>'.$product["amount"].'</td>';
                                                $prod_amo = 0;
                                                if(isset($data["producted"][$product["p_id"]]["amount"]) ) {
                                                    $prod_amo = $data["producted"][$product["p_id"]]["amount"];
                                                    echo '<td>'.$prod_amo.'</td>';
                                                } else {
                                                    echo '<td>0</td>';
                                                }
                                                $color = '';
                                                if($product["amount"] < $prod_amo) {
                                                    $color = "yellow";
                                                } else if ($product["amount"] == $prod_amo) {
                                                    $color = "green";
                                                } else if($product["amount"] > $prod_amo) {
                                                    $color = "red";
                                                }

                                                echo '<td style="background: '.$color.'">'.getPercent($prod_amo, $product["amount"]).'%</td>
                                                <td>'.substr($ids, 0, -2).'</td>
                                                <td id="p_name_'.$product["p_id"].'"><a class="btn btn-primary" href=" ' . ROOT . '/assets/labels/'.$data["fullproducts"][$product["p_id"]]["sku"].'.lbx"
                                                role="button" title="Etykieta"><i class="fa-solid fa-tag"></i></a>
                                                 
                                                <a target="_blank" class="btn btn-success print-pdf" data-pid="'.$product["p_id"].'" href=" ' . ROOT . '/labels/generate/'.$data["fullproducts"][$product["p_id"]]["id"].'"
                                                role="button" title="Drukuj pdf"><i class="fa-solid fa-print"></i></a>
                                                
                                                <a target="_blank" class="btn btn-warning print-pdf prod_time" data-pid="'.$product["p_id"].'" href=" ' . ROOT . '/labels/generate/'.$data["fullproducts"][$product["p_id"]]["id"].'"
                                                role="button" title="Drukuj pdf"><i class="fas fa-calendar-alt"></i></a></td>
                                                ';
                                                echo "</tr>";
                                                $tot_plan += $product["amount"];
                                                $tot_pro += $prod_amo;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><?=$tot_plan;?></th>
                                            <th><?=$tot_pro;?></th>
                                            <th><?=getPercent($tot_pro, $tot_plan)?>%</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const printButtons = document.querySelectorAll('.print-pdf');
                printButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const pId = this.getAttribute('data-pid');
                        const productNameCell = document.getElementById('p_name_' + pId);
                        if (productNameCell) {
                            productNameCell.style.backgroundColor = 'lightgreen'; // Zmień na dowolny kolor
                        }
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateInput = document.getElementById('date_prod');
                const buttons = document.querySelectorAll('.prod_time');

                dateInput.addEventListener('change', function() {
                    const date = new Date(this.value);
                    const formattedDate = ('0' + date.getDate()).slice(-2) + '.' + ('0' + (date.getMonth() + 1)).slice(-2) + '.' + date.getFullYear();

                    buttons.forEach(button => {
                        const currentHref = button.getAttribute('href');
                        const newHref = currentHref.split('?')[0] + '?date=' + formattedDate;
                        button.setAttribute('href', newHref);
                    });
                });
            });
        </script>
        <?php require_once 'landings/footer.view.php' ?>