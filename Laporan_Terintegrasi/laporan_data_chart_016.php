<?php
include 'koneksi.php';

// Ambil jumlah mahasiswa per prodi untuk grafik
$query = mysqli_query($conn, "SELECT prodi, COUNT(*) as jumlah FROM mahasiswa GROUP BY prodi");
$labels = [];
$data = [];

while($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['prodi'];
    $data[] = $row['jumlah'];
}
?>

<canvas id="myPieChart" style="max-height: 300px;"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverOffset: 4
            }]
        }
    });
</script>