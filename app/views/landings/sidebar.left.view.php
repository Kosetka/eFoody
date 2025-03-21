<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php
                $your_id = $_SESSION["USER"]->u_role;
                ?>

                <?php
                if (ROOT_DIR === '/efoody/public/') {
                    $curr_place = substr($_SERVER["REQUEST_URI"], 14);
                } else {
                    $curr_place = $_SERVER["REQUEST_URI"];
                }
                foreach ($_SESSION["links"] as $cat) {
                    if ($cat["l_type"] == 0) {
                        echo "<div class='sb-sidenav-menu-heading'>" . $cat["l_name"] . "</div>";
                        foreach ($cat["children"] as $sub1) {
                            if (empty($sub1["children"][0])) {
                                if ($curr_place == $sub1["l_directory"]) {
                                    $curr_css = " sb-selected ";
                                } else {
                                    $curr_css = "";
                                }
                                echo "  <a class='nav-link $curr_css' href='" . ROOT . $sub1["l_directory"] . "'>
                            <div class='sb-nav-link-icon'><i class='" . $sub1["l_icon"] . "'></i></div>
                            " . $sub1["l_name"] . "
                        </a>";
                            } else {
                                echo "  <a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#collapse" . $sub1["id"] . "'
                            aria-expanded='false' aria-controls='collapse" . $sub1["id"] . "'>
                            <div class='sb-nav-link-icon'><i class='fas fa-columns'></i></div>
                            " . $sub1["l_name"] . "
                            <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                        </a>";
                                echo "  <div class='collapse' id='collapse" . $sub1["id"] . "' aria-labelledby='headingOne' data-bs-parent='#sidenavAccordion'>
                            <nav class='sb-sidenav-menu-nested nav'>";
                                foreach ($sub1["children"] as $sub2) {
                                    if (empty($sub2["children"][0])) {
                                        echo "<a class='nav-link' href='" . ROOT . $sub2["l_directory"] . "'>" . $sub2["l_name"] . "</a>";
                                    } else {
                                        echo "  <a class='nav-link collapsed' href='#' data-bs-toggle='collapse'
                                    data-bs-target='#pagesCollapse" . $sub2["id"] . "' aria-expanded='false' aria-controls='pagesCollapse" . $sub2["id"] . "'>
                                    " . $sub2["l_name"] . "
                                    <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                                </a>";
                                        echo "  <div class='collapse' id='pagesCollapse" . $sub2["id"] . "' aria-labelledby='headingOne' data-bs-parent='#sidenavAccordionPages'>
                                    <nav class='sb-sidenav-menu-nested nav'>";
                                        foreach ($sub2["children"] as $sub3) {
                                            echo "<a class='nav-link' href='" . ROOT . $sub3["l_directory"] . "'>" . $sub3["l_name"] . "</a>";
                                        }
                                        echo "      </nav>
                                </div>";
                                    }
                                }
                                echo "      </nav>
                        </div>";
                            }
                        }
                    }
                }

                ?>

                <?php /*?>
           <div class="sb-sidenav-menu-heading">Pracownicy</div>
           <a class="nav-link" href="<?= ROOT ?>/users">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Lista pracowników
           </a>
           <?php
           $access = [1, 2, 4];
           if(in_array($your_id,$access)) {
           ?>
           <a class="nav-link" href="<?= ROOT ?>/signup">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Dodaj pracownika
           </a>
           <?php } ?>
           
           <?php
           $access = [1, 2, 4];
           if(in_array($your_id,$access)) {
           ?>
           <div class="sb-sidenav-menu-heading">Baza firm</div>
           <a class="nav-link" href="<?= ROOT ?>/company">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Baza firm
           </a>
           <?php } ?>

           <?php
           $access = [1, 2, 4];
           if(in_array($your_id,$access)) {
           ?>
           <a class="nav-link" href="<?= ROOT ?>/company/new">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Dodaj firmę
           </a>
           <?php } ?>
           
           <?php
           $access = [1, 2, 3, 4, 10];
           if(in_array($your_id,$access)) {
           ?>
           <div class="sb-sidenav-menu-heading">Handlowiec</div>
           <a class="nav-link" href="<?= ROOT ?>/planner/myplan">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Mój plan
           </a>
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
           <?php } ?>
           
           <?php
           $access = [1, 2];
           if(in_array($your_id,$access)) {
           ?>
           <div class="sb-sidenav-menu-heading">Kuchnia</div>
           <a class="nav-link" href="<?= ROOT ?>/planner/kitchen">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Plan produkcji
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner/producted">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Raportuj produkcję
           </a>
           <?php } ?>

           <?php
           $access = [1, 2];
           if(in_array($your_id,$access)) {
           ?>
           <div class="sb-sidenav-menu-heading">Magazyn</div>
           <a class="nav-link" href="<?= ROOT ?>/getcargo/split">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Przydziel produkty
           </a>
           <?php } ?>

           <?php
           $access = [1, 2, 4];
           if(in_array($your_id,$access)) {
           ?>
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
           <?php } ?>

           <?php
           $access = [1, 2];
           if(in_array($your_id,$access)) {
           ?>
           <div class="sb-sidenav-menu-heading">Raporty</div>
           <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsesp"
               aria-expanded="false" aria-controls="collapseWH">
               <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
               Sprzedaż
               <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
           </a>
           <div class="collapse" id="collapsesp" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
               <nav class="sb-sidenav-menu-nested nav">
                   <a class="nav-link" href="<?= ROOT ?>/reports/sales/show/hour">Raport godzinowy</a>
                   <a class="nav-link" href="<?= ROOT ?>/reports/sales/show/day">Raport dzienny</a>
                   <a class="nav-link" href="<?= ROOT ?>/reports/sales/show/week">Raport tygodniowy</a>
                   <a class="nav-link" href="<?= ROOT ?>/reports/sales/show/month">Raport miesięczny</a>
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
           <?php } ?>

           <?php
           $access = [1, 2];
           if(in_array($your_id,$access)) {
           ?>
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
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/hour">Raport godzinowy</a>
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/day">Raport dzienny</a>
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/week">Raport tygodniowy</a>
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/month">Raport miesięczny</a>
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
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/send/hour">Raport godzinowy</a>
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/send/day">Raport dzienny</a>
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/send/week">Raport tygodniowy</a>
                           <a class="nav-link" href="<?= ROOT ?>/reports/sales/send/month">Raport miesięczny</a>
                       </nav>
                   </div>
               </nav>
           </div>
           <?php } ?>

           <?php
           $access = [1, 2];
           if(in_array($your_id,$access)) {
           ?>
           <div class="sb-sidenav-menu-heading">Technologia</div>
           <a class="nav-link" href="<?= ROOT ?>/recipes">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Receptury
           </a>
           <a class="nav-link" href="<?= ROOT ?>/labels">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Etykiety
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner/new">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Planuj produkcje
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner/split">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Podziel produkty
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner/planned">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Plan produkcji
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner/splitted">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Plan podziału
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner/show">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               [*] Plan produkcji
           </a>
           <a class="nav-link" href="<?= ROOT ?>/planner">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               [*] Możliwości prod.
           </a>
           <?php } ?>

           <?php
           $access = [1, 2];
           if(in_array($your_id,$access)) {
           ?>
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
                   <a class="nav-link" href="<?= ROOT ?>/products">Lista produktów</a>
                   <a class="nav-link" href="<?= ROOT ?>/products/new">Dodaj nowy produkt</a>
                   <a class="nav-link" href="<?= ROOT ?>/sku">Generator SKU</a>
                   <a class="nav-link" href="<?= ROOT ?>/alergens">Lista alergenów</a>
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
           <?php } ?>

       </div>
   </div><?php */ ?>
    </nav>
</div>