<?php require_once 'landings/header.view.php' ?>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Logowanie</h3>
                </div>
                <div class="card-body">
                  <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                      <?= implode("<br>", $errors) ?>
                    </div>
                  <?php endif; ?>
                  <form method="post">
                    <div class="form-floating mb-3">
                      <input class="form-control" name="email" id="inputEmail" type="email"
                        placeholder="name@example.com" />
                      <label for="inputEmail">Adres e-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" name="password" id="inputPassword" type="password"
                        placeholder="Password" />
                      <label for="inputPassword">Hasło</label>
                    </div>
                    <?php /*<div class="form-check mb-3">
<input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
<label class="form-check-label" for="inputRememberPassword">Remember Password</label>
</div>*/ ?>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <?php /* jakiś form z mailem? <a class="small" href="password.html">Forgot Password?</a>*/ ?>
                      <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj się</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>

</html>