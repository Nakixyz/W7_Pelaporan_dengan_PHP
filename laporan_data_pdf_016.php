<?php
require 'vendor/autoload.php';
include 'koneksi.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$html = "<table border='1'>";

$result = mysqli_query($conn, "SELECT * FROM mahasiswa");

while ($row = mysqli_fetch_assoc($result)) {
 $html .= "<tr>
 <td>{$row['nama']}</td>
 <td>{$row['nim']}</td>
 <td>{$row['prodi']}</td>
 </tr>";

}

$html .= "</table>";

ob_end_clean(); // Bersihkan semua output buffer sebelum stream PDF

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("laporan2.pdf");
?>
