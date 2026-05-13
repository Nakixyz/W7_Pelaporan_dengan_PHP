<?php
require 'vendor/autoload.php';
require 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 


//  Inisialisasi Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan.xlsx");
header('Cache-Control: max-age=0');


// Header Tabel
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'nim');
$sheet->setCellValue('D1', 'prodi'); 

$query = "SELECT nama, nim, prodi FROM mahasiswa"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $rowNum = 2; // Data dimulai dari baris ke-2
    $no = 1;
    while($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $no);
        $sheet->setCellValue('B' . $rowNum, $row['nama']);
        $sheet->setCellValue('C' . $rowNum, $row['nim']);
        $sheet->setCellValue('D' . $rowNum, $row['prodi']);
        $rowNum++;
        $no++;
    }
} else {
    echo "Data tidak ditemukan.";
}

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>