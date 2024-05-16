<?php

//show($data);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1">
    <tr>
        <td>Produkt</td>
        <td>Pobrano</td>
        <td>Sprzedano</td>
        <td>Różnica</td>
    </tr>
    <?php
    $comp = [];
    foreach($data["sold"] as $s) {
        $comp[$s->c_id][$s->p_id] = 0;
    }
    foreach($data["cargo"] as $prod) {
        echo "<tr>";
        echo "<td>".$data["products"][$prod->p_id]->p_name."</td>";
        echo "<td>".$prod->amount."</td>";
        $sold = 0;
        foreach($data["sold"] as $s) {
        if($s->p_id == $prod->p_id) {
            $sold+=$s->s_amount;
            $comp[$s->c_id][$s->p_id]+=$s->s_amount;
        }
    }
    echo "<td>".$sold."</td>";
    echo "<td>".$prod->amount - $sold."</td>";
    
    echo "</tr>";
    //show($comp);
}
        ?>
    </table>
</br>
</br>
</br>
</br>
    <table border="1">
    <tr>
        <td>Firma</td>
        <td>Sprzedano</td>
    </tr>
    <?php
    //show($data);
    foreach($comp as $k => $v) {
        echo "<tr>";
        echo "<td>".$data["companies"][$k]->full_name."</td>";
        echo "<td>";
        $sum = 0;
        foreach($v as $kk => $vv) {
            $sum += $vv;
            echo $data["products"][$kk]->p_name.' : '.$vv;
            echo "</br>";
        }
        echo "<b>Suma: ".$sum."</b>";
        echo "</br>";
        
        echo "</td>";

    }
    
    echo "</tr>";
    //show($comp);

        ?>
    </table>


</body>
</html>