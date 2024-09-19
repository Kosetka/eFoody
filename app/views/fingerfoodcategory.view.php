<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Lista kategorii Fingerfood</h2>
                    
                </div>
                <div class="card-body">
                    <?php
                        $access = [1, 2];
                        if(in_array($your_id,$access)) {
                            echo '<a type="button" class="btn btn-primary" href="'.ROOT.'/fingerfoodcategory/new">Dodaj nową kategorię</a>';
                        }

                    ?>
                    
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Nazwa kategorii</th>
                                <th>Opis</th>
                                <th>Zdjęcie 1</th>
                                <th>Zdjęcie 2</th>
                                <th>Zdjęcie 3</th>
                                <th>Status</th>
                                <th>Kolejność</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nazwa kategorii</th>
                                <th>Opis</th>
                                <th>Zdjęcie 1</th>
                                <th>Zdjęcie 2</th>
                                <th>Zdjęcie 3</th>
                                <th>Status</th>
                                <th>Kolejność</th>
                                <th>Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if(!empty($data["fingerfoodscategory"] )) {
                                foreach($data["fingerfoodscategory"] as $fc) {
                                    if($fc->f_active == 1) {
                                        $status = "Aktywny";
                                    } else {
                                        $status = "Nieaktywny";
                                    }
                                    $photo_1 = "";
                                    $photo_2 = "";
                                    $photo_3 = "";
                                    if($fc->fc_photo_1 != "") {
                                        $photo_1 = "<img width='40' height='40' class='obrazek' id='imageBox_1_$fc->id' src='" . IMG_ROOT . "" . $fc->fc_photo_1 . "'>";
                                    }
                                    if($fc->fc_photo_2 != "") {
                                        $photo_2 = "<img width='40' height='40' class='obrazek' id='imageBox_2_$fc->id' src='" . IMG_ROOT . "" . $fc->fc_photo_2 . "'>";
                                    }
                                    if($fc->fc_photo_3 != "") {
                                        $photo_3 = "<img width='40' height='40' class='obrazek' id='imageBox_3_$fc->id' src='" . IMG_ROOT . "" . $fc->fc_photo_3 . "'>";
                                    }
                                    echo "<tr>
                                        <td>$fc->fc_name</td>
                                        <td>$fc->fc_description</td>";
                                    echo "<td>$photo_1</td>";
                                    echo "<td>$photo_2</td>";
                                    echo "<td>$photo_3</td>";
                                    echo "  <td>$status</td>
                                            <td>$fc->f_order</td>";

                                    if(in_array($your_id,$access)) {
                                        echo "<td><a href='" . ROOT . "/fingerfoodcategory/edit/" . $fc->id . "'>Edytuj</a></td>";
                                    } else {
                                        echo "<td></td>";
                                    }
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