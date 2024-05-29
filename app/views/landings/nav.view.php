<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="<?= ROOT ?>/">Pan-Obiadek.pl</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <span class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 text-white">
        <form method="post" id="changeDepartmentForm">
            <select id="changeDepartment" class="form-select" name="changeDepartment">
                <?php
                show($_SESSION["CITIES"]);
                foreach ($_SESSION["CITIES"] as $city) {
                    $full_tag = $city["c_name"] . '_' . $city["wh_name"];
                    $select = '';
                    $city_id = $city["id"];
                    if ($_SESSION["USER"]->u_warehouse == $city["id"]) {
                        $select = "selected";
                    }
                    echo "<option $select value='$city_id'>$full_tag</option>";
                }
                ?>
            </select>
        </form>


    </span>
    <script>
        const dropdown = document.getElementById("changeDepartment");

        dropdown.addEventListener("change", function () {
            let id = document.getElementById("changeDepartment").value;
            //alert('<?php echo ROOT . "/users/setDepartment/" ?>' + id);
            $.ajax({
                url: '<?php echo ROOT . "/users/setDepartment/" ?>' + id,
                success: function (data) {
                    window.location.href = window.location.href
                }
            });
        });
    </script>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fas fa-user fa-fw"></i><?=getYourData("first_name") . " " . getYourData("last_name")?></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <?php
                /*$warehoues_id = getYourData("u_warehouse");
                $current_city = $_SESSION["CITIES"][$warehoues_id];
                $current_city_detailed = $current_city["c_name"] . "_" . $current_city["wh_name"];
                echo "<b>Witaj</b>, </br>".getYourData("first_name") . " " . 
                    getYourData("last_name") . "</br>E-mail: " . 
                    getYourData("email") . "</br> Uprawnienia: " . $_SESSION["ROLE"]->role_name . "</br>Magazyn: " . $current_city_detailed */
            ?>
                <li><a class="dropdown-item" href="<?= ROOT ?>/profile/<?= getYourData("id") ?>">Twój profil</a>
                </li>

                <li><a class="dropdown-item" href="<?= ROOT ?>/profile/camera">Wybór kamery</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="<?= ROOT ?>/logout">Wyloguj</a></li>
            </ul>
        </li>
    </ul>
</nav>