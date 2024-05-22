<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Lista kategorii SKU</h2>
                </div>
                <div class="card-body">

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
                                        echo "<td><a class='btn btn-info' href=' " . ROOT . "/sku/show/$value->id' role='button'>Pokaż listę</a></td>";
                                        //echo "<a class='btn btn-success' href=' " . ROOT . "/products/new/$value->full_type' role='button'>Dodaj</a></td>";
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