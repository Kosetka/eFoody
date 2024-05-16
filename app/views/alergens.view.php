<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>



<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4" style="">
        <div class="card-header">
          <h2 class="">Lista alergenów</h2>
        </div>
        <div class="form-group row m-3">
          <div class="col-sm-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Numer</th>
                  <th scope="col">Zdjęcie</th>
                  <th scope="col">Nazwa</th>
                  <th scope="col">Akcje</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(isset($data["alergens"])) {
                    foreach ($data["alergens"] as $key => $value) {
                        if (!empty($value->a_photo)) {
                            $photo = "<img width='40' height='40' class='obrazek' id='imageBox$value->id' src='" . IMG_ALERGENS_ROOT . "" . $value->a_photo . "'>";
                        } else {
                            $photo = "";
                        }
                      echo "  <tr><td>$key</td>
                                <td>".$photo."</td>
                                <td>".$value->a_name."</td>
                                <td><a href='".ROOT."/alergens/edit/".$key."' class='btn btn-primary' role='button'>Edytuj</a> <a href='#' class='btn btn-success' role='button'>Pokaż produkty</a></td>";
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