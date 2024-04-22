<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Lista użytkowników</h2>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>E-mail</th>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Wybrany magazyn</th>
                                <th>Uprawnienia</th>
                                <th>Aktywny</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>E-mail</th>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Wybrany magazyn</th>
                                <th>Uprawnienia</th>
                                <th>Aktywny</th>
                                <th>Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $roles = [0 => "Brak uprawnień"];
                            foreach ($data["roles"] as $r) {
                                $roles[$r["id"]] = $r["role_name"];
                            }
                            $cities = [0 => "Brak magazynu"];
                            foreach ($data["cities"] as $s) {
                                $cities[$s["id"]] = $s;
                            }
                            foreach ($data["users"] as $user) {
                                $id = $user['id'];
                                $email = $user['email'];
                                $first_name = $user['first_name'];
                                $last_name = $user['last_name'];
                                $title_warehouse = "";


                                if ($user['u_warehouse'] === 0) {
                                    $u_warehouse = $cities[0];
                                } else {
                                    $u_warehouse = $cities[$user['u_warehouse']]["c_name"] . "_" . $cities[$user['u_warehouse']]["wh_name"];
                                    $title_warehouse = $cities[$user['u_warehouse']]["c_fullname"] . " -> " . $cities[$user['u_warehouse']]["wh_fullname"];
                                }
                                $u_role = $roles[$user['u_role']];
                                $active = $user['active'];
                                if ($active === 1) {
                                    $active_display = 'Aktywny';
                                } else {
                                    $active_display = 'Nieaktywny';
                                }
                                $edit_link = '<a href="' . ROOT . '/users/edit/' . $id . '">Edytuj</a>';
                                echo "<tr>
                                    <td>$id</td>
                                    <td>$email</td>
                                    <td>$first_name</td>
                                    <td>$last_name</td>
                                    <td><span data-toggle='tooltip' data-placement='right' title='$title_warehouse'>$u_warehouse </span></td>
                                    <td>$u_role</td>
                                    <td>$active_display</td>
                                    <td>$edit_link</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>