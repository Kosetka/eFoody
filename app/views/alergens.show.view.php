<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>



<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4" style="">
        <div class="card-header">
          <h2 class="">Lista produktów z alergenem - <?= $data["alergen"]->a_name;?></h2>
        </div>
        <div class="form-group row m-3">
          <div class="col-sm-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Zdjęcie produktu</th>
                  <th scope="col">Nazwa produktu</th>
                  <th scope="col">SKU</th>
                  <th scope="col">Zdjęcia alergenów</th>
                  <th scope="col">Nazwy alergenów</th>
                  <th scope="col">Lista alergenów</th>
                  <th scope="col">Akcje</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //show($data);
                if(isset($data["p_alergen"])) {
                    foreach ($data["p_alergen"] as $key => $value) {
                        if (!empty($data["product"][$key]->p_photo)) {
                            $photo = "<img width='40' height='40' class='obrazek' id='imageBox$value->id' src='" . IMG_ROOT . "" . $data["product"][$key]->p_photo . "'>";
                        } else {
                            $photo = "";
                        }
                        
                      echo "  <tr><td>$photo</td>
                                <td>".$data["product"][$key]->p_name."</td>
                                <td>".$data["product"][$key]->sku."</td>";

                        $numbers = explode(",", $data["prod_alergens"][$key]->lista_a_id);
                        $photo2 = "";
                        $ids = "";
                        $names = "";
                        foreach ($numbers as $number) {
                            $ids .=$number.", ";
                            $names .=$data["alergens"][$number]->a_name.", ";
                            if (!empty($data["alergens"][$number]->a_photo)) {
                                $photo2 .= "<img width='40' height='40' class='obrazek' title='".$data["alergens"][$number]->a_name."' id='imageBox".$key."_".$number."' src='" . IMG_ALERGENS_ROOT . "" . $data["alergens"][$number]->a_photo . "'>";
                            }
                        }

                        echo "<td>".$photo2."</td>";
                        echo "<td>".substr($names, 0, -2)."</td>";
                        echo "<td>".substr($ids, 0, -2)."</td>";




                      echo "<td><a href='".ROOT."/products/edit/".$key."' class='btn btn-primary' role='button'>Edytuj</a></td>"; 
                      //          <a href='".ROOT."/alergens/show/".$key."' class='btn btn-success' role='button'>Pokaż produkty</a>";
                      echo "</tr>";
                    }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
        <?php require_once 'landings/footer.view.php' ?>