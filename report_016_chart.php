<!DOCTYPE html>
<html>
<head>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<canvas id="myChart"></canvas>

<?php
// Contoh data dari PHP
$labels = ["Januari", "Februari", "Maret"];
$data_poin = [100, 200, 300];
?>

<script>
    const dataDariPHP = <?php echo json_encode($data_poin); ?>;
    const labelDariPHP = <?php echo json_encode($labels); ?>;

    new Chart(document.getElementById('myChart'), {
        type: 'pie',
        data: {
            labels: labelDariPHP,
            datasets: [{
                data: dataDariPHP,
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe']
            }]
        }
    });
</script>
</script>
</body>
</html> 
