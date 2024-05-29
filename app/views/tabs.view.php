<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<style>
.tree-container {
    text-align: left;
}

 ul {
    list-style-type: none !important;
    padding-left: 20px;
    margin: 0;
}

.tree li {
    margin: 5px 0;
    position: relative;
}

.tree li::before {
    content: '';
    position: absolute;
    top: 10px;
    left: -15px;
    width: 10px;
    height: 1px;
    background: #ccc;
}

.tree li::after {
    content: '';
    position: absolute;
    top: -10px;
    left: -15px;
    width: 1px;
    height: 20px;
    background: #ccc;
}

.tree li:first-child::after {
    display: none;
}

.tree input[type="checkbox"] {
    margin-right: 5px;
}

.tree label {
    font-family: Arial, sans-serif;
    font-size: 14px;
    cursor: pointer;
}

.tree ul .tree ul::before {
    content: '';
    position: absolute;
    top: 10px;
    left: -20px;
    width: 10px;
    height: 1px;
    background: #ccc;
}

.tree ul .tree ul::after {
    content: '';
    position: absolute;
    top: -10px;
    left: -20px;
    width: 1px;
    height: 20px;
    background: #ccc;
}

.tree ul .tree ul .tree li {
    margin-left: 20px;
}
</style>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
  <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
    <?php
        if(isset($data["id_link"])) {
    ?>
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="">Dodaj zakładkę</h2>
        </div>
        <div class="form-group row m-3">
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

                <?php
                    $checked = "";
                    if(isset($data["link"])) {
                        $l_name = $data["link"][0]->l_name;
                        $l_directory = $data["link"][0]->l_directory;
                        $l_icon = $data["link"][0]->l_icon;
                        $l_order = $data["link"][0]->l_order;
                        if($data["link"][0]->l_active == 1) {
                            $checked = "checked";
                        } 
                    } else {
                        $l_name = "";
                        $l_directory = "";
                        $l_icon = "";
                        $l_order = "";
                        $l_active = "";
                    }
                ?>

                <div class="text-start">
                <div class="form-group row m-3">
                    <label for="l_name" class="col-sm-2 col-form-label">Nazwa</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="l_name" name="l_name" value="<?=$l_name?>" required>
                    </div>
                </div>
                <div class="form-group row m-3">
                    <label for="l_directory" class="col-sm-2 col-form-label">Opis:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="l_directory" name="l_directory" value="<?=$l_directory?>">
                    </div>
                </div>
                <div class="form-group row m-3">
                    <label for="l_icon" class="col-sm-2 col-form-label">Ikonka:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="l_icon" name="l_icon" value="<?=$l_icon?>">
                    </div>
                </div>
                <?php
                    if(!isset($data["id_link_edit"])) {
                ?>
                <div class="form-group row m-3">
                    <label for="l_type" class="col-sm-2 col-form-label">Subkategoria:</label>
                    <div class="col-sm-10">
                    <input type="checkbox" class="form-check-input" id="l_type" name="l_type" value="1">
                    </div>
                </div>
                <?php
                    }
                ?>
                <div class="form-group row m-3">
                    <label for="l_order" class="col-sm-2 col-form-label">Kolejność:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="l_order" name="l_order" value="<?=$l_order?>">
                    </div>
                </div>
                <div class="form-group row m-3">
                    <label for="l_active" class="col-sm-2 col-form-label">Aktywne:</label>
                    <div class="col-sm-10">
                    <input type="checkbox" class="form-check-input" id="l_active" name="l_active" value="1" <?=$checked?>>
                    </div>
                </div>
                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit" name="links" value="1">Zapisz</button>
            </form>
        </div>
    </div>
    <?php
        }
    ?>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="">Wszystkie zakładki</h2>
        </div>
        <div class="form-group row m-3">
            <div class="col-sm-12">
                <?php
                    echo '<div class="tree-container">';
                    echo generateTreeEditing($data["links"]);
                    echo '</div>';
        
?>
            </div>
        </div>
    </div>
    </main>
    <?php require_once 'landings/footer.view.php' ?>