<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
        .tile {
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .tile:hover {
            background-color: #e9ecef;
        }
        .date {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-view-image {
            margin-top: 10px;
        }
        .modal-body img {
            width: 100%;
            height: auto;
        }

        .tile-yellow {
            background-color: yellow;
        }
        .tile-green {
            background-color: green;
        }
        .tile-lightgreen {
            background-color: lime;
        }
        .tile-red {
            background-color: red;
        }
        .tile-lightred {
            background-color: rosybrown;
        }
    </style>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container-fluid h-100 text-center" style="padding-top: 40px;">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Ostatnie ulotki</h2>
                    </div>
                    <div class="card-body">
                        <!-- Rząd z kafelkami poprzedniego tygodnia -->
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-center">Poprzedni tydzień</h4>
                            </div>
                            <?php
                            // Obliczanie poprzedniego tygodnia
                            $startOfCurrentWeek = strtotime('last Monday');
                            $startOfPreviousWeek = strtotime('-1 week', $startOfCurrentWeek);

                            for ($i = 0; $i < 7; $i++) {
                                $date = date('Y-m-d', strtotime("+$i days", $startOfPreviousWeek));
                                $color = "";
                                $imageSrc= "";
                                if($date > date("Y-m-d")) {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-lightgreen";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-yellow";
                                    }
                                } else if($date == date("Y-m-d")) {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-green";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-red";
                                    }
                                } else {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-lightgreen";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-lightred";
                                    }
                                }
                                
                                echo "<div class='col-lg tile $color'>
                                        <div class='date' data-toggle='modal' data-target='#uploadModal' data-date='$date'>$date</div>";
                                if($imageSrc <> "") {
                                    echo "<button class='btn btn-primary btn-view-image' data-toggle='modal' data-target='#imageModal' data-image='$imageSrc'>Pokaż menu</button>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>

                        <!-- Rząd z kafelkami bieżącego tygodnia -->
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-center">Aktualny tydzień</h4>
                            </div>
                            <?php
                            // Obliczanie bieżącego tygodnia
                            for ($i = 0; $i < 7; $i++) {
                                $date = date('Y-m-d', strtotime("+$i days", $startOfCurrentWeek));
                                $color = "";
                                $imageSrc= "";
                                if($date > date("Y-m-d")) {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-lightgreen";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-yellow";
                                    }
                                } else if($date == date("Y-m-d")) {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-green";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-red";
                                    }
                                } else {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-lightgreen";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-lightred";
                                    }
                                }
                                echo "<div class='col-lg tile $color'>
                                        <div class='date' data-toggle='modal' data-target='#uploadModal' data-date='$date'>$date</div>";
                                if($imageSrc <> "") {
                                    echo "<button class='btn btn-primary btn-view-image' data-toggle='modal' data-target='#imageModal' data-image='$imageSrc'>Pokaż menu</button>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>

                        <!-- Rząd z kafelkami następnego tygodnia -->
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-center">Następny tydzień</h4>
                            </div>
                            <?php
                            // Obliczanie następnego tygodnia
                            $startOfNextWeek = strtotime('+1 week', $startOfCurrentWeek);

                            for ($i = 0; $i < 7; $i++) {
                                $date = date('Y-m-d', strtotime("+$i days", $startOfNextWeek));
                                $color = "";
                                $imageSrc= "";
                                if($date > date("Y-m-d")) {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-lightgreen";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-yellow";
                                    }
                                } else if($date == date("Y-m-d")) {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-green";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-red";
                                    }
                                } else {
                                    if(isset($data["leaflet"][$date])) {
                                        $color = "tile-lightgreen";
                                        $imageSrc = IMG_ROOT. "/".$data["leaflet"][$date]->img_name;
                                    } else {
                                        $color = "tile-lightred";
                                    }
                                }
                                echo "<div class='col-lg tile $color'>
                                        <div class='date' data-toggle='modal' data-target='#uploadModal' data-date='$date'>$date</div>";
                                if($imageSrc <> "") {
                                    echo "<button class='btn btn-primary btn-view-image' data-toggle='modal' data-target='#imageModal' data-image='$imageSrc'>Pokaż menu</button>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="modal fade " id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog bg-white" role="document">
                <div class="modal-content bg-white">
                    <div class="modal-header bg-white">
                        <h5 class="modal-title" id="uploadModalLabel">Prześlij zdjęcie menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-white">
                        <form id="uploadForm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fileInput">Wybierz zdjęcie (JPG, PNG, JPEG)</label>
                                <input type="file" class="form-control-file" id="fileInput" name="fileInput" accept=".jpg, .jpeg, .png" required>
                            </div>
                            <input type="hidden" id="selectedDate" name="selectedDate" value="">
                            <button type="submit" class="btn btn-primary">Prześlij</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white">
                    <div class="modal-header bg-white">
                        <h5 class="modal-title" id="imageModalLabel">Podgląd zdjęcia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-white">
                        <img id="modalImage" src="" alt="Podgląd zdjęcia">
                    </div>
                </div>
            </div>
        </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Funkcja do przechwycenia kliknięcia kafelka i ustawienia daty w modalu
    $('#uploadModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Kafelek, który wywołał modal
        var date = button.data('date'); // Wyciągnięcie daty z atrybutu data-date
        var modal = $(this);
        modal.find('.modal-title').text('Prześlij zdjęcie menu dla ' + date); // Ustawienie daty w tytule modala
        modal.find('#selectedDate').val(date); // Ustawienie daty w ukrytym polu formularza
    });
</script>
<script>
    // Funkcja do przechwycenia kliknięcia przycisku i ustawienia źródła obrazka w modalu
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Przycisk, który wywołał modal
        var imageSrc = button.data('image'); // Wyciągnięcie ścieżki obrazka z atrybutu data-image
        var modal = $(this);
        modal.find('#modalImage').attr('src', imageSrc+"?v="+Math.floor(Date.now() / 1000)); // Ustawienie źródła obrazka w modalu
    });
</script>
        <?php require_once 'landings/footer.view.php' ?>