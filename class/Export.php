<?php
class Export {
    public function export_to_csv($content){
        $date_time = date("YmdHis");
        $file = fopen("export/" . $date_time . "telefones.csv", 'w');
        $header = ['nome', 'telefone'];

        fputcsv($file, $header);

        foreach($content as $data){
            fputcsv($file, $data);
        }

        return $date_time . 'telefone.csv';
    }
}