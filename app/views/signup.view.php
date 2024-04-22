<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
      <form method="post">

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

        <h1 class="h3 mb-3 fw-normal">Zakładanie konta</h1>

        <div class="text-start">
          <div class="form-group row m-3">
            <label for="Email" class="col-sm-2 col-form-label">Adres e-mail:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email">
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="password" class="col-sm-2 col-form-label">Hasło:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="first_name" class="col-sm-2 col-form-label">Imię:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="first_name" name="first_name">
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="last_name" class="col-sm-2 col-form-label">Nazwisko:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="last_name" name="last_name">
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="active" class="col-sm-2 col-form-label">Konto aktywne:</label>
            <div class="col-sm-10">
              <input type="checkbox" class="form-check-input" id="active" name="active" value="1" checked>
            </div>
          </div>
          <div class="form-group row m-3">
            <label class="col-sm-2 col-form-label" for="u_warehouse">Wybierz magazyn:</label>
            <div class="col-sm-10">
              <select class="form-control" id="u_warehouse" name="u_warehouse">
                <?php
                foreach ($data["cities"] as $city) {
                  $full_tag = $city["c_name"] . "_" . $city["wh_name"];
                  $full_name = $city["c_fullname"] . " -> " . $city["wh_fullname"];
                  $id = $city["id"];
                  echo "<option value='$id'>$full_tag : $full_name</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group row m-3">
            <legend class="col-sm-2 col-form-label ">Uprawnienia:</legend>
            <div class="col-sm-10">
              <?php
              foreach ($roles as $role) {
                $id = $role["id"];
                $role_name = $role["role_name"];
                $role_description = $role["role_description"];
                $r_active = $role["r_active"];
                $checked = "";
                $active = "";
                if ($id === 1) {
                  $checked = "checked";
                }
                if ($r_active === 0) {
                  $active = "disabled";
                }
                echo "<div class='form-check'>
                <input class='form-check-input' type='radio' name='u_role' id='u_role$id' value='$id' $checked $active>
                <label class='form-check-label' for='u_role$id'>
                  $role_name
                </label>
              </div>";
              }
              ?>
            </div>
          </div>


          <div class="form-group row m-3">
            <label for="terms" class="col-sm-3 col-form-label">Akceptuję regulamin:</label>
            <div class="col-sm-9">
              <input type="checkbox" class="form-check-input" id="terms" name="terms" value="1" checked>
            </div>
          </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Załóż konto</button>
      </form>

    </main>
    <?php require_once 'landings/footer.view.php' ?>