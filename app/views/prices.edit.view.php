<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post">
                <div class="alert alert-danger">
                    <b>UWAGA!</b></br>Przy dodawaniu cen, pamiętaj żeby w danym przedziale czasowym był aktywny tylko
                    jeden wpis.</br>Czasy obowiązywania cen powinny mieć ciągłość, tzn.: nowa cena zaczyna obowiązywać
                    sekundę po końcu obowiązywania starej ceny.
                </div>
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

                <?php
                $edit_stage = false;
                $th1 = "Dodaj nową cenę";
                $th2 = "";
                $th3 = "";
                $th4 = "";
                $th5 = "";
                $th6 = "";
                $th7 = "Dodaj cenę";
                $th8 = "";
                $th9 = "";
                //show($data["price"]);
                if (isset($data["price"])) {
                    $edit_stage = true;
                    $th1 = "Edytuj cenę";
                    $th2 = $data["price"]->date_from;
                    $th3 = $data["price"]->date_to;
                    $th4 = $data["price"]->production_cost;
                    $th5 = $data["price"]->price;
                    $th8 = $data["price"]->priceshops;
                    $th9 = $data["price"]->pricefixed;
                    if ($data["price"]->active == 1) {
                        $th6 = "checked";
                    }
                    $th7 = "Zapisz zmiany";
                }

                ?>

                <h1 class="h3 mb-3 fw-normal"><?php echo $th1; ?></h1>
                <?php
                    if(isset($data["price"]->p_id)) {
                        echo "<h5><a href='".ROOT."/prices/edit/".$data["price"]->p_id."'>Wróć do dodawania ceny</a></h5>";
                    } else {
                        echo "<h5><a href='".ROOT."/prices'>Wróć do listy produktów</a></h5>";
                    }

                ?>
                

                <div class="text-start">
                    <div class="form-group row m-3" <?php if($edit_stage) echo "hidden";?>>
                        <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="<?php echo $th2; ?>" <?php if(!$edit_stage) echo "required";?>>
                        </div>
                    </div>
                    <div class="form-group row m-3" hidden>
                        <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="<?php echo $th3; ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="production_cost" class="col-sm-2 col-form-label">Koszt produkcji:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="production_cost" name="production_cost"
                                value="<?php echo $th4; ?>" required min="0.01" step="0.01">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="price" class="col-sm-2 col-form-label">Cena sprzedaży:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo $th5; ?>" required min="0.01" step="0.01">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="priceshops" class="col-sm-2 col-form-label">Cena sprzedaży w sklepach (zmienna):</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="priceshops" name="priceshops" value="<?php echo $th8; ?>" min="0.01" step="0.01">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="pricefixed" class="col-sm-2 col-form-label">Cena sprzedaży w sklepach (stała):</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="pricefixed" name="pricefixed" value="<?php echo $th9; ?>" min="0.01" step="0.01">
                        </div>
                    </div>
                    <div class="form-group row m-3" hidden>
                        <label for="active" class="col-sm-3 col-form-label">Aktywne:</label>
                        <div class="col-sm-9">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" checked>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="newAdd"><?php echo $th7; ?>
                </button>
            </form>
        </main>
        <div class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <h1 class="h3 mb-3 fw-normal">Ceny historyczne:</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Koszt produkcji</th>
                        <th scope="col">Cena sprzedaży</th>
                        <th scope="col">Marża</th>
                        <th scope="col">Cena w sklepach (zmienna)</th>
                        <th scope="col">Cena w sklepach (stała)</th>
                        <th scope="col">Data od</th>
                        <th scope="col">Data do</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($data["prices"])) {
                        foreach ($data["prices"] as $price) {
                            echo "<tr>";
                            echo "<td>" . $price->production_cost . " zł</td>";
                            echo "<td>" . $price->price . " zł</td>";
                            echo "<td>" . $price->price - $price->production_cost . " zł (" . getMargin($price->price, $price->production_cost) . "%)</td>";
                            if(isset($price->priceshops)) {
                                echo "<td>" . $price->priceshops . " zł</td>";
                            } else {
                                echo "<td></td>";
                            }
                            if(isset($price->pricefixed)) {
                                echo "<td>" . $price->pricefixed . " zł</td>";
                            } else {
                                echo "<td></td>";
                            }
                            echo "<td>" . $price->date_from . "</td>";
                            echo "<td>" . $price->date_to . "</td>";
                            echo "<td><a href='" . ROOT . "/prices/edit/" . $price->p_id . "/" . $price->id . "'>Edytuj</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php require_once 'landings/footer.view.php' ?>