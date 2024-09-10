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
            </div>

            <div class="text-start">
                <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
                <div class="form-group row m-3">
<?php
//show($data["foodcost"]);
?>
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Koszt produkcji</th>
                                    <th scope="col">Kalorie</th>
                                    <th scope="col">Akcja</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data["full_products"] as $key => $value) {
                                    if (!empty($value->p_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    $active = "<td class='bg-danger'>Brak przepisu</td>";
                                    if(isset($data["productsDetails"][$value->id])) {
                                        $active = $data["productsDetails"][$value->id]->active;
                                        if($active == 0) {
                                            $active = "<td class='bg-secondary'>Nieaktywne</td>";
                                        } else {
                                            $active = "<td class='bg-success'>Aktywne</td>";
                                        }
                                    }
                                    $vege = "";
                                            if($value->vege == 1) {
                                                $vege = "<span style='color: green; font-weight: bold;'>VEGE</span>";
                                            }
                                    $sau = "";
                                    if(isset($data["kcal_sauce"][$value->id])) {
                                        $sau = "<span style='color: red; font-weight: bold;'>(".$data["productsDetails"][$data["kcal_sauce"][$value->id]]->r_name.")</span>";
                                    }
                                    echo "  <tr>
                                                <td>$photo</td>
                                                <td>".$vege." ".$value->p_name." ".$sau."</td>
                                                <td>".$value->sku."</td>";

                                    echo $active;
                                    
                                    $cost = "";
                                    if(isset($data["foodcost"][$value->id][date("Y-m-d")])) {
                                        $cost = $data["foodcost"][$value->id][date("Y-m-d")]["total"];
                                    }
                                    if(isset($data["kcal_sauce"][$value->id])) {
                                        echo "<td title='
Przepis: ".roundCost((float)$data["foodcost"][$value->id][date("Y-m-d")]["cost"])."zł;
Sos: ".roundCost((float)$data["foodcost"][$value->id][date("Y-m-d")]["sauce"])."zł'>".roundCost((float)$cost)." zł</td>";
                                    } else {
                                        echo "<td>".roundCost((float)$cost)." zł</td>";
                                    }
                                    if(isset($data["kcal_calc"][$value->id])) {
                                        if(isset($data["kcal_sauce"][$value->id])) {
                                            echo "<td><span title='
Przepis: ".$data["kcal_calc"][$value->id]." kcal;
Sos: ".$data["kcal_calc"][$data["kcal_sauce"][$value->id]]." kcal'>".roundToNearest5($data["kcal_calc"][$value->id] + $data["kcal_calc"][$data["kcal_sauce"][$value->id]])." kcal</span></td>";
                                        } else {
                                            echo "<td><span title='".$data["kcal_calc"][$value->id]." kcal (wyliczone z przepisu)'>".roundToNearest5($data["kcal_calc"][$value->id])." kcal</span></td>";
                                        }
                                    } else {
                                        echo "<td></td>";
                                    }

                                    if(isset($data["recipes"][$value->id])) {
                                        echo "      <td><a href='" . ROOT . "/recipes/edit/$value->id'>Edytuj</a></td>"; // lub new
                                    } else {
                                        echo "      <td><a href='" . ROOT . "/recipes/new/$value->id'>Dodaj</a></td>";         
                                    }
                                    echo "</tr>";
  



                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-header">
                <h1 class="h3 mb-3 fw-normal">Lista sosów</h1>
            </div>

            <div class="text-start">
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Koszt produkcji</th>
                                    <th scope="col">Kalorie</th>
                                    <th scope="col">Akcja</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data["sauces"] as $key => $value) {
                                    if (!empty($value->p_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    $active = "<td class='bg-danger'>Brak przepisu</td>";
                                    if(isset($data["productsDetails"][$value->id])) {
                                        $active = $data["productsDetails"][$value->id]->active;
                                        if($active == 0) {
                                            $active = "<td class='bg-secondary'>Nieaktywne</td>";
                                        } else {
                                            $active = "<td class='bg-success'>Aktywne</td>";
                                        }
                                    }
                                    $vege = "";
                                            if($value->vege == 1) {
                                                $vege = "<span style='color: green; font-weight: bold;'>VEGE</span>";
                                            }
                                    echo "  <tr>
                                                <td>$photo</td>
                                                <td>".$vege." ".$value->p_name."</td>
                                                <td>".$value->sku."</td>";

                                    echo $active;
                                    
                                    $cost = "";
                                    if(isset($data["foodcost"][$value->id][date("Y-m-d")])) {
                                        $cost = $data["foodcost"][$value->id][date("Y-m-d")];
                                    }
                                    echo "<td>".roundCost((float)$cost)." zł</td>";
                                    if(isset($data["kcal_calc"][$value->id])) {
                                        echo "<td><span title='".$data["kcal_calc"][$value->id]." kcal (wyliczone z przepisu)'>".roundToNearest5($data["kcal_calc"][$value->id])." kcal</span></td>";
                                    } else {
                                        echo "<td></td>";
                                    }

                                    if(isset($data["recipes"][$value->id])) {
                                        echo "      <td><a href='" . ROOT . "/recipes/edit/$value->id'>Edytuj</a></td>"; // lub new
                                    } else {
                                        echo "      <td><a href='" . ROOT . "/recipes/new/$value->id'>Dodaj</a></td>";         
                                    }
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