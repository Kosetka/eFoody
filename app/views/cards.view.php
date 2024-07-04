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
                    <a type="button" class="btn btn-primary" href="<?= ROOT ?>/card/new">Dodaj nową kartę</a>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Numer seryjny</th>
                                <th>Status</th>
                                <th>Właściciel</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numer seryjny</th>
                                <th>Status</th>
                                <th>Właściciel</th>
                                <th>Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($data["cards"] as $card) {
                                if($card->status == 1) {
                                    $status = "Aktywna";
                                } else {
                                    $status = "Zablokowana";
                                }
                                $owner = 0;
                                foreach($data["card_user"] as $cu) {
                                    if($cu->card_id == $card->card_id) {
                                        $owner = $cu->u_id;
                                    }
                                }
                                echo "<tr>
                                    <td>$card->card_id</td>
                                    <td>$status</td>";
                                    if($owner == 0) {
                                        echo "<td>wolna</td>";
                                    } else {
                                        echo "<td>".$data["users"][$owner]->first_name ." ".$data["users"][$owner]->last_name."</td>";
                                    }
                                    

                                echo "<td><a href='" . ROOT . "/card/edit/" . $card->id . "'>Edytuj</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>