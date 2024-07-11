<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <?= implode("<br>", $errors) ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success">
            <?= $success ?>
          </div>
        <?php endif; ?>
      <form method="post">
            <?php
    if($data["edit"] === True) {
        $edit = True;
        $head2 = "Edytowanie kosztu";
        $button2 = "Zapisz zmiany";
    } else {
        $head2 = "Dodawanie nowego kosztu";
        $button2 = "Dodaj koszt";
        $edit = False;
    }
            ?>
        <h1 class="h3 mb-3 fw-normal"><?= $head2;?></h1>

        <div class="text-start">
          <div class="form-group row m-3">
            <label for="cost_name" class="col-sm-2 col-form-label">Nazwa:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="cost_name" name="cost_name" required <?php if($edit) {echo " value='".$data["cost"]->name."'"; }?>>
            </div>
          </div>
          <div class="form-group row m-3">
            <legend class="col-sm-2 col-form-label ">Typ:</legend>
            <div class="col-sm-10">
                <?php
                    foreach(COSTTYPES as $k => $v) {
                        if($edit) {
                            if($data["cost"]->type == $k) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                        } else {
                            $checked = "";
                        }
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='radio' name='type' id='type$k' value='$k' $checked>
                                <label class='form-check-label' for='type$k'>$v</label>
                            </div>";
                    }
                ?>
            </div>
          </div>

            <div class="form-group row m-3 date-field" style="display:none;">
                <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_from" name="date_from" required <?php if($edit) {echo " value='".$data["cost"]->date_from."'"; }?>>
                </div>
            </div>
            <div class="form-group row m-3 date-field" style="display:none;">
                <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_to" name="date_to" <?php if($edit) {echo " value='".$data["cost"]->date_to."'"; }?>>
                </div>
            </div>
            <div class="form-group row m-3 single-date-field" style="display:none;">
                <label for="single_date" class="col-sm-2 col-form-label">Data:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="single_date" name="single_date" required <?php if($edit) {echo " value='".$data["cost"]->date."'"; }?>>
                </div>
            </div>

          <div class="form-group row m-3">
            <label for="price" class="col-sm-2 col-form-label">Kwota:</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required <?php if($edit) {echo " value='".$data["cost"]->price."'"; }?>>
            </div>
          </div>


          <div class="form-group row m-3">
            <label class="col-sm-2 col-form-label" for="category">Kategoria:</label>
            <div class="col-sm-10">
              <select class="form-control" id="category" name="category">
                <?php
                    $checked = "";
                    foreach(COSTCATEGORIES as $k => $v) {
                        if($edit) {
                            if($data["cost"]->category == $k) {
                                $checked = " selected";
                            } else {
                                $checked = "";
                            }
                        } else {
                            $checked = "";
                        }
                        echo "<option value='$k' $checked>$v</option>";
                    }
                ?>
              </select>
            </div>
          </div>


          <div class="form-group row m-3">
            <label for="method" class="col-sm-2 col-form-label">Metoda płatności:</label>
            <div class="col-sm-10">
            <select class="form-control" id="method" name="method">
                <?php
                    $checked = "";
                    foreach(COSTMETHODS as $k => $v) {
                        if($edit) {
                            if($data["cost"]->method == $k) {
                                $checked = " selected";
                            } else {
                                $checked = "";
                            }
                        } else {
                            $checked = "";
                        }
                        echo "<option value='$k' $checked>$v</option>";
                    }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="active" class="col-sm-2 col-form-label">Płatność aktywna:</label>
            <div class="col-sm-10">
              <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php if($edit) {if($data["cost"]->active == 1) {echo " checked"; }}?>>
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="description" class="col-sm-2 col-form-label">Opis:</label>
            <div class="col-sm-10">
            <input type="textarea" class="form-control" id="description" name="description" <?php if($edit) {echo " value='".$data["cost"]->description."'"; }?>>
            </div>
          </div>
        </div>
        
        <button class="w-100 btn btn-lg btn-primary" type="submit"><?=$button2;?></button>
      </form>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const dateFields = document.querySelectorAll('.date-field');
            const singleDateField = document.querySelector('.single-date-field');
            const singleDate = document.getElementById('single_date');

            function updateDateFields() {
                const selectedRadio = document.querySelector('input[name="type"]:checked');
                if (selectedRadio) {
                    const typeValue = selectedRadio.value;
                    if (typeValue >= 1 && typeValue <= 4) {
                        dateFields.forEach(field => {
                            field.style.display = 'flex';
                            field.querySelector('input').required = false;
                        });
                        singleDateField.style.display = 'none';
                        singleDate.required = false;
                    } else if (typeValue == 5) {
                        dateFields.forEach(field => {
                            field.style.display = 'none';
                            field.querySelector('input').required = false;
                        });
                        singleDateField.style.display = 'flex';
                        singleDate.required = true;
                    } else {
                        dateFields.forEach(field => {
                            field.style.display = 'none';
                            field.querySelector('input').required = false;
                        });
                        singleDateField.style.display = 'none';
                        singleDate.required = false;
                    }
                }
            }

            typeRadios.forEach(radio => {
                radio.addEventListener('change', updateDateFields);
            });

            // Wywołaj funkcję po załadowaniu strony
            updateDateFields();
        });
    </script>
    <?php require_once 'landings/footer.view.php' ?>