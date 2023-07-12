<?php
class Export {
    public function export_to_csv($received_file, $filename){

        $file = fopen($filename, 'w');

        $header = [];
        $content = [];

        foreach($received_file[0] as $key => $value){
            $header[] = $key;
        }

        $content[0] = $header;

        foreach($received_file as $key => $value){
            $content[] = (array)$value;
        }

        foreach($content as $data){
            fputcsv($file, $data);
        }

        fclose($file);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragama: public');
        header('Content-lenght: ' . filesize($filename));
        readfile($filename);
    }
}
