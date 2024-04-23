
<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
        <div class="row">
        <div class="col-md-12" >
            <video style="max-height:200px" id="preview"></video>
        </div>
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
                <h1 class="h3 mb-3 fw-normal">Dane skanu:</h1>
                <div class="text-start">
                    <div class="form-group row m-3">
                    <label for="c_id" class="col-sm-2 col-form-label">Firma:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="c_id" name="c_id" onchange="companyChange()">
                            <?php
                                if(isset($_SESSION["selected_company"])) {
                                    $my_company = $_SESSION["selected_company"];
                                } else {
                                    $my_company = 0;
                                }
                            ?>
                                <option value='0' <?php if($my_company == 0) echo "selected"; ?>>Inna </option>
                                <?php
                                foreach ($data["companies"] as $company) {
                                    $full_name = $company->full_name . " | " . $company->address;
                                    $id = $company->id;
                                    if($my_company == $id) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='$id' $selected>$full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <script>
                        let arr = [];
                        let arrid = [];
                        let products = [];
                        <?php
                        foreach ($data["companies"] as $company) {
                            echo "arr[".$company->id."] = '".$company->address."';";
                            echo "arrid[".$company->id."] = '".$company->id."';";
                            //echo "arr.push({'".$company->id."' :'".$company->address."' });";
                        }
                        foreach ($data["products"] as $prod) {
                            echo "products['".$prod->sku."'] = ['name', '".$prod->p_name."'];";
                            echo "products['".$prod->sku."']['ean'] = '".$prod->ean."';";
                            echo "products['".$prod->sku."']['sku'] = '".$prod->sku."';";
                            echo "products['".$prod->sku."']['p_id'] = '".$prod->id."';";
                        }
                        ?>
function companyChange(){
    var x = document.getElementById("c_id").value;
    document.getElementById("c_fullname").value = arr[x];
    document.getElementById("c_fullname_id").value = arrid[x];
    console.log(x);
}
                        </script>
                    <div class="form-group row m-3">
                        <label for="c_fullname" class="col-sm-2 col-form-label">Adres:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_fullname" name="c_fullname" readonly value="<?php echo $_SESSION["selected_company_fullname"];?>">
                            <input hidden type="text" class="form-control" id="c_fullname_id" name="c_fullname_id" readonly value="<?php echo $_SESSION["selected_company"];?>">
                        </div>
                    </div>
                    <?php /*<div class="form-group row m-3">
                        <label for="c_id" class="col-sm-2 col-form-label">Handlowiec:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_id" name="c_id" readonly <?php echo "value = '" . $_SESSION["USER"]->first_name ." ".$_SESSION["USER"]->last_name . "'" ?>>
                        </div>
                    </div>*/?>
                    <div class="form-group row m-3">
                        <label for="c_fullname" class="col-sm-2 col-form-label">QR Code:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="text" name="text" readonly>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <table id="tab-show" style="display: none">
                            <tr><th>Nazwa</th><td> <input type="text" class="form-control" id="prod_name" name="prod_name" readonly value=""></tr>
                            <tr><th>EAN</th><td> <input type="text" class="form-control" id="prod_ean" name="prod_ean" readonly value=""></td></tr>
                            <tr><th>SKU</th><td> <input type="text" class="form-control" id="prod_sku" name="prod_sku" readonly value=""></td></tr>
                            <tr><th>ID</th><td> <input type="text" class="form-control" id="prod_p_id" name="prod_p_id" readonly value=""></td></tr>
                        </table>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" id="sendButton" type="submit">Dodaj skan</button>
            </form>
        <?php
        ?>
    </div>


        </main>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner=new Instascan.Scanner({video:document.getElementById('preview'), mirror: false});
        Instascan.Camera.getCameras().then(function(cameras){
            if(cameras.length>0) {
                //0 front
                //1 back
                scanner.start(cameras[2]); //dla telefonó 2 // 0 dla komputerów
            } else {
                alert("no camera Found");
            }
        }).catch(function(e){
            console.error(e);
        });
        //scan then qr code part
        scanner.addListener('scan',function(c){
            document.getElementById("tab-show").style.display="";
            document.getElementById("text").value=c;
            document.getElementById("prod_name").innerHTML=products[c]["1"];
            document.getElementById("prod_name").value=products[c]["1"];
            document.getElementById("prod_ean").innerHTML=products[c]["ean"];
            document.getElementById("prod_ean").value=products[c]["ean"];
            document.getElementById("prod_sku").innerHTML=products[c]["sku"];;
            document.getElementById("prod_sku").value=products[c]["sku"];
            document.getElementById("prod_p_id").innerHTML=products[c]["p_id"];
            document.getElementById("prod_p_id").value=products[c]["p_id"];

            let sendButton = document.getElementById("sendButton"); 
            sendButton.click();
        });
    </script>
        <?php require_once 'landings/footer.view.php' ?>
