<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
        <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
            <form method="post" enctype="multipart/form-data">
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

                <?php
                    //show($data);
                    //die;
                ?>

                <h1 class="h3 mb-3 fw-normal">Edycja produktu/SKU</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="sku" class="col-sm-2 col-form-label">SKU:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sku" name="sku" <?php echo "value = " . $data['product']->sku; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_name" class="col-sm-2 col-form-label">Pełna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_name" name="p_name" <?php echo "value = '" . $data['product']->p_name . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="friendly_name" class="col-sm-2 col-form-label">Przyjazna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="friendly_name" name="friendly_name" <?php echo "value = '" . $data['product']->friendly_name . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="vege" class="col-sm-2 col-form-label">VEGE:</label>
                        <div class="col-sm-10">
                            <?php
                            if($data['product']->vege == TRUE) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }

                            ?>
                            <input type="checkbox" class="form-check-input" id="vege" name="vege" value="0" <?=$checked;?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <legend class="col-sm-2 col-form-label ">Data ważności do:</legend>
                        <div class="col-sm-10">
                            <div class='form-check'>
                            <?php
                                if($data['product']->show_prod_date == 0 || $data['product']->show_prod_date == NULL) {
                                    $checked = " checked";
                                } else {
                                    $checked = "";
                                }
                            ?>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date0' value='0' <?=$checked;?>>
                                <label class='form-check-label' for='show_prod_date0'>Nie pokazuj</label>
                            </div>
                            <div class='form-check'>
                            <?php
                                if($data['product']->show_prod_date == 1) {
                                    $checked = " checked";
                                } else {
                                    $checked = "";
                                }
                            ?>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date1' value='1' <?=$checked;?>>
                                <label class='form-check-label' for='show_prod_date1'>1 dzień</label>
                            </div>
                            <div class='form-check'>
                            <?php
                                if($data['product']->show_prod_date == 2) {
                                    $checked = " checked";
                                } else {
                                    $checked = "";
                                }
                            ?>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date2' value='2' <?=$checked;?>>
                                <label class='form-check-label' for='show_prod_date2'>2 dni</label>
                            </div>
                            <div class='form-check'>
                            <?php
                                if($data['product']->show_prod_date == 3) {
                                    $checked = " checked";
                                } else {
                                    $checked = "";
                                }
                            ?>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date3' value='3' <?=$checked;?>>
                                <label class='form-check-label' for='show_prod_date3'>3 dni</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row m-3" hidden>
                        <label for="p_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_description" name="p_description" <?php echo "value = '" . $data['product']->p_description . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3" hidden>
                        <label for="ean" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ean" name="ean" <?php echo "value = " . $data['product']->ean; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="kcal" class="col-sm-2 col-form-label">Kalorie:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" class="form-control" id="kcal" name="kcal" <?php echo "value = " . $data['product']->kcal; ?>>
                        </div>
                    </div>
                    <?php /*<div class="form-group row m-3">
                        <label for="labels" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-10">
                            <a href="<?php echo ROOT."/assets/labels/wzor.lbx";?>" media="print">Etykieta</a>
                            <input type="text" class="form-control" id="labels" name="labels" <?php echo "value = " . $data['product']->labels; ?>>
                        </div>
                    </div>*/?>
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="p_unit">Jednostka:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="p_unit" name="p_unit">
                                <?php
                                $p_unit = $data['product']->p_unit;
                                ?>
                                <option value='Szt.' <?php if ($p_unit == 'Szt.')
                                    echo "selected"; ?>>Sztuka</option>
                                <option value='l' <?php if ($p_unit == 'l')
                                    echo "selected"; ?>>Litr</option>
                                <option value='kg' <?php if ($p_unit == 'kg')
                                    echo "selected"; ?>>Kilogram</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_photo" class="col-sm-2 col-form-label">Zdjęcie:</label>
                        <div class="col-sm-10">
                            <?php /*<input type="text" class="form-control" id="p_photo" name="p_photo" <?php echo "value = '" . $data['product']->p_photo . "'"; ?>>*/ ?>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="prod_type" class="col-sm-2 col-form-label">Typ produktu:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="prod_type" name="prod_type">
                                <?php
                                $prod_type = $data['product']->prod_type;
                                foreach (PRODUCTTYPENAMES as $key => $value) {
                                    if ($prod_type == $key)
                                        echo "<option value='$key' selected>$value</option>";
                                    else
                                        echo "<option value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php 
                    if($data['product']->prod_type == 1 || $data['product']->prod_type == 0) { ?>
                    <div class="form-group row m-3">
                        <label for="alergens" class="col-sm-2 col-form-label">Alergeny:</label>
                        <div class="col-sm-10">
                            <?php
                                foreach($data["alergens"] as $alergen) {
                                    $checked = "";
                                    if(!empty($data["p_alergen"]) ) {
                                        foreach($data["p_alergen"] as $a) {
                                            if ($a->a_id == $alergen->id) {
                                                $checked = "checked";
                                            }
                                        }
                                    }
                                    if (!empty($alergen->a_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' id='imageBox$alergen->id' src='" . IMG_ALERGENS_ROOT . "" . $alergen->a_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    echo '<input style="margin-top: 15px;" type="checkbox" class="form-check-input" id="alergens'.$alergen->id.'" name="alergens['.$alergen->id.']" value="1" '.$checked.'>['.$alergen->id.'] '. $photo .' '. $alergen->a_name.'</input></br>';
                                }
                            ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Zapisz zmiany</button>
            </form>


            <?php

function generateAIContent($apiKey, $prompt) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}";

    $postData = json_encode([
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ],
        "generationConfig" => [
            "temperature" => 0.9,
            "topK" => 1,
            "topP" => 1,
            "maxOutputTokens" => 2000,
            "stopSequences" => []
        ],
        "safetySettings" => [
            [
                "category" => "HARM_CATEGORY_HARASSMENT",
                "threshold" => "BLOCK_ONLY_HIGH"
            ],
            [
                "category" => "HARM_CATEGORY_HATE_SPEECH",
                "threshold" => "BLOCK_ONLY_HIGH"
            ],
            [
                "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                "threshold" => "BLOCK_ONLY_HIGH"
            ],
            [
                "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
                "threshold" => "BLOCK_ONLY_HIGH"
            ]
        ]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        return $responseData['candidates'][0]['content']['parts'][0]['text'];
    } else {
        return show($responseData);
    }
}

$apiKey = "";
$prompt = "Jaki dzisiaj jest dzień tygodnia?";

//$generatedText = generateAIContent($apiKey, $prompt);
//echo $generatedText;

?>










        </main>
        <?php require_once 'landings/footer.view.php' ?>