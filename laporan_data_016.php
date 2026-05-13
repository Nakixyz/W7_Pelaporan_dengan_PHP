<?php
include 'koneksi.php';
$sql = "SELECT * FROM mahasiswa ORDER BY nama ASC";
$result = mysqli_query($conn, $sql);
?> 

<!DOCTYPE html>
<html>
<head>
 <title>Laporan Mahasiswa</title>
</head>
<body>
<h2>Laporan Data Mahasiswa</h2>
<table border="1" cellpadding="5">
 <tr>
 <th>No</th>
 <th>Nama</th>
 <th>NIM</th>
 <th>Prodi</th>
 </tr>
<?php
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
 echo "<tr>
 <td>".$no++."</td>
 <td>".$row['nama']."</td>
 <td>".$row['nim']."</td>
 <td>".$row['prodi']."</td>
 </tr>";
}
?>
</table>
</body>
</html>