<?php
require 'vendor/autoload.php';
include 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'NIM');
$sheet->setCellValue('D1', 'Prodi');

$result = mysqli_query($conn, "SELECT * FROM mahasiswa");

$rowNumber = 2;

while ($row = mysqli_fetch_assoc($result)) {
 $sheet->setCellValue('A'.$rowNumber, $rowNumber - 1);
 $sheet->setCellValue('B'.$rowNumber, $row['nama']);
 $sheet->setCellValue('C'.$rowNumber, $row['nim']);
 $sheet->setCellValue('D'.$rowNumber, $row['prodi']);
 $rowNumber++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('laporan_mahasiswa.xlsx');
echo "Laporan Excel berhasil dibuat";
?> 
