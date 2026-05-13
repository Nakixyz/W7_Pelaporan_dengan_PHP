<?php
require '../vendor/autoload.php';
include 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filter_prodi = $_GET['prodi'] ?? '';
$sql = "SELECT * FROM mahasiswa WHERE 1=1";
$params = [];
$types = "";

if ($filter_prodi != '') {
    $sql .= " AND prodi = ?";
    $params[] = $filter_prodi;
    $types .= "s";
}

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Inisialisasi PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Mahasiswa');

// Header Kolom (Urutan disesuaikan)
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'NIM');
$sheet->setCellValue('D1', 'Prodi');

// Isi Data
$row_num = 2;
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row_num, $no++);
    $sheet->setCellValue('B' . $row_num, $row['nama']);
    // Menambahkan spasi kosong agar NIM terbaca sebagai string di Excel
    $sheet->setCellValue('C' . $row_num, ' ' . $row['nim']); 
    $sheet->setCellValue('D' . $row_num, $row['prodi']);
    $row_num++;
}

// Proses output ke browser
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Akademik.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>