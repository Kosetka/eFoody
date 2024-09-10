<?php


/**
 * Cargo class
 */
class Foodcost
{

    use Model;

    public function getPriceDetailed($dateFrom, $date_to = null) 
    {
        /*

            Zwraca historię cen wszystkich produktów, które mają aktywny przepis z podanego zakresu dat
            W zmiennej $temp2 jest tablica z rozbiciem na każdy dzień i każdy półprodukt
            Domyślnie zwracana jest wartość dla każdego produktu i każdego dnia

        */
        if($date_to == null) {
            $date_to = date("Y-m-d");
        }
        // Przygotowanie zapytania z parametrem date_from
        $query = "
        SELECT DISTINCT
            p.id AS p_id, 
            p.p_name, 
            p.sku, 
            p.p_unit, 
            rd.sub_prod, 
            rd.amount,
            pr_sub.date_from,
            pr_sub.date_to,
            pr_sub.production_cost,
            (rd.amount * pr_sub.production_cost) AS total_cost
        FROM 
            products p
        JOIN 
            recipes r ON p.id = r.p_id
        JOIN 
            recipe_details rd ON r.p_id = rd.r_id
        LEFT JOIN 
            prices pr_sub ON rd.sub_prod = pr_sub.p_id
        WHERE 
            r.active = 1
            AND (pr_sub.date_to >= :date_from OR pr_sub.date_to IS NULL)
        ORDER BY 
            p.id, rd.sub_prod, pr_sub.date_from DESC;
        ";

        $temp = [];
        $temp2 = [];
        $result = [];
        // Wykonanie zapytania z parametrem
        $all = $this->query($query, ['date_from' => $dateFrom]);
        
        if(!empty($all)) {
            foreach($all as $one) {
                $temp[$one->p_id][] = $one;
            }
        }
        //show($temp);

        foreach($temp as $one_product) {
            foreach($one_product as $one_row) {
                $date_temp = $dateFrom;
                while($date_temp <= $date_to) {
                    if($one_row->date_to >= $date_temp || ($one_row->date_to == NULL AND $one_row->date_from <= $date_temp)) {
                        $temp2[$one_row->p_id][$date_temp][] = $one_row; //debug szczegółowy
                        if(!isset($result[$one_row->p_id][$date_temp])) {
                            $result[$one_row->p_id][$date_temp] = 0;
                        }
                        $result[$one_row->p_id][$date_temp] += $one_row->total_cost;
                    }
                    
                    $date_temp = date('Y-m-d', strtotime($date_temp . ' +1 day'));
                }
                
            }
        }
        return $result;
    }

    public function getPriceDetailedWithSauce($dateFrom, $date_to = null) 
    {
        /*

            Zwraca historię cen wszystkich produktów, które mają aktywny przepis z podanego zakresu dat
            W zmiennej $temp2 jest tablica z rozbiciem na każdy dzień i każdy półprodukt
            Domyślnie zwracana jest wartość dla każdego produktu i każdego dnia

        */
        if($date_to == null) {
            $date_to = date("Y-m-d");
        }
        // Przygotowanie zapytania z parametrem date_from
        $query = "
        SELECT DISTINCT
            p.id AS p_id, 
            p.p_name, 
            p.sku, 
            p.p_unit, 
            rd.sub_prod, 
            rd.amount,
            pr_sub.date_from,
            pr_sub.date_to,
            pr_sub.production_cost,
            (rd.amount * pr_sub.production_cost) AS total_cost
        FROM 
            products p
        JOIN 
            recipes r ON p.id = r.p_id
        JOIN 
            recipe_details rd ON r.p_id = rd.r_id
        LEFT JOIN 
            prices pr_sub ON rd.sub_prod = pr_sub.p_id
        WHERE 
            r.active = 1
            AND (pr_sub.date_to >= :date_from OR pr_sub.date_to IS NULL)
        ORDER BY 
            p.id, rd.sub_prod, pr_sub.date_from DESC;
        ";

        $temp = [];
        $temp2 = [];
        $result = [];
        // Wykonanie zapytania z parametrem
        $all = $this->query($query, ['date_from' => $dateFrom]);
        
        if(!empty($all)) {
            foreach($all as $one) {
                $temp[$one->p_id][] = $one;
            }
        }
        $data["kcal_sauce"] = [];
        $sauce = new Sauce();
        if(!empty($sauce->getSauces())) {
            foreach($sauce->getSauces() as $sauce) {
                $data["kcal_sauce"][$sauce->p_id] = $sauce->r_id;
            }
        }
        

        foreach($temp as $one_product) {
            foreach($one_product as $one_row) {
                $date_temp = $dateFrom;
                while($date_temp <= $date_to) {
                    if($one_row->date_to >= $date_temp || ($one_row->date_to == NULL AND $one_row->date_from <= $date_temp)) {
                        $temp2[$one_row->p_id][$date_temp][] = $one_row; //debug szczegółowy
                        if(!isset($result[$one_row->p_id][$date_temp])) {
                            $result[$one_row->p_id][$date_temp]["cost"] = 0;
                            $result[$one_row->p_id][$date_temp]["sauce"] = 0;
                            $result[$one_row->p_id][$date_temp]["total"] = 0;
                        }
                        if(isset($result[$one_row->p_id][$date_temp]["cost"])) {
                            $result[$one_row->p_id][$date_temp]["cost"] += $one_row->total_cost;
                        }
                    }
                    if(isset($result[$one_row->p_id][$date_temp]["total"])) {
                        $result[$one_row->p_id][$date_temp]["total"] = $result[$one_row->p_id][$date_temp]["cost"] ;
                    }
                    $date_temp = date('Y-m-d', strtotime($date_temp . ' +1 day'));
                }
                
            }
        }
        if(!empty($data["kcal_sauce"])) {
            foreach($data["kcal_sauce"] as $sau_key => $sau_value) {
                $date_temp = $dateFrom;
                    while($date_temp <= $date_to) {
                        $result[$sau_key][$date_temp]["sauce"] = $result[$sau_value][$date_temp]["cost"];
                        $result[$sau_key][$date_temp]["total"] = $result[$sau_key][$date_temp]["cost"] + $result[$sau_key][$date_temp]["sauce"];
                        $date_temp = date('Y-m-d', strtotime($date_temp . ' +1 day'));
                    }
            }
        }
        return $result;
    }

}