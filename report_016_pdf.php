<?php
ob_start(); 

require 'vendor/autoload.php';
require 'koneksi.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$query = "SELECT * FROM mahasiswa"; 
$sql = mysqli_query($conn, $query);

$html = '<h2 style="text-align:center;">Laporan Data Mahasiswa</h2>';
$html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                </tr>
            </thead>
            <tbody>';

$no = 1;
while ($data = mysqli_fetch_array($sql)) {
    $html .= '<tr>
                <td style="text-align:center;">' . $no++ . '</td>
                <td>' . $data['nim'] . '</td>
                <td>' . $data['nama'] . '</td>
                <td>' . $data['jurusan'] . '</td>
              </tr>';
}
$html .= '</tbody></table>';

$dompdf->loadHtml($html);

$dompdf->render();


ob_end_clean(); // Bersihkan semua output buffer sebelum stream PDF


$dompdf->stream("laporan.pdf");
?>