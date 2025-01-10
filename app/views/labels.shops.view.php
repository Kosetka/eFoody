<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
    th:nth-child(2n+6), 
    td:nth-child(2n+6),
    tr:nth-child(1) th {
        background-color: #f0f0f0;
    }
    tr:hover {
        background-color: #f0f0f0;
    }
</style>
<?php
    //show($data["planned"]);
?>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Wybierz datę do wygenerowania Dowodów Dostaw</h2>
                    <div class="form-group row m-3">
                        <div class="col-sm-12" style='display: flex'>
                            <label for="date" class="col-sm-2 col-form-label">Dzień:</label>
                            <input type='date' id='date' class='form-control col-sm-2' name='date' value='<?php echo $date; ?>'>
                            <button class='btn btn-primary' style='margin-left: 20px;' type='button' onclick="redirectToDate()">Pokaż</button>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </main>
        <script>
            function redirectToDate() {
                const date = document.getElementById('date').value; // Pobierz wartość daty
                if (date) {
                    window.location.href = `<?php echo ROOT."/labels/shopswz/";?>${date}`; // Przekierowanie na odpowiedni URL
                } else {
                    alert('Proszę wybrać datę.'); // Jeśli nie wybrano daty
                }
            }
        </script>

        <?php require_once 'landings/footer.view.php' ?>