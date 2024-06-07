<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard v2</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Przygotowane produkty</span>
                  <span class="info-box-number">
                    <?php
                    $today = isset($data["created"]["today"]) ? $data["created"]["today"] : 0;
                    $yesterday = isset($data["created"]["yesterday"]) ? $data["created"]["yesterday"] : 0;
                    if ($yesterday == $today) {
                      $diff = "0";
                    } else if ($today == 0) {
                      $diff = "100";
                    } else if ($yesterday == 0) {
                      $diff = "100";
                    } else {
                      $diff = $today / $yesterday * 100 - 100;
                    }

                    echo $today;
                    if ($today > $yesterday) {
                      echo " <small><span class='description-percentage text-success'><i class='fas fa-caret-up'></i>$diff%</span></small>";
                    } else if ($today < $yesterday) {
                      $diff = 100 - $diff;
                      echo " <small><span class='description-percentage text-danger'><i class='fas fa-caret-down'></i>$diff%</span></small>";
                    } else {
                      echo " <small><span class='description-percentage text-warning'><i class='fas fa-caret-left'></i>$diff%</span></small>";
                    }
                    echo " (" . $yesterday . ")";
                    ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only <div class="clearfix hidden-md-up"></div>-->

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Sprzedane produkty</span>
                  <span class="info-box-number">
                    <?php
                    $today = isset($data["sold"]["today"]) ? $data["sold"]["today"] : 0;
                    $yesterday = isset($data["sold"]["yesterday"]) ? $data["sold"]["yesterday"] : 0;
                    if ($yesterday == $today) {
                      $diff = "0";
                    } else if ($today == 0) {
                      $diff = "100";
                    } else if ($yesterday == 0) {
                      $diff = "100";
                    } else {
                      $diff = $today / $yesterday * 100 - 100;
                    }

                    echo $today;
                    if ($today > $yesterday) {
                      echo " <small><span class='description-percentage text-success'><i class='fas fa-caret-up'></i>$diff%</span></small>";
                    } else if ($today < $yesterday) {
                      $diff = 100 - $diff;
                      echo " <small><span class='description-percentage text-danger'><i class='fas fa-caret-down'></i>$diff%</span></small>";
                    } else {
                      echo " <small><span class='description-percentage text-warning'><i class='fas fa-caret-left'></i>$diff%</span></small>";
                    }

                    echo " (" . $yesterday . ")";
                    ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Odwiedzone firmy</span>
                  <span class="info-box-number">
                    <?php
                    $today = isset($data["companies"]["today"]) ? $data["companies"]["today"] : 0;
                    $yesterday = isset($data["companies"]["yesterday"]) ? $data["companies"]["yesterday"] : 0;
                    if ($yesterday == $today) {
                      $diff = "0";
                    } else if ($today == 0) {
                      $diff = "100";
                    } else if ($yesterday == 0) {
                      $diff = "100";
                    } else {
                      $diff = $today / $yesterday * 100 - 100;
                    }

                    echo $today;
                    if ($today > $yesterday) {
                      echo " <small><span class='description-percentage text-success'><i class='fas fa-caret-up'></i>$diff%</span></small>";
                    } else if ($today < $yesterday) {
                      $diff = 100 - $diff;
                      echo " <small><span class='description-percentage text-danger'><i class='fas fa-caret-down'></i>$diff%</span></small>";
                    } else {
                      echo " <small><span class='description-percentage text-warning'><i class='fas fa-caret-left'></i>$diff%</span></small>";
                    }
                    echo " (" . $yesterday . ")";
                    ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Nowe firmy</span>
                  <span class="info-box-number">
                    <?php
                    $today = isset($data["companies_added"]["today"]) ? $data["companies_added"]["today"] : 0;
                    $yesterday = isset($data["companies_added"]["yesterday"]) ? $data["companies_added"]["yesterday"] : 0;
                    if ($yesterday == $today) {
                      $diff = "0";
                    } else if ($today == 0) {
                      $diff = "100";
                    } else if ($yesterday == 0) {
                      $diff = "100";
                    } else {
                      $diff = $today / $yesterday * 100 - 100;
                    }

                    echo $today;
                    if ($today > $yesterday) {
                      echo " <small><span class='description-percentage text-success'><i class='fas fa-caret-up'></i>$diff%</span></small>";
                    } else if ($today < $yesterday) {
                      $diff = 100 - $diff;
                      echo " <small><span class='description-percentage text-danger'><i class='fas fa-caret-down'></i>$diff%</span></small>";
                    } else {
                      echo " <small><span class='description-percentage text-warning'><i class='fas fa-caret-left'></i>$diff%</span></small>";
                    }
                    echo " (" . $yesterday . ")";
                    ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Podsumowanie tygodniowe sprzedaży</h5>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <?php /*<div class="btn-group">
<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
<i class="fas fa-wrench"></i>
</button>
<div class="dropdown-menu dropdown-menu-right" role="menu">
<a href="#" class="dropdown-item">Action</a>
<a href="#" class="dropdown-item">Another action</a>
<a href="#" class="dropdown-item">Something else here</a>
<a class="dropdown-divider"></a>
<a href="#" class="dropdown-item">Separated link</a>
</div>
</div>*/ ?>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
                        <strong>Sprzedaż: 1 Jan, 2014 - 30 Jul, 2014</strong>
                      </p>

                      <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                      </div>
                      <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Cele kwartalne Q2-2024</strong>
                      </p>

                      <div class="progress-group">
                        Nowe firmy
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->

                      <div class="progress-group">
                        Średnia dziennie sprzedanych produktów
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-success" style="width: 75%"></div>
                        </div>
                      </div>

                      <!-- /.progress-group -->
                      <div class="progress-group">
                        <span class="progress-text">Średnia zwrotów <20 </span>
                            <span class="float-right"><b>30</b>/20</span>
                            <div class="progress progress-sm">
                              <div class="progress-bar bg-danger" style="width: 150%"></div>
                            </div>
                      </div>

                      <!-- /.progress-group -->
                      <div class="progress-group">
                        Nowe miasta
                        <span class="float-right"><b>1</b>/2</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">PRZYGOTOWANE PRODUKTY</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">1000</h5>
                        <span class="description-text">SPRZEDANE PRODUKTY</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">200</h5>
                        <span class="description-text">ZWROTY</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                      <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">500</h5>
                        <span class="description-text">ODWIEDZONE FIRMY</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
              <!-- MAP & BOX PANE -->
              <!-- /.card -->
              <div class="row">
                <div class="col-md-12">
                  <!-- USERS LIST -->
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Nowe firmy w tym tygodniu</h3>

                      <div class="card-tools">
                        <span class="badge badge-danger">8 Nowych</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <ul class="users-list clearfix">
                        <li>
                          <?php /*<img src="assets/img/user1-128x128.jpg" alt="User Image">*/ ?>
                          <a href="#">Firma 1</a>
                          <span class="users-list-name">Adres pełny firmy 1 26-600 Radom</span>
                          <span class="users-list-date">Dzisiaj</span>
                        </li>
                        <li>
                          <?php /*<img src="assets/img/user1-128x128.jpg" alt="User Image">*/ ?>
                          <a href="#">Firma 1</a>
                          <span class="users-list-name">Adres pełny firmy 1 26-600 Radom</span>
                          <span class="users-list-date">Dzisiaj</span>
                        </li>
                        <li>
                          <?php /*<img src="assets/img/user1-128x128.jpg" alt="User Image">*/ ?>
                          <a href="#">Firma 1</a>
                          <span class="users-list-name">Adres pełny firmy 1 26-600 Radom</span>
                          <span class="users-list-date">Dzisiaj</span>
                        </li>
                        <li>
                          <?php /*<img src="assets/img/user1-128x128.jpg" alt="User Image">*/ ?>
                          <a href="#">Firma 1</a>
                          <span class="users-list-name">Adres pełny firmy 1 26-600 Radom</span>
                          <span class="users-list-date">Dzisiaj</span>
                        </li>
                        <li>
                          <?php /*<img src="assets/img/user1-128x128.jpg" alt="User Image">*/ ?>
                          <a href="#">Firma 1</a>
                          <span class="users-list-name">Adres pełny firmy 1 26-600 Radom</span>
                          <span class="users-list-date">Dzisiaj</span>
                        </li>
                        <li>
                          <?php /*<img src="assets/img/user1-128x128.jpg" alt="User Image">*/ ?>
                          <a href="#">Firma 1</a>
                          <span class="users-list-name">Adres pełny firmy 1 26-600 Radom</span>
                          <span class="users-list-date">Dzisiaj</span>
                        </li>
                      </ul>
                      <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                      <a href="<?php echo ROOT . '/company'; ?>">Zobacz wszystkie firmy</a>
                    </div>
                    <!-- /.card-footer -->
                  </div>
                  <!--/.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Ostatnie sprzedaże</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th>Handlowiec</th>
                          <th>Firma</th>
                          <th>Produkty</th>
                          <th>Ilość</th>
                          <th>Data</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="pages/examples/invoice.html">Handlowiec</a></td>
                          <td>Firma 1</td>
                          <td>
                            <table>
                              <tr>
                                <td>zdjęcie</td>
                                <td>nazwa</td>
                              </tr>
                              <tr>
                                <td>zdjęcie</td>
                                <td>nazwa</td>
                              </tr>
                              <tr>
                                <td>zdjęcie</td>
                                <td>nazwa</td>
                              </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                              <tr>
                                <td>2 Szt.</td>
                              </tr>
                              <tr>
                                <td>4 Szt.</td>
                              </tr>
                              <tr>
                                <td>7 Szt.</td>
                              </tr>
                            </table>
                          </td>
                          <td>2024-04-20 12:23:12</td>
                        </tr>
                        <tr>
                          <td><a href="pages/examples/invoice.html">Handlowiec</a></td>
                          <td>Firma 1</td>
                          <td>
                            <table>
                              <tr>
                                <td>zdjęcie</td>
                                <td>nazwa</td>
                              </tr>
                              <tr>
                                <td>zdjęcie</td>
                                <td>nazwa</td>
                              </tr>
                              <tr>
                                <td>zdjęcie</td>
                                <td>nazwa</td>
                              </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                              <tr>
                                <td>2 Szt.</td>
                              </tr>
                              <tr>
                                <td>4 Szt.</td>
                              </tr>
                              <tr>
                                <td>7 Szt.</td>
                              </tr>
                            </table>
                          </td>
                          <td>2024-04-20 12:23:12</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <a href="<?php echo ROOT . '/sale'; ?>" class="btn btn-sm btn-secondary float-right">Zobacz
                    wszystkie</a>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">
              <!-- Info Boxes Style 2 -->
              <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Receptury</span>
                  <span class="info-box-number">15</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="far fa-heart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Firmy</span>
                  <span class="info-box-number">200</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Miasta w których jesteśmy</span>
                  <span class="info-box-number">2</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->

              <!-- /.info-box -->

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Najczęściej kupowane</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="chart-responsive">
                        <canvas id="pieChart" height="150"></canvas>
                      </div>
                      <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                      <ul class="chart-legend clearfix">
                        <li><i class="far fa-circle text-danger"></i> Produkt 1</li>
                        <li><i class="far fa-circle text-success"></i> Produkt 2</li>
                        <li><i class="far fa-circle text-warning"></i> Produkt 3</li>
                        <li><i class="far fa-circle text-info"></i> Produkt 4</li>
                        <li><i class="far fa-circle text-primary"></i> Produkt 5</li>
                        <li><i class="far fa-circle text-secondary"></i> Produkt 6</li>
                      </ul>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer p-0">
                  <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Produkt 1
                        <span class="float-right text-danger">
                          <i class="fas fa-arrow-down text-sm"></i>
                          12%</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Produkt 2
                        <span class="float-right text-success">
                          <i class="fas fa-arrow-up text-sm"></i> 4%
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Produkt 3
                        <span class="float-right text-warning">
                          <i class="fas fa-arrow-left text-sm"></i> 0%
                        </span>
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- /.footer -->
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>


    </main>

    <!-- jQuery -->
    <script src="<?= ROOT ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= ROOT ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= ROOT ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= ROOT ?>/assets/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="<?= ROOT ?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="<?= ROOT ?>/plugins/raphael/raphael.min.js"></script>
    <script src="<?= ROOT ?>/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="<?= ROOT ?>/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= ROOT ?>/plugins/chart.js/Chart.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?= ROOT ?>/assets/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= ROOT ?>/assets/js/pages/dashboard2.js"></script>
    <?php require_once 'landings/footer.view.php' ?>