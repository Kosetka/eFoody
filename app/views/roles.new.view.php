<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
      <form method="post">
        <?php
        //show($data);
        ?>
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

        <h1 class="h1 mb-3 fw-normal">Dodawanie nowej roli</h1>

        <div class="text-start">
          <div class="form-group row m-3">
            <label for="role_name" class="col-sm-2 col-form-label">Nazwa</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="role_name" name="role_name" required>
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="role_description" class="col-sm-2 col-form-label">Opis:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="role_description" name="role_description">
            </div>
          </div>
          <div class="form-group row m-3">
            <label for="r_active" class="col-sm-2 col-form-label">Rola aktywna:</label>
            <div class="col-sm-10">
              <input type="checkbox" class="form-check-input" id="r_active" name="r_active" value="1" checked>
            </div>
          </div>
        </div>
        <button class="w-40 btn btn-lg btn-primary" type="submit">Dodaj rolę</button>
      </form>

    </main>
    <?php require_once 'landings/footer.view.php' ?>