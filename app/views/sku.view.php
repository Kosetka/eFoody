<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <h1 class="h3 mb-3 fw-normal">Lista kategorii SKU</h1>
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nazwa</th>
                                        <th scope="col">Pełne SKU</th>
                                        <th scope="col">Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($data["sku"] as $key => $value) {
                                        echo "  <tr>
                                            <td>$value->name</td>
                                            <td>$value->full_type</td>";
                                        if(strlen($value->full_type) > 1) {
                                            echo "<td><a href='".ROOT."/sku/show/".$value->id."'>Lista</a> ";
                                            echo "<a href='".ROOT."/sku/show/".$value->id."'>Dodaj</a></td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        echo "</tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>