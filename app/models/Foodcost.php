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

}