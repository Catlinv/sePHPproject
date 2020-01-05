<?php


namespace App\Utility;


use App\Database\Database;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExcellManager
{
    public function exportTableCSV($tableName)
    {
        $database = new Database();
        $data = ($database->select($tableName, null, null));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = array_keys($data[0]);
        $column = 'A';
        $row = 1;
        for ($i = 0; $i < count($headers); $i++) {
            $sheet->setCellValue($column . $row, $headers[$i]);
            ++$column;
        }
        ++$row;
        foreach ($data as $item) {
            $column = 'A';
            foreach ($item as $k => $v) {
                $sheet->setCellValue($column . $row, $v);
                ++$column;
            }
            ++$row;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->save($tableName . '.csv');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $tableName . '.csv"');
        $writer->save("php://output");
    }

    public function exportCSVTemplate($filename)
    {
        if (file_exists($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        }
    }

    public function importCSV($filename, $tableName)
    {
        $database = new Database();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet = $reader->load($filename);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $header = array_splice($sheetData, 0, 1)[0];
        //var_dump($header);
        //var_dump($sheetData);
        foreach ($sheetData as $data) {
            $columns = [];
            for ($i = 0; $i < count($data); $i++) {
                $columns[$header[$i]] = $data[$i];
            }
            $database->insert($tableName, $columns);
        }
        //var_dump($database->select($tableName));
    }
}