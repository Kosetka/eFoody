<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; eFoody 2024</div>
            <div>
                <a href="#"></a>
                &middot;
                <a href="#"></a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
<script src="<?= ROOT ?>/assets/js/scripts.js"></script>
<script src="<?= ROOT ?>/assets/js/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= ROOT ?>/assets/demo/chart-area-demo.js"></script>
<script src="<?= ROOT ?>/assets/demo/chart-bar-demo.js"></script>
<script src="<?= ROOT ?>/assets/js/datatables-simple-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script>
    // Get the gallery box
    /*function showModal(id) {
        var imageBox1 = document.getElementById("imageBox" + id);

        // Get the modal image tag
        var modal = document.getElementById("myModal");

        var modalImage = document.getElementById("modal-image");

        // When the user clicks the big picture, set the image and open the modal
        imageBox1.onclick = function (e) {
            var src = e.srcElement.src;
            modal.style.display = "block";
            modalImage.src = src;
        };
    }*/
    // Pobranie wszystkich obrazków
    var obrazki = document.querySelectorAll('.obrazek');
    // Pobranie modala
    var modal = document.getElementById('modal');
    // Pobranie obrazka wewnątrz modala
    var modalImage = document.getElementById('modal-image');
    // Pobranie przycisku zamknięcia
    var closeBtn = document.querySelector('.close');

    // Przypisanie obsługi zdarzenia kliknięcia do każdego obrazka
    obrazki.forEach(function (obrazek) {
        obrazek.addEventListener('click', function () {
            // Wyświetlenie modala
            modal.style.display = 'block';
            // Ustawienie src obrazka w modalu na kliknięty obrazek
            modalImage.src = this.src;
        });
    });

    // Obsługa zdarzenia kliknięcia przycisku zamknięcia
    closeBtn.addEventListener('click', function () {
        // Ukrycie modala
        modal.style.display = 'none';
    });

    // Obsługa zdarzenia kliknięcia poza modalem (aby zamknąć modal)
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

</script>


<script>
            $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


<link href="<?= ROOT ?>/assets/css/select2.css" rel="stylesheet"/>
<script src="<?= ROOT ?>/assets/js/select2.js"></script>
<script>
    $(document).ready(function() { $("#c_id").select2(); });
</script>


</body>

</html>