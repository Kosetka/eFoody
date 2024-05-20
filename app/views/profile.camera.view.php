<?php require_once 'landings/header.view.php' ?>
<style>


.form-check-input {
    position: absolute;
    top: 40%;
    transform: translate(-50%, -50%);
    z-index: 1;
}

.form-check-label {
    display: inline-block;
    position: relative;
}
</style>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
  <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
      <form method="post">
        <h1 class="h3 mb-3 fw-normal">Wybór kamery</h1>
        <div class="form-group row m-3">
            <?php
            $cam = $_SESSION["USER"]->camera;
            ?>
            <legend class="col-sm-2 col-form-label ">Kamery:</legend>
            <div class="col-sm-10">
                <div class='form-check'>
                        <?php
                            $selected = "";
                            if($cam == 0) $selected = "checked";
                        ?>
                    <input class='form-check-input' type='radio' name='camera' id='camera0' value='0' <?=$selected?>>
                    <label class='form-check-label' for='camera0'>
                    <video style="max-height:200px; background-color: lightgrey;box-shadow: 0px 8px 20px 8px rgba(66, 68, 90, 1); margin-bottom: 30px;" id="preview0"></video>
                    </label>
                </div>
                <div class='form-check'>
                        <?php
                            $selected = "";
                            if($cam == 1) $selected = "checked";
                        ?>
                    <input class='form-check-input' type='radio' name='camera' id='camera1' value='1' <?=$selected?>>
                    <label class='form-check-label' for='camera1'>
                    <video style="max-height:200px; background-color: lightgrey;box-shadow: 0px 8px 20px 8px rgba(66, 68, 90, 1); margin-bottom: 30px;" id="preview1"></video>
                    </label>
                </div>
                <div class='form-check'>
                        <?php
                            $selected = "";
                            if($cam == 2) $selected = "checked";
                        ?>
                    <input class='form-check-input' type='radio' name='camera' id='camera2' value='2' <?=$selected?>>
                    <label class='form-check-label' for='camera2'>
                    <video style="max-height:200px; background-color: lightgrey;box-shadow: 0px 8px 20px 8px rgba(66, 68, 90, 1); margin-bottom: 30px;" id="preview2"></video>
                    </label>
                </div>
                <div class='form-check'>
                        <?php
                            $selected = "";
                            if($cam == 3) $selected = "checked";
                        ?>
                    <input class='form-check-input' type='radio' name='camera' id='camera3' value='3'<?=$selected?>>
                    <label class='form-check-label' for='camera3'>
                    <video style="max-height:200px; background-color: lightgrey;box-shadow: 0px 8px 20px 8px rgba(66, 68, 90, 1); margin-bottom: 30px;" id="preview3"></video>
                    </label>
                </div>
                <div class='form-check'>
                        <?php
                            $selected = "";
                            if($cam == 4) $selected = "checked";
                        ?>
                    <input class='form-check-input' type='radio' name='camera' id='camera4' value='4' <?=$selected?>>
                    <label class='form-check-label' for='camera4'>
                    <video style="max-height:200px; background-color: lightgrey;box-shadow: 0px 8px 20px 8px rgba(66, 68, 90, 1); margin-bottom: 30px;" id="preview4"></video>
                    </label>
                </div>
            </div>
          </div>

          <button class="w-100 btn btn-lg btn-primary" type="submit">Zapisz</button>

        <script type="text/javascript">
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    console.log(cameras);
                    //0 front
                    //1 back
                    let scanner0 = new Instascan.Scanner({ video: document.getElementById('preview0'), mirror: false });
                    let scanner1 = new Instascan.Scanner({ video: document.getElementById('preview1'), mirror: false });
                    let scanner2 = new Instascan.Scanner({ video: document.getElementById('preview2'), mirror: false });
                    let scanner3 = new Instascan.Scanner({ video: document.getElementById('preview3'), mirror: false });
                    let scanner4 = new Instascan.Scanner({ video: document.getElementById('preview4'), mirror: false });
                    scanner0.start(cameras[0]); //dla telefonów 2 // 0 dla komputerów //2 firmowe
                    scanner1.start(cameras[1]); //dla telefonów 2 // 0 dla komputerów //2 firmowe
                    scanner2.start(cameras[2]); //dla telefonów 2 // 0 dla komputerów //2 firmowe
                    scanner3.start(cameras[3]); //dla telefonów 2 // 0 dla komputerów //2 firmowe
                    scanner4.start(cameras[4]); //dla telefonów 2 // 0 dla komputerów //2 firmowe
                } else {
                    alert("no camera Found");
                }
            }).catch(function (e) {
                console.error(e);
            });
        </script>
      </form>

    </main>
    <?php require_once 'landings/footer.view.php' ?>