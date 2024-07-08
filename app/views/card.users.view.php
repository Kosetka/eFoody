<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post">
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
                $th1 = "Przypisz kartę";
                $th2 = "";
                $th3 = "";
                $th4 = "";
                $th5 = "";
                $th6 = "";
                $th7 = "Zapisz";
                if (isset($data["card_data"])) {
                    $th1 = "Edytuj przypisaną kartę";
                    $th2 = $data["card_data"]->date_from;
                    $th3 = $data["card_data"]->date_to;
                    $th4 = $data["card_data"]->card_id;
                    $th7 = "Zapisz zmiany";
                }

                ?>

                <h1 class="h3 mb-3 fw-normal"><?php echo $th1; ?></h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="date_from" name="date_from"
                                value="<?php echo $th2; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="date_to" name="date_to"
                                value="<?php echo $th3; ?>">
                        </div>
                    </div>
                    <?php
                    if(isset($data["card_data"])) {
                        ?>
                        <div class="form-group row m-3">
                            <label for="card_id" class="col-sm-2 col-form-label">Karta:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="card_id" name="card_id"
                                    value="<?php echo $th4; ?>" disabled>
                                <input type="text" class="form-control" id="input_edit" name="input_edit"
                                    hidden value="1">
                            </div>
                        </div>
                    <?php
                    } else {
                        ?>
                    
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="card_id">Wybierz kartę:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="card_id" name="card_id">
                                <?php
                                    foreach ($data["free_cards"] as $card) {
                                        $id = $card->card_id;
                                        echo "<option value='$id'>$id</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="newAdd"><?php echo $th7; ?>
                </button>
            </form>
        </main>
        <div class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <h1 class="h3 mb-3 fw-normal">Historia kart:</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nazwa karty</th>
                        <th scope="col">Data od</th>
                        <th scope="col">Data do</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($data["user_cards"])) {
                        foreach ($data["user_cards"] as $card_user) {
                            echo "<tr>";
                            echo "<td>" . $card_user->card_id . "</td>";
                            echo "<td>" . $card_user->date_from . "</td>";
                            echo "<td>" . $card_user->date_to . "</td>";
                            echo "<td><a href='".ROOT."/card/users/".$data['user_id']."/$card_user->id'>Edytuj</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php require_once 'landings/footer.view.php' ?>