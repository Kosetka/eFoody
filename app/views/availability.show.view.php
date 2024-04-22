<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
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

                <h1 class="h3 mb-3 fw-normal">Lista magazynów</h1>
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">TAG</th>
                                    <th scope="col">Pełna nazwa</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Ostatnia inwentaryzacja</th>
                                    <th scope="col">Osoba</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data["cities"] as $key => $value) {
                                    $id = $key;
                                    $tag = "[" . $value["c_name"] . "_" . $value["wh_name"] . "]";
                                    $full_name = $value["c_fullname"] . " -> " . $value["wh_fullname"];
                                    $opis = "Magazyn: " . $value["c_description"] . "</br>Miasto: " . $value["wh_description"];
                                    if (isset($data["sets"][$key][0])) {
                                        $date = $data["sets"][$key][0]->date;
                                        $u_id = $data["sets"][$key][0]->u_id;
                                        $user = $data["users"][$u_id]->first_name . " " . $data["users"][$u_id]->last_name;
                                    } else {
                                        $user = "";
                                        $date = "";
                                    }
                                    echo "  <tr><td>$id</td>
                                            <td>$tag</td>
                                            <td>$full_name</td>
                                            <td>$opis</td>
                                            <td>$date</td>
                                            <td>$user</td>";
                                    echo "<td><a href='" . ROOT . "/availability/edit/" . $id . "'>Edytuj</a></td>";
                                    echo "</tr>";
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>