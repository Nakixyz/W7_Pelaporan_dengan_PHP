<?php
include 'koneksi.php';
$query = mysqli_query($conn, "SELECT prodi, COUNT(*) as jumlah FROM mahasiswa GROUP BY prodi");

$prodi = [];
$jumlah = [];
while ($row = mysqli_fetch_assoc($query)) {
 $prodi[] = $row['prodi'];
 $jumlah[] = $row['jumlah'];
}
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<canvas id="chart"></canvas>
<script>
const data = {
 labels: <?= json_encode($prodi) ?>,
 datasets: [{
 label: 'Jumlah Mahasiswa',
 data: <?= json_encode($jumlah) ?>,
 backgroundColor: ['red','blue','green','orange']
 }]
};
new Chart(document.getElementById('chart'), {
 type: 'bar',
 data: data
});
</script>
</body>
</html> 