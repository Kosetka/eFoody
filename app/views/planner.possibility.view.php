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
<script>
    var buttonsAndModals = [];
    </script>
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="">Możliwa produkcja</h2>
            </div>
            <?php //show($data);?>
            <div class="form-group row m-3">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Produkt</th>
                                <?php
                                foreach($data["cities"] as $city) {
                                    echo "<th scope='col'>[".$city["id"]."] -> ".$city["c_name"] ."_".$city["wh_name"] . " -> ".$city["c_fullname"]." ".$city["wh_fullname"]."</th>";
                                }
                                ?>
                                <th scope="col">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $arrayJS = [];
                                echo "<tr>";
                                echo "<td><table width='100%;'><tr><th>Zdjęcie</th><th>Nazwa produktu</th><th>SKU</th></tr>";
                                foreach ($data["fullproducts"] as $key => $value) {
                                    if (!empty($value->p_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    echo "<tr style='height: 80px;'>";
                                    echo "<td>$photo</td>";
                                    echo "<td>$value->p_name [<a href='".ROOT."/recipes'>przepis</a>]</td>";
                                    echo "<td>$value->sku</td>";
                                    echo "</tr>";
                                    /*echo "<td>[$key] $value->p_name</td>";
                                    echo "<td>$value->sku</td>";
                                    echo "<td>".$data["prod_num"][$city["id"]][$key]."</td>";
                                    echo "<td>$value->p_unit</td>";*/
                                }
                                echo "</table></td>";
                                $int = 1;
                                foreach($data["cities"] as $city) {
                                    echo "<td><table width='100%;'><tr><th>(?)</th><th>Max produkcja</th><th>Ustaw</th></tr>";
                                    foreach ($data["fullproducts"] as $key => $value) {
                                        echo "<tr style='height: 80px;'>";
                                        
                                        if(!empty($data["recipes"][$key])) {
                                            $max_to_do = 999;
                                            $req = "";
                                            foreach($data["recipes"][$key] as $k => $v) {

                                                $have = $data["sets"][$city["id"]][$v->sub_prod]->amount;
                                                $need = $v->amount;
                                                $te = floor($have / $need);
                                                if($te < $max_to_do) {
                                                    $max_to_do = $te;
                                                }
                                                $req .= "Wymagania: \\n\\n";
                                                $req .= $data["subproducts"][$v->sub_prod]->p_name . " : " .$need ." -> Posiadam: ".$have;
                                                $req .= "\\n";
                                            }
                                            echo "<script>buttonsAndModals.push({buttonText: 'Button', modalTitle: '".$value->p_name."', modalContent: '".json_encode($req)."'});</script>";
                                            echo '<td>';
                                            // echo '<span id="myBtn" data-toggle="modal" data-target="#myModal'.$int.'">Open Modal</span>';
                                            echo '</td>';
                                            $int++;
                                            echo "<td><label for='input_".$city["id"]."_$key'>$max_to_do</label> Szt.</td>";
                                            echo "<td><input type='number' value='0' min='0' max='$max_to_do' name='input_".$city["id"]."_$key' id='input_".$city["id"]."_$key' class='input' data-wiersz='$key' data-kolumna='".$city["id"]."'></td>";
                                            //$arrayJS[$city["id"]][$key][""];

                                        } else {
                                            echo "<td></td>"; //Brak przepisu
                                            echo "<td></td>";
                                            echo "<td></td>";
                                        }
                                        
                                        echo "</tr>";
                                    }
                                    echo "</table></td>";
                                }    
                                
                                echo "</tr>";
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            <?php 
                $tablica_recipes = json_encode($data["recipes"]);
                $tablica_subproducts = json_encode($data["subproducts"]);
                $tablica_sets = json_encode($data["sets"]);
            ?>
            var tablica_recipes = <?php echo $tablica_recipes; ?>;
            var tablica_subproducts = <?php echo $tablica_subproducts; ?>;
            var tablica_sets = <?php echo $tablica_sets; ?>;
            document.querySelectorAll('.input').forEach(input => {
                input.addEventListener('change', function() {
                    const kolumna = this.dataset.kolumna;
                    const inputyWKolumnie = document.querySelectorAll(`.input[data-kolumna="${kolumna}"]`);
                    const wartosciWKolumnie = {};
                    // to fix
                    inputyWKolumnie.forEach(input => {
                        const wiersz = input.dataset.wiersz;
                        wartosciWKolumnie[wiersz] = input.value;
                    });
                    inputyWKolumnie.forEach(input => {
                        const inputValue = this.value;
                        const labelFor = input.getAttribute('name');
                        const labels = document.querySelectorAll(`label[for="${labelFor}"]`);
                        
                        labels.forEach(label => {
                            label.innerText = inputValue;
                        });
                    });
                    console.log(`Wartości inputów w kolumnie ${kolumna}:`, wartosciWKolumnie);
                    
                    // Tutaj możesz wykonać dodatkowe akcje w zależności od wartości inputów w danej kolumnie
                });
            });
        </script>
        <?php 
        foreach($data["cities"] as $city) {
        ?>
        <div class="card mb-4">
            <div class="card-header">
                <h2 class=""><?php echo "[".$city["id"] . "] -> ".$city["c_name"] ."_".$city["wh_name"] . " -> ".$city["c_fullname"]." ".$city["wh_fullname"];?></h2>
            </div>
            <div class="form-group row m-3">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Zdjęcie</th>
                                <th scope="col">Nazwa półproduktu</th>
                                <th scope="col">SKU</th>
                                <th scope="col">Ilość</th>
                                <th scope="col">Jednostka</th>
                                <th scope="col">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data["subproducts"] as $key => $value) {
                                if (!empty($value->p_photo)) {
                                    $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                } else {
                                    $photo = "";
                                }
                                echo "  <tr><td>$photo</td>
                                            <td>[$key] $value->p_name</td>
                                            <td>$value->sku</td>
                                            <td>".$data["sets"][$city["id"]][$key]->amount."</td>
                                            <td>$value->p_unit</td>
                                            <td></td>";
                                echo "</tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
        }
        ?>




    <div id="modalsContainer">
        <!-- Tutaj będą dynamicznie dodawane modale -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // Tablica zawierająca informacje o przyciskach i modalach
    
    
    // Funkcja dodająca przyciski i modale do strony na podstawie tablicy
    function createButtonsAndModals() {
        var buttonsContainer = $("#buttonsContainer");
        var modalsContainer = $("#modalsContainer");
        
        buttonsAndModals.forEach(function(item, index) {
            // Dodaj przycisk
            var button = $("<button>").addClass("btn btn-primary").text(item.buttonText);
            //button.attr("data-toggle", "modal");
            //button.attr("data-target", "#myModal" + index);
            buttonsContainer.append(button);
            
            // Dodaj modal
            var modal = $("<div>").addClass("modal").attr("id", "myModal" + index);
            modal.append(
                $("<div>").addClass("modal-dialog mymodal").append(
                    $("<div>").addClass("modal-content mymodal").append(
                        $("<div>").addClass("modal-header mymodal").append(
                            $("<h4>").addClass("modal-title mymodal").text(item.modalTitle),
                            $("<button>").addClass("close").attr("type", "button").attr("data-dismiss", "modal").html("&times;")
                        ),
                        $("<div>").addClass("modal-body mymodal").text(item.modalContent),
                        $("<div>").addClass("modal-footer mymodal").append(
                            $("<button>").addClass("btn btn-secondary").attr("type", "button").attr("data-dismiss", "modal").text("Zamknij")
                        )
                    )
                )
            );
            modalsContainer.append(modal);
        });
    }
    
    // Wywołaj funkcję tworzącą przyciski i modale po załadowaniu dokumentu
    $(document).ready(function() {
        createButtonsAndModals();
    });
</script>
        </main>
        <?php require_once 'landings/footer.view.php' ?>