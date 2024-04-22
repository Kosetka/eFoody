<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="container h-100 text-center">
            <div class="container-fluid px-4">
                <ol class="breadcrumb mb-4">
                    <li class=""></li>
                </ol>
                <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista produktów/SKU</h2>
                    </div>
                    <div class="card-body">
                        <a type="button" class="btn btn-primary" href="<?= ROOT ?>/products/new">Dodaj nowy
                            produkt/SKU</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">Pełna nazwa</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">EAN</th>
                                    <th scope="col">Ilość</th>
                                    <th scope="col">Jednostka</th>
                                    <th scope="col">Typ produktu</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data) {
                                    echo "<tr><th colspan='8'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    foreach ($data["products"] as $product) {
                                        if (!empty($product->p_photo)) {
                                            $photo = "<img width='40' height='40' class='obrazek' id='imageBox$product->id' src='" . IMG_ROOT . "" . $product->p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        echo "  <tr>
                                                    <th scope='row'>$product->id</th>
                                                    <td>$product->sku</td>
                                                    <td>$photo</td>
                                                    <td>$product->p_name</td>
                                                    <td>$product->p_description</td>
                                                    <td>$product->ean</td>
                                                    <td>[Ilość]</td>
                                                    <td>$product->p_unit</td>
                                                    <td>" . PRODUCTTYPENAMES[$product->prod_type] . "</td>
                                                    <td><a class='btn btn-info' href=' " . ROOT . "/products/edit/$product->id'
                                                            role='button'>Edytuj</a></td>
                                                </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>




        </main>
        <?php require_once 'landings/footer.view.php' ?>