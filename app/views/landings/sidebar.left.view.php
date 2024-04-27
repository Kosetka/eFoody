<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Użytkownicy</div>
                <a class="nav-link" href="<?= ROOT ?>/users">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Lista pracowników
                </a>
                <a class="nav-link" href="<?= ROOT ?>/signup">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dodaj pracownika
                </a>

                <div class="sb-sidenav-menu-heading">Baza firm</div>
                <a class="nav-link" href="<?= ROOT ?>/company">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Baza firm
                </a>
                <a class="nav-link" href="<?= ROOT ?>/company/new">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dodaj firmę
                </a>

                <div class="sb-sidenav-menu-heading">Sprzedaż</div>
                <a class="nav-link" href="<?= ROOT ?>/getcargo">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pobierz towar
                </a>
                <a class="nav-link" href="<?= ROOT ?>/places/my">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Moje miejsca
                </a>
                <a class="nav-link" href="<?= ROOT ?>/sale/new">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Raportuj sprzedaż
                </a>
                <a class="nav-link" href="<?= ROOT ?>/qrscanner">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    QR Raport
                </a>
                <a class="nav-link" href="<?= ROOT ?>/exchange">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Oferty wymiany
                </a>
                <a class="nav-link" href="<?= ROOT ?>/returns/new">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Rozlicz towar
                </a>
                <a class="nav-link" href="<?= ROOT ?>/sale">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Historia sprzedaży
                </a>

                <div class="sb-sidenav-menu-heading">Stickers</div>
                <a class="nav-link" href="<?= ROOT ?>/#">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Sprzęt firmowy
                </a>
                <a class="nav-link" href="<?= ROOT ?>/#">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dane kontaktowe
                </a>
                <a class="nav-link" href="<?= ROOT ?>/#">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Skanuj sprzęt
                </a>

                <div class="sb-sidenav-menu-heading">Raporty</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsesp"
                    aria-expanded="false" aria-controls="collapseWH">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Sprzedaż
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsesp" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= ROOT ?>/#">Utarg - dzienny</a>
                        <a class="nav-link" href="<?= ROOT ?>/#">Utarg - tygodniowy</a>
                        <a class="nav-link" href="<?= ROOT ?>/#">Utarg - miesięczny</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsesppr"
                    aria-expanded="false" aria-controls="collapseWH">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Produkcja
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsesppr" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= ROOT ?>/#">Raport produkcji</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Raporty mailowe</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Sprzedaż
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Podgląd
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.html">Login</a>
                                <a class="nav-link" href="register.html">Register</a>
                                <a class="nav-link" href="password.html">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseError" aria-expanded="false"
                            aria-controls="pagesCollapseError">
                            Wysyłka ręczna
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Technologia</div>
                <a class="nav-link" href="<?= ROOT ?>/recipes">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Receptury
                </a>
                <a class="nav-link" href="<?= ROOT ?>/planner">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Możliwości prod.
                </a>
                <a class="nav-link" href="<?= ROOT ?>/planner/show">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Plan produkcji
                </a>

                <div class="sb-sidenav-menu-heading">Zarządzanie magazynami</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseWH"
                    aria-expanded="false" aria-controls="collapseWH">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Magazyny
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseWH" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= ROOT ?>/cities">Lista miast</a>
                        <a class="nav-link" href="<?= ROOT ?>/warehouse">Lista magazynów</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProd"
                    aria-expanded="false" aria-controls="collapseProd">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Produkty
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProd" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= ROOT ?>/products">Lista produktów/SKU</a>
                        <a class="nav-link" href="<?= ROOT ?>/products/new">Dodaj nowe SKU</a>
                        <a class="nav-link" href="<?= ROOT ?>/prices">Ceny gotowych produktów</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInwen"
                    aria-expanded="false" aria-controls="collapseInwen">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Inwentaryzacja
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseInwen" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= ROOT ?>/availability">Stany magazynowe</a>
                        <a class="nav-link" href="<?= ROOT ?>/scanner/new">Skanuj towar</a>
                        <a class="nav-link" href="<?= ROOT ?>/availability/add">Dodaj towar</a>
                        <a class="nav-link" href="<?= ROOT ?>/availability/sub">Zdejmij ze stanu</a>
                        <a class="nav-link" href="<?= ROOT ?>/scanner/history">Historia skanowania</a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Witaj,</div>
            <b>
                <?php
                $warehoues_id = getYourData("u_warehouse");
                $current_city = $_SESSION["CITIES"][$warehoues_id];
                $current_city_detailed = $current_city["c_name"] . "_" . $current_city["wh_name"];
                ?>
                <?php echo getYourData("first_name") . " " . getYourData("last_name") . "</br>E-mail: " . getYourData("email") . "</br> Uprawnienia: " . $_SESSION["ROLE"]->role_name . "</br>Magazyn: " . $current_city_detailed ?>
            </b>
        </div>
    </nav>
</div>