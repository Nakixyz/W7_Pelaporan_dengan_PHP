<?php
require '../vendor/autoload.php';
include 'koneksi.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$result = mysqli_query($conn, "SELECT * FROM mahasiswa");

$html = "<h3>Daftar Mahasiswa</h3><table border='1' width='100%' cellpadding='5'>
        <tr><th>Nama</th><th>NIM</th><th>Prodi</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr><td>{$row['nama']}</td><td>{$row['nim']}</td><td>{$row['prodi']}</td></tr>";
}
$html .= "</table>";

ob_end_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Laporan_Mahasiswa.pdf");
?>