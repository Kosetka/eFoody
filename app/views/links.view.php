<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card-header">
                <h1 class="h3 mb-3 fw-normal"></h1>
            </div>

            <div class="text-start">
                <?php
                    //show($data);
                ?>

                <?php

show($data["links"]);
                foreach($data["links"] as $cat) {
                    if($cat["l_type"] == 0) {
                        echo "<div class='sb-sidenav-menu-heading'>".$cat["l_name"]."</div>";
                        foreach($cat["children"] as $sub1) {
                            if(empty($sub1["children"][0])) {
                                echo "  <a class='nav-link' href='".ROOT.$sub1["l_directory"]."'>
                                            <div class='sb-nav-link-icon'><i class='".$sub1["l_icon"]."'></i></div>
                                            ".$sub1["l_name"]."
                                        </a>";
                            } else {
                                echo "  <a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#collapse".$sub1["id"]."'
                                            aria-expanded='false' aria-controls='collapse".$sub1["id"]."'>
                                            <div class='sb-nav-link-icon'><i class='fas fa-columns'></i></div>
                                            ".$sub1["l_name"]."
                                            <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                                        </a>";
                                echo "  <div class='collapse' id='collapse".$sub1["id"]."' aria-labelledby='headingOne' data-bs-parent='#sidenavAccordion'>
                                            <nav class='sb-sidenav-menu-nested nav'>";
                                foreach($sub1["children"] as $sub2) {
                                    if(empty($sub2["children"][0])) {
                                        echo "<a class='nav-link' href='".ROOT.$sub2["l_directory"]."'>".$sub2["l_name"]."</a>";
                                    } else {
                                        echo "  <a class='nav-link collapsed' href='#' data-bs-toggle='collapse'
                                                    data-bs-target='#pagesCollapse".$sub2["id"]."' aria-expanded='false' aria-controls='pagesCollapse".$sub2["id"]."'>
                                                    ".$sub2["l_name"]."
                                                    <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                                                </a>";
                                        echo "  <div class='collapse' id='pagesCollapse".$sub2["id"]."' aria-labelledby='headingOne' data-bs-parent='#sidenavAccordionPages'>
                                                    <nav class='sb-sidenav-menu-nested nav'>";
                                        foreach($sub2["children"] as $sub3) {
                                                echo "<a class='nav-link' href='".ROOT.$sub3["l_directory"]."'>".$sub3["l_name"]."</a>";
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

                    
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>