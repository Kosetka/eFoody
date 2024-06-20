<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Lista kart magnetycznych</h2>
                    
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Numer seryjny</th>
                                <th>Status</th>
                                <th>Właściciel</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Numer seryjny</th>
                                <th>Status</th>
                                <th>Właściciel</th>
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
                            //show($data["users"]);
                            foreach ($data["users"] as $user) {
                                $id = $user['id'];
                                $email = $user['email'];
                                $first_name = $user['first_name'];
                                $last_name = $user['last_name'];
                                $phone_business = $user['phone_business'];
                                $phone_private = $user['phone_private'];
                                $title_warehouse = "";
                                $helper_for = "";
                                if(!empty($user['helper_for'])) {
                                    $helper_for = $data["users"][$user['helper_for']]["first_name"].' '.$data["users"][$user['helper_for']]["last_name"];
                                }


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
                                
                                $access = [1, 2];
                                if(in_array($your_id,$access)) {
                                    $edit_link = '<a href="' . ROOT . '/users/edit/' . $id . '">Edytuj</a>';
                                    $edit_card = '<a href="' . ROOT . '/users/edit/' . $id . '">Lista</a>';
                                } else {
                                    $edit_link = "";
                                    $edit_card = "";
                                }

                                echo "<tr>
                                    <td>$id</td>
                                    <td>$email</td>
                                    <td>$first_name</td>
                                    <td>$last_name</td>
                                    <td>$phone_business</td>
                                    <td>$phone_private</td>
                                    <td><span data-toggle='tooltip' data-placement='right' title='$title_warehouse'>$u_warehouse </span></td>";
                                if($user['u_role'] == 10) {
                                    echo "<td>$u_role ($helper_for)</td>";
                                } else {
                                    echo "<td>$u_role</td>";
                                }

                                echo "<td>$active_display</td>
                                    <td>$edit_link</td>
                                    <td>$edit_card</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>