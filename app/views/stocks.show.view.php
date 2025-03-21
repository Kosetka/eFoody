<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Aktualny stan magazynowy</h2>
                    <h5 class="">Na podstawie inwentaryzacji</h5>
                    
                </div>
                <div class="card-body">
                    <div class="form-group row m-3">
                        <label for="w_id" class="col-sm-2 col-form-label">Magazyn:</label>
                        <label for="w_id" class="col-sm-10 col-form-label">
                            <?php
                            $wid = $data["user_warehouse"];
                            $full_name_warehouse = "[" . $data["cities"][$wid]["c_name"] . "_" . $data["cities"][$wid]["wh_name"] . "] " . $data["cities"][$wid]["c_fullname"] . " " . $data["cities"][$wid]["wh_fullname"];
                            echo $full_name_warehouse;
                            ?>
                        </label>
                    </div>
                    <div id="modal" class="modal">
                        <span class="close">&times;</span>
                        <div class="modal-content">
                            <img id="modal-image" src="" alt="Modal Image">
                        </div>
                    </div>
                    <?php
    //show($data["user_warehouse"]);
                    ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Zdjęcie</th>
                                        <th scope="col">Półprodukt</th>
                                        <th scope="col">Opis</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Ilość</th>
                                        <th scope="col">Ostatnia aktualizacja</th>
                                        <th scope="col">Aktualizował</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //show($data["sets"]);
                                    foreach ($data["products"] as $prod_key => $prod_val) {
                                        $product_p_photo = $prod_val->p_photo;
                                        if (!empty($product_p_photo)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $product_p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        echo "  <tr>
                                                    <td>$photo</td>
                                                    <td>$prod_val->p_name</td>
                                                    <td>$prod_val->p_description</td>
                                                    <td style='white-space: nowrap'>$prod_val->sku</td>";
                                        if(isset($data["sets"][$prod_val->id]) && !empty($data["sets"][$prod_val->id]) ) {
                                            if(is_array($data["sets"][$prod_val->id])) {
                                                /*echo "      <td>".$data["sets"][$prod_val->id][0]->amount ."ss ".$prod_val->p_unit."</td>";
                                                echo '<td class="last-update">'.$data["sets"][$prod_val->id][0]->date.'</td>';
                                                echo "      <td>".$data["users"][$data["sets"][$prod_val->id][0]->u_id]->first_name." ".$data["users"][$data["sets"][$prod_val->id][0]->u_id]->last_name."</td>";
                                                */
                                                echo "      <td>0 $prod_val->p_unit</td>";
                                                echo "      <td colspan='2'>Brak na magazynie</td>";
                                            
                                                //show($data["sets"][$prod_val->id]);
                                            } else {
                                                echo "      <td>".$data["sets"][$prod_val->id]->amount ." ".$prod_val->p_unit."</td>";
                                                echo '<td class="last-update">'.$data["sets"][$prod_val->id]->date.'</td>';
                                                echo "      <td>".$data["users"][$data["sets"][$prod_val->id]->u_id]->first_name." ".$data["users"][$data["sets"][$prod_val->id]->u_id]->last_name."</td>";
                                            }
                                            //show($data["sets"][$prod_val->id]);
                                        } else {
                                            echo "      <td>0 $prod_val->p_unit</td>";
                                            echo "      <td colspan='2'>Brak na magazynie</td>";
                                        }
                                        echo "</tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
                </div>
            </div>

        </main>
        <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pobierz bieżącą datę
        const today = new Date();
        const todayYear = today.getFullYear();
        const todayMonth = today.getMonth();
        const todayDate = today.getDate();

        // Funkcja sprawdzająca i kolorująca daty
        function checkAndColorDates() {
            const cells = document.querySelectorAll(".last-update");
            cells.forEach(cell => {
                const cellDateStr = cell.textContent.trim();
                const cellDate = new Date(cellDateStr);
                
                // Porównanie tylko roku, miesiąca i dnia
                const cellYear = cellDate.getFullYear();
                const cellMonth = cellDate.getMonth();
                const cellDay = cellDate.getDate();

                if (cellYear === todayYear && cellMonth === todayMonth && cellDay === todayDate) {
                    // Dzisiaj
                    cell.style.backgroundColor = "lightgreen";
                } else {
                    // Różnica dni między dzisiejszą datą a datą z komórki
                    const timeDifference = today - cellDate;
                    const dayDifference = Math.floor(timeDifference / (1000 * 3600 * 24));

                    if (dayDifference >= 1 && dayDifference <= 7) {
                        // Od wczoraj do 7 dni wstecz
                        cell.style.backgroundColor = "lightyellow";
                    } else if (dayDifference > 7) {
                        // Więcej niż 7 dni
                        cell.style.backgroundColor = "lightcoral";
                    }
                }
            });
        }

        checkAndColorDates();
    });
</script>
        <?php require_once 'landings/footer.view.php' ?>