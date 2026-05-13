<?php
require '../vendor/autoload.php';
include 'koneksi.php';
use Dompdf\Dompdf;

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

$html = "<h2>Laporan Data Mahasiswa</h2>";
if ($filter_prodi != '') { $html .= "<p>Program Studi: " . htmlspecialchars($filter_prodi) . "</p>"; }

$html .= "<table border='1' width='100%' cellpadding='5' cellspacing='0'>
          <tr><th>No</th><th>Nama</th><th>NIM</th><th>Prodi</th></tr>";

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td>{$row['nim']}</td>
                <td>{$row['prodi']}</td>
              </tr>";
    $no++;
}
$html .= "</table>";

ob_end_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Laporan_Akademik.pdf");
?>