<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
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

                <h1 class="h3 mb-3 fw-normal">Skanowanie produktów</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="sku" class="col-sm-2 col-form-label">Kod kreskowy:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="sku" name="sku" autofocus>
                        </div>
                        <button class="col-sm-2 btn btn-lg btn-primary" type="submit" name="scan">Skanuj</button>
                    </div>
                </div>
            </form>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Ostatnie 10 skanów</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">SKU</th>
                                <th scope="col">EAN</th>
                                <th scope="col">Nazwa produktu</th>
                                <th scope="col">Pracownik</th>
                                <th scope="col">Magazyn</th>
                                <th scope="col">Data skanowania</th>
                                <th scope="col">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (!isset($data["scans"])) {
                                echo "<tr><th colspan='8'>Brak danych do wyświetlenia</th></tr>";
                            } else {
                                foreach ($data["scans"] as $scan) {
                                    $user = "<a href='" . ROOT . "/users/edit/" . $scan->u_id . "'>" . $scan->first_name . " " . $scan->last_name . "</a>";
                                    $prod = "<a href='" . ROOT . "/products/edit/" . $scan->p_id . "'>" . $scan->p_name . "</a>";
                                    $wh = "<a href='" . ROOT . "/warehouse/edit/" . $scan->wh_id . "'>" . $scan->c_name . "->" . $scan->wh_name . "</a>";
                                    echo "  <tr>
                                                    <th scope='row'>$scan->ps_id</th>
                                                    <td>$scan->sku</td>
                                                    <td>$scan->ean</td>
                                                    <td>$prod</td>
                                                    <td>$user</td>
                                                    <td>$wh</td>
                                                    <td>$scan->ps_date</td>
                                                    <td><a class='btn btn-danger' onClick = 'clicked($scan->ps_id, $scan->u_id)' data-el=$scan->ps_id 
                                                            role='button'>Usuń</a></td>
                                                </tr>";
                                    //href=' " . ROOT . "/scanner/delete/$scan->ps_id'
                                }
                            }
                            ?>
                            <script>
                                function clicked(id, user) {
                                    $.ajax({
                                        url: '<?php echo ROOT . "/scanner/delete/" ?>' + id + '/' + user,
                                        success: function (data) {
                                            alert("Pomyślnie usunięto skan");
                                            window.location.href = window.location.href
                                        }
                                    });
                                }
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>