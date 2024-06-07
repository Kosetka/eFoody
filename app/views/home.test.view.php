<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="" style="max-width: 100%; padding: 20px; ">
            <div class="alert alert-info text-center alert-dismissible"> <!-- danger, info, warning, success-->
                <h2>Ogłoszenie!</h2>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span>Testowa treść ogłoszenia</span>
            </div>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                                <div class="card-body">
                                    <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h5>Alert!</h5>Treść alertu
                                    </div>
                                    <div class="alert alert-info alert-dismissible">
                                        <h5>Alert!</h5>Info alert preview. This alert is dismissable.
                                    </div>
                                    <div class="alert alert-warning alert-dismissible">
                                        <h5>Alert!</h5> Warning alert preview. This alert is dismissable.
                                    </div>
                                    <div class="alert alert-success alert-dismissible">
                                        <h5>Alert!</h5>Success alert preview. This alert is dismissable.
                                    </div>
                                </div>
                        </div>
                    </div>
                    
       


                    <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Podsumowanie produkcji</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>Sprzedaż: 1 Jan, 2014 - 30 Jul, 2014</strong>
                        </p>
                        <div class="chart">
                            <canvas id="salesChart"></canvas>
                        </div>
                        <button id="dayView" class="btn btn-primary mt-3">Day View (Last 14 Days)</button>
                        <button id="weekView" class="btn btn-secondary mt-3">Week View (Last 5 Weeks)</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


    
<?php
show($data["producted_last14days"]);
?>

            </div>
        </div>
    </main>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const ctx = document.getElementById('salesChart').getContext('2d');

        <?php
            $temp_days = "[";
            foreach($data["producted_last14days"] as $d) {
                $temp_days .= '"'.$d->date_producted.'",';
            }
            $temp_days .= "]";
            echo "const dayLabels = ".$temp_days.";";
        ?>
        

        const weekLabels = Array.from({ length: 5 }, (v, i) => {
            const date = new Date();
            date.setDate(date.getDate() - (i * 7));
            return `Week ${date.toISOString().split('T')[0]}`;
        }).reverse();

        //const dayData = Array.from({ length: 14 }, () => Math.floor(Math.random() * 100));
        <?php
            $temp = "[";
            foreach($data["producted_last14days"] as $d) {
                $temp .= '"'.$d->total_amount.'",';
            }
            $temp .= "]";
            echo "const dayData = ".$temp.";";
        ?>
        const weekData = Array.from({ length: 5 }, () => Math.floor(Math.random() * 100));
        console.log(dayData);

        const dataConfig = {
            labels: dayLabels,
            datasets: [{
                label: 'Wyprodukowane',
                data: dayData,
                backgroundColor: 'rgba(60,141,188,0.2)',
                borderColor: 'rgba(60,141,188,1)',
                borderWidth: 1,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: false,
                tension: 0.1
            }]
        };

        const config = {
            type: 'line',
            data: dataConfig,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.raw;
                                const date = context.label;
                                return `${label}: ${value} on ${date}`;
                            }
                        }
                    }
                }
            }
        };

        const myChart = new Chart(ctx, config);

        document.getElementById('dayView').addEventListener('click', () => {
            myChart.data.labels = dayLabels;
            myChart.data.datasets[0].data = dayData;
            myChart.update();
        });

        document.getElementById('weekView').addEventListener('click', () => {
            myChart.data.labels = weekLabels;
            myChart.data.datasets[0].data = weekData;
            myChart.update();
        });
    });
</script>
        <!-- jQuery -->
    <script src="<?= ROOT ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= ROOT ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= ROOT ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= ROOT ?>/assets/js/adminlte.js"></script>
<?php require_once 'landings/footer.view.php' ?>