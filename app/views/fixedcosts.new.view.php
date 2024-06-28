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

        <h1 class="h3 mb-3 fw-normal">Dodawanie nowego kosztu</h1>

        <div class="text-start">
          <div class="form-group row m-3">
            <label for="cost_name" class="col-sm-2 col-form-label">Nazwa:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="cost_name" name="cost_name" required>
            </div>
          </div>
          <div class="form-group row m-3">
            <legend class="col-sm-2 col-form-label ">Typ:</legend>
            <div class="col-sm-10">

                <div class='form-check'>
                    <input class='form-check-input' type='radio' name='type' id='type1' value='1'>
                    <label class='form-check-label' for='type1'>Dzienny</label>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='radio' name='type' id='type2' value='2'>
                    <label class='form-check-label' for='type2'>Tygodniowy</label>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='radio' name='type' id='type3' value='3'>
                    <label class='form-check-label' for='type3'>Miesięczny</label>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='radio' name='type' id='type4' value='4'>
                    <label class='form-check-label' for='type4'>Roczny</label>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='radio' name='type' id='type5' value='5'>
                    <label class='form-check-label' for='type5'>Jednorazowy</label>
                </div>

            </div>
          </div>

            <div class="form-group row m-3 date-field" style="display:none;">
                <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_from" name="date_from" required>
                </div>
            </div>
            <div class="form-group row m-3 date-field" style="display:none;">
                <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_to" name="date_to" required>
                </div>
            </div>
            <div class="form-group row m-3 single-date-field" style="display:none;">
                <label for="single_date" class="col-sm-2 col-form-label">Data:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="single_date" name="single_date" required>
                </div>
            </div>

          <div class="form-group row m-3">
            <label for="price" class="col-sm-2 col-form-label">Kwota:</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required>
            </div>
          </div>


          <div class="form-group row m-3">
            <label class="col-sm-2 col-form-label" for="category">Kategoria:</label>
            <div class="col-sm-10">
              <select class="form-control" id="category" name="category">
                <option value='1'>Administracja</option>
                <option value='2'>Flota</option>
                <option value='3'>Kuchnia</option>
                <option value='4'>IT</option>
                <option value='5'>Media</option>
                <?php
                /*
                foreach ($data["cities"] as $city) {
                  $full_tag = $city["c_name"] . "_" . $city["wh_name"];
                  $full_name = $city["c_fullname"] . " -> " . $city["wh_fullname"];
                  $id = $city["id"];
                  echo "<option value='$id'>$full_tag : $full_name</option>";
                }*/
                ?>
              </select>
            </div>
          </div>


          <div class="form-group row m-3">
            <label for="method" class="col-sm-2 col-form-label">Metoda płatności:</label>
            <div class="col-sm-10">
            <select class="form-control" id="method" name="method">
                <option value='0'>-</option>
                <option value='1'>Gotówka</option>
                <option value='2'>Karta *1111</option>
                <option value='3'>Przelew</option>
              </select>
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="active" class="col-sm-2 col-form-label">Płatność aktywna:</label>
            <div class="col-sm-10">
              <input type="checkbox" class="form-check-input" id="active" name="active" value="1" checked>
            </div>
          </div>

          <div class="form-group row m-3">
            <label for="description" class="col-sm-2 col-form-label">Opis:</label>
            <div class="col-sm-10">
            <input type="textarea" class="form-control" id="description" name="description">
            </div>
          </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Dodaj koszt</button>
      </form>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const dateFields = document.querySelectorAll('.date-field');
            const singleDateField = document.querySelector('.single-date-field');
            const dateFrom = document.getElementById('date_from');
            const dateTo = document.getElementById('date_to');
            const singleDate = document.getElementById('single_date');

            typeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const typeValue = this.value;
                    if (typeValue >= 1 && typeValue <= 4) {
                        dateFields.forEach(field => {
                            field.style.display = 'flex';
                            field.querySelector('input').required = true;
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
                });
            });
        });
    </script>
    <?php require_once 'landings/footer.view.php' ?>