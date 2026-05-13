<?php
include 'koneksi.php';
$prodi = $_GET['prodi'] ?? '';
$keyword = $_GET['keyword'] ?? '';
?> 

<!-- 2. Buat Form Input Parameter -->

<!DOCTYPE html>
<html>
<head>
 <title>Laporan Parameter</title>
</head>
<body>
<h2>Filter Laporan Mahasiswa</h2>
<form method="GET">
 Prodi: <input type="text" name="prodi"><br><br>
 Cari Nama: <input type="text" name="keyword"><br><br>
 <button type="submit">Tampilkan</button>
</form> 

<!-- 3. Bangun Query Dinamis (Dasar) -->

<?php
$sql = "SELECT * FROM mahasiswa WHERE 1=1";
if ($prodi != '') {
 $sql .= " AND prodi = '$prodi'";
}
if ($keyword != '') {
 $sql .= " AND nama LIKE '%$keyword%'";
}
$result = mysqli_query($conn, $sql);
?>

<!-- 4. Tampilkan Hasil Laporan -->

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

<!-- 5. Gunakan Prepared Statement (Versi Aman) -->

<?php
include 'koneksi.php';
$prodi = $_GET['prodi'] ?? '';
$keyword = $_GET['keyword'] ?? '';
$sql = "SELECT * FROM mahasiswa WHERE 1=1";
$params = [];
$types = "";
if ($prodi != '') {
 $sql .= " AND prodi = ?";
 $params[] = $prodi;
 $types .= "s";
}
if ($keyword != '') {
 $sql .= " AND nama LIKE ?";
 $params[] = "%$keyword%";
 $types .= "s";
}
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
 mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result 
?>