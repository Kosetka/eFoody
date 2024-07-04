<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <?php
                if($data["edit"] === True) {
                    $edit = True;
                    $head2 = "Edytowanie karty";
                    $button2 = "Zapisz zmiany";
                    $blocked = " disabled";
                } else {
                    $head2 = "Dodawanie nowej karty";
                    $button2 = "Dodaj kartę";
                    $edit = False;
                    $blocked = "";
                }
            ?>
    <div class="card mb-4">
            <div class="card-header">
                <h2 class=""><?= $head2;?></h2>
            </div>
            <div class="card-body">
      <form method="post">
        <div class="text-start">
          <div class="form-group row m-3">
            <label for="card_id" class="col-sm-2 col-form-label">Numer karty:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="card_id" name="card_id" required $blocked <?php if($edit) {echo " value='".$data["card"]->card_id."'"; }?>>
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="status" class="col-sm-2 col-form-label">Karta aktywna:</label>
            <div class="col-sm-10">
              <input type="checkbox" class="form-check-input" id="status" name="status" value="1" <?php if($edit) {if($data["card"]->status == 1) {echo " checked"; }}?>>
            </div>
          </div>
        </div>
        
        <button class="w-100 btn btn-lg btn-primary" type="submit"><?=$button2;?></button>
      </form>
      </div>
      </div>
<?php if($data["edit"] === False) { ?>
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="">Ostatnie niezarejestrowane karty</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nazwa karty</th>
                            <th scope="col">Budynek</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (!$data["last_errors"]) {
                            echo "<tr><th colspan='3'>Brak danych do wyświetlenia</th></tr>";
                        } else {
                            foreach ($data["last_errors"] as $err) {
                                echo "  <tr>
                                            <th scope='row'>$err->card_name</th>";
                                if($err->w_id == 0) {
                                    echo "<td>App</td>";
                                } else {
                                    $city_name = $data["city"][$err->w_id]->c_fullname . " : " . $data["city"][$err->w_id]->wh_fullname;
                                    echo "<td>$city_name</td>";
                                }
                                echo "<td>$err->date</td>
                                        </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php }?>
        
    </main>
    <?php require_once 'landings/footer.view.php' ?>