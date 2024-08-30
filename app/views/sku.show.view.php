<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista produktów/SKU</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $sku_arr = [];
                        if(!empty($data["products"])) {
                            foreach($data["products"] as $k => $v) {
                                $sku_arr[$v->id] = $v->sku;
                            }
                        }
                            $ostatniElement = end($sku_arr);
                            $sekcje = explode('-', $ostatniElement);
                            if(isset($sekcje[2])) {
                                $sekcje[2] = $sekcje[2] + 1;
                                if($sekcje[2] < 10) {
                                    $sekcje[2] = "0" . $sekcje[2];
                                }
                                $nowyElement = implode('-', $sekcje);
                            } else {
                                $nowyElement = "";
                            }
                        ?>
                        <a type="button" class="btn btn-primary" href="<?= ROOT ?>/products/new/<?=$nowyElement;?>">Dodaj nowy produkt</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" style="width: 120px">SKU</th>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Pełna nazwa</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Alergeny</th>
                                    <th scope="col">Jednostka</th>
                                    <th scope="col">Kalorie</th>
                                    <th scope="col">Typ produktu</th>
                                    <th scope="col" colspan="2">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data) {
                                    echo "<tr><th colspan='8'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    if(!empty($data["products"])) {
                                        foreach ($data["products"] as $product) {
                                            if (!empty($product->p_photo)) {
                                                $photo = "<img width='40' height='40' class='obrazek' id='imageBox$product->id' src='" . IMG_ROOT . "" . $product->p_photo . "'>";
                                            } else {
                                                $photo = "";
                                            }
                                            $ids = "";
                                            if(!empty($data["prod_alergens"][$product->id]->lista_a_id)) {
                                                $numbers = explode(",", $data["prod_alergens"][$product->id]->lista_a_id);
                                                foreach ($numbers as $number) {
                                                    $ids .=$number.", ";
                                                }
                                            }

                                            echo "  <tr>
                                                        <th scope='row'>$product->id</th>
                                                        <td>$product->sku</td>
                                                        <td>$photo</td>
                                                        <td>$product->p_name</td>
                                                        <td>$product->p_description</td>
                                                        <td>".substr($ids, 0, -2)."</td>
                                                        <td>$product->p_unit</td>
                                                        <td>$product->kcal</td>
                                                        <td>" . PRODUCTTYPENAMES[$product->prod_type] . "</td>
                                                        <td><a class='btn btn-info' href=' " . ROOT . "/products/edit/$product->id'
                                                                role='button'>Edytuj</a></td>";
                                            if($product->prod_type == 1) {
                                                echo '<td><a class="btn btn-primary" href=" ' . ROOT . '/assets/labels/'.$product->sku.'.lbx"
                                                role="button" title="Etykieta"><i class="fa-solid fa-tag"></i></a>
                                                 
                                                <a target="_blank"class="btn btn-success" href=" ' . ROOT . '/labels/generate/'.$product->id.'"
                                                role="button" title="Drukuj pdf"><i class="fa-solid fa-print"></i></a></td>';
                                            }

                                            echo "</tr>";
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