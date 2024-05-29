<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<style>
.tree-container {
    text-align: left;
}

ul {
    list-style-type: none;
    padding-left: 20px;
    margin: 0;
}

li {
    margin: 5px 0;
    position: relative;
}

li::before {
    content: '';
    position: absolute;
    top: 10px;
    left: -15px;
    width: 10px;
    height: 1px;
    background: #ccc;
}

li::after {
    content: '';
    position: absolute;
    top: -10px;
    left: -15px;
    width: 1px;
    height: 20px;
    background: #ccc;
}

li:first-child::after {
    display: none;
}

input[type="checkbox"] {
    margin-right: 5px;
}

label {
    font-family: Arial, sans-serif;
    font-size: 14px;
    cursor: pointer;
}

ul ul::before {
    content: '';
    position: absolute;
    top: 10px;
    left: -20px;
    width: 10px;
    height: 1px;
    background: #ccc;
}

ul ul::after {
    content: '';
    position: absolute;
    top: -10px;
    left: -20px;
    width: 1px;
    height: 20px;
    background: #ccc;
}

ul ul li {
    margin-left: 20px;
}
</style>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
  <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="">Edycja roli</h2>
        </div>
        <div class="form-group row m-3">
            <form method="post">
                <?php
                //show($data);
                ?>
                <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode("<br>", $errors) ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= $success ?>
                </div>
                <?php endif; ?>

                <div class="text-start">
                <div class="form-group row m-3">
                    <label for="role_name" class="col-sm-2 col-form-label">Nazwa</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="role_name" name="role_name" value="<?=$data["roles"]->role_name; ?>" required>
                    </div>
                </div>
                <div class="form-group row m-3">
                    <label for="role_description" class="col-sm-2 col-form-label">Opis:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="role_description" value="<?=$data["roles"]->role_description; ?>" name="role_description">
                    </div>
                </div>
                <div class="form-group row m-3">
                    <label for="r_active" class="col-sm-2 col-form-label">Rola aktywna:</label>
                    <div class="col-sm-10">
                        <?php
                        $checked = "";
                        if($data["roles"]->r_active == 1) {
                            $checked ="checked";
                        }

                        ?>
                    <input type="checkbox" class="form-check-input" id="r_active" name="r_active" value="1" <?=$checked?>>
                    </div>
                </div>
                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit" name="role" value="1">Edytuj rolę</button>
            </form>
            </div>
        </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="">Uprawnienia</h2>
        </div>
        <div class="form-group row m-3">
            <div class="col-sm-12">
                <?php

                    function generateTree($items) {
                        $html = '<ul>';
                        foreach ($items as $item) {
                            $html .= '<li>';
                            $html .= '<input type="checkbox" id="checkbox-' . $item['id'] . '" class="checkbox" data-id="' . $item['id'] . '" />';
                            $html .= '<label for="checkbox-' . $item['id'] . '">' . $item['l_name'] . '</label>';
                            if (!empty($item['children'])) {
                                $html .= generateTree($item['children']);
                            }
                            $html .= '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    }
                
                    echo '<div class="tree-container">';
                    echo generateTree($data["links"]);
                    echo '</div>';
                    echo '<button id="prepareTableButton" class="w-40 btn btn-lg btn-primary">Zapisz uprawnienia</button>';
            

?>
            </div>
        </div>
    </div>

    </main>
    <?php
        echo '<script>';
        if(isset($data["access"])) {
            echo 'const preselectedItems = ' . json_encode(array_keys($data["access"])) . ';';
        } else {
            echo 'const preselectedItems = [];';
        }
        echo '</script>';
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.checkbox');
    
    // Function to handle checking/unchecking parents and children
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Handle checking/unchecking children
            const children = this.closest('li').querySelectorAll('.checkbox');
            children.forEach(child => {
                if (child !== this) {
                    child.checked = this.checked;
                }
            });

            // Handle checking parents
            handleParentCheck(this);
        });
    });

    function handleParentCheck(checkbox) {
        if (checkbox.checked) {
            // Check all parents
            let parentLi = checkbox.closest('ul').closest('li');
            while (parentLi) {
                const parentCheckbox = parentLi.querySelector('.checkbox');
                if (parentCheckbox) {
                    parentCheckbox.checked = true;
                }
                parentLi = parentLi.closest('ul').closest('li');
            }
        } else {
            // Uncheck all parents if no other children are checked
            let parentLi = checkbox.closest('ul').closest('li');
            while (parentLi) {
                const parentCheckbox = parentLi.querySelector('.checkbox');
                const siblingCheckboxes = parentLi.querySelectorAll('ul .checkbox');
                const anySiblingChecked = Array.from(siblingCheckboxes).some(siblingCheckbox => siblingCheckbox.checked);
                if (!anySiblingChecked && parentCheckbox) {
                    parentCheckbox.checked = false;
                }
                parentLi = parentLi.closest('ul').closest('li');
            }
        }
    }

    // Preselect checkboxes based on preselectedItems
    preselectedItems.forEach(function(id) {
        const checkbox = document.querySelector(`.checkbox[data-id='${id}']`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });

    // Handle form submission
    document.getElementById('prepareTableButton').addEventListener('click', function() {
        var inputs = document.querySelectorAll('.checkbox');
        var preparedData = [];

        inputs.forEach(function(input) {
            if (input.checked) {
                var itemData = {
                    id: input.getAttribute('data-id')
                };
                preparedData.push(itemData);
            }
        });

        // Create a form to send the result data
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = ''; // Adjust the action URL if needed

        // Add hidden inputs for each entry in the preparedData array
        preparedData.forEach(function(item) {
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = `prepared_items[${item.id}]`;
            inputId.value = item.id;

            form.appendChild(inputId);
        });

        // Add the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();
    });
});
    </script>
    <?php require_once 'landings/footer.view.php' ?>