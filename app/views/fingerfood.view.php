<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="container-fluid px-4">
            <?php
                    foreach($data["fingerfoodscategory"] as $fc) {
                ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Kategoria: <?=$fc->fc_name;?> (<?=PAGETYPE[$fc->type];?>)</h2>
                    <?php
                        echo '<a type="button" class="btn btn-primary" href="'.ROOT.'/fingerfood/new/'.$fc->id.'">Dodaj nowy Fingerfood</a>';
                    ?>
                </div>
                
                <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Cena</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Kolejność</th>
                                    <th scope="col">Akcje</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if(!empty($data["fingerfoods"])) {
                                    foreach($data["fingerfoods"] as $key => $value) {
                                        if($value->f_category == $fc->id) {
                                            $status = "Nieaktywne";
                                            if($value->f_active == 1) {
                                                $status = "Aktywne";
                                            }
                                            $photo = "";
                                            if($value->f_photo != "") {
                                                $photo = "<img width='40' height='40' class='obrazek' id='imageBox$value->id' src='" . IMG_ROOT . "" . $value->f_photo . "'>";
                                            }

                                            echo "  <tr>
                                                <td>$photo</td>
                                                <td>$value->f_name</td>
                                                <td>$value->f_description</td>
                                                <td>$value->f_cost zł</td>
                                                <td>$status</td>
                                                <td>$value->f_order</td>";
                                            echo "<td><a class='btn btn-info' href=' " . ROOT . "/fingerfood/edit/$value->id' role='button'>Edytuj</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <?php
                    }
                    ?>
        </main>
        <?php require_once 'landings/footer.view.php' ?>