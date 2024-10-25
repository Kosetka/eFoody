<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Dodawanie premii lub kary</h2>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="text-start">
                        <div class="form-group row m-3">
                            <label for="u_id" class="col-sm-2 col-form-label">Pracownik:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="u_id" name="u_id" required>
                                    <?php
                                        foreach ($data["users"] as $user) {
                                            $id = $user->id;
                                            echo "<option value='$id'>$user->first_name $user->last_name</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="b_description" class="col-sm-2 col-form-label">Opis:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="b_description" name="b_description">
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="date" class="col-sm-2 col-form-label">Data:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="amount" class="col-sm-2 col-form-label">Kwota:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="amount" name="amount" required>
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="type" class="col-sm-2 col-form-label">Rodzaj:</label>
                            <div class="col-sm-10">
            <?php
                $checked = " checked";
                foreach (BONUSTYPE as $f_type_key => $f_type_val) {
                    echo "  <div class='form-check'>
                                <input class='form-check-input' type='radio' name='type' id='type$f_type_key' value='$f_type_key' $checked>
                                <label class='form-check-label' for='type$f_type_key'>
                                $f_type_val
                                </label>
                            </div>";
                    $checked = "";
                }
            ?>
                        
                            </div>
                        </div>
                        </div>
                        
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="newadd">Zapisz</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Historia premii i kar</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pracownik</th>
                                <th scope="col">Data</th>
                                <th scope="col">Rodzaj</th>
                                <th scope="col">Kwota</th>
                                <th scope="col">Opis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($data["bonuses"])) {
                                foreach ($data["bonuses"] as $bonus) {
                                    echo "<tr>";
                                    echo "<td>" . $data["users"][$bonus->u_id]->first_name . " " . $data["users"][$bonus->u_id]->last_name . "</td>";
                                    echo "<td>" . $bonus->date . "</td>";
                                    echo "<td>" . BONUSTYPE[$bonus->type] . "</td>";
                                    echo "<td>" . $bonus->amount . " zł</td>";
                                    echo "<td>" . $bonus->b_description . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

    </main>
    <?php require_once 'landings/footer.view.php' ?>