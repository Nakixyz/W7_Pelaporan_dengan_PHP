<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Mahasiswa.xls");

$result = mysqli_query($conn, "SELECT * FROM mahasiswa");
?>
<table border="1">
    <tr>
        <th>Nama</th>
        <th>NIM</th>
        <th>Prodi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['nim']; ?></td>
        <td><?php echo $row['prodi']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>