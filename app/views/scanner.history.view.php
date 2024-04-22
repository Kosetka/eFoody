<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <form method="get">

                <h1 class="h3 mb-3 fw-normal">Parametry wyszukiwania</h1>
                <?php
                $date_from = "";
                $date_to = "";
                $sku = "";
                $ean = "";
                $user = "";
                $warehouse = "";
                if (isset($data["get"]["date_from"])) {
                    $date_from = $data["get"]["date_from"];
                }
                if (isset($data["get"]["date_to"])) {
                    $date_to = $data["get"]["date_to"];
                }
                if (isset($data["get"]["sku"])) {
                    $sku = $data["get"]["sku"];
                }
                if (isset($data["get"]["ean"])) {
                    $ean = $data["get"]["ean"];
                }
                if (isset($data["get"]["user"])) {
                    $user_id = $data["get"]["user"];
                }
                if (isset($data["get"]["warehouse"])) {
                    $warehouse = $data["get"]["warehouse"];
                }
                ?>


                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="<?php echo $date_from; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="<?php echo $date_to; ?>" required>
                        </div>
                    </div>
                    <script>
                        const date = new Date();
                        let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
                        let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date);
                        let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);

                        let currentDate = `${year}-${month}-${day}`;

                        <?php
                        if (!isset($data["get"]["date_from"])) {
                            echo "document.getElementById('date_from').setAttribute('value', currentDate);";
                        }
                        if (!isset($data["get"]["date_to"])) {
                            echo "document.getElementById('date_to').setAttribute('value', currentDate);";
                        }
                        ?>
                    </script>
                    <div class="form-group row m-3">
                        <label for="sku" class="col-sm-2 col-form-label">SKU:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="ean" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ean" name="ean" value="<?php echo $ean; ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="user">Pracownik:</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="user" name="user">
                                <?php
                                echo "<option value=''>Wszyscy</option>";
                                foreach ($data["users"] as $user) {
                                    $full_name = $user["first_name"] . " " . $user["last_name"];
                                    $id = $user["id"];
                                    if ($id == $user_id) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='$id' $selected>$full_name [id: $id]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="warehouse">Magazyn:</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="warehouse" name="warehouse">
                                <?php
                                echo "<option value=''>Wszystkie</option>";
                                foreach ($data["cities"] as $city) {
                                    $full_tag = $city["c_name"] . "_" . $city["wh_name"];
                                    $full_name = $city["c_fullname"] . " -> " . $city["wh_fullname"];
                                    $id = $city["id"];
                                    if ($id == $warehouse) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='$id' $selected>$full_tag : $full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <button class="col-sm-12 btn btn-lg btn-primary" type="submit" name="search" value=1>Szukaj</button>
                </div>
            </form>
            <div class="card mb-4" style="margin-top:30px">
                <div class="card-header">
                    <h2 class="">Historia skanowania</h2>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>EAN</th>
                                <th>Nazwa produktu</th>
                                <th>Pracownik</th>
                                <th>Magazyn</th>
                                <th>Data skanowania</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>EAN</th>
                                <th>Nazwa produktu</th>
                                <th>Pracownik</th>
                                <th>Magazyn</th>
                                <th>Data skanowania</th>
                                <th>Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (isset($data["scans"]) && $data["scans"] != "") {
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
                                                    <td>";
                                    //echo "<a class='btn btn-danger' onClick = 'clicked($scan->ps_id, $scan->u_id)' data-el=$scan->ps_id role='button'>Usuń</a>";
                                    echo "</td></tr>";
                                    //href=' " . ROOT . "/scanner/delete/$scan->ps_id'
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>