<?php
include 'koneksi.php';

// Menangkap filter prodi
$filter_prodi = $_GET['prodi'] ?? '';

// --- 1. AMBIL DATA PRODI UNTUK DROPDOWN DINAMIS ---
$query_prodi = mysqli_query($conn, "SELECT DISTINCT prodi FROM mahasiswa");

// --- 2. QUERY UNTUK GRAFIK (Agregasi COUNT) ---
$query_grafik = mysqli_query($conn, "SELECT prodi, COUNT(id) as total FROM mahasiswa GROUP BY prodi");
$labels = [];
$data_jumlah = [];
while ($row = mysqli_fetch_assoc($query_grafik)) {
    $labels[] = $row['prodi'];
    $data_jumlah[] = $row['total'];
}

// --- 3. QUERY UNTUK TABEL (Prepared Statement) ---
$sql_table = "SELECT * FROM mahasiswa WHERE 1=1";
$params = [];
$types = "";

if ($filter_prodi != '') {
    $sql_table .= " AND prodi = ?";
    $params[] = $filter_prodi;
    $types .= "s";
}

$stmt = mysqli_prepare($conn, $sql_table);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result_table = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Pelaporan Akademik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Pelaporan Akademik</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm mb-3">
                <form method="GET" class="d-flex gap-2">
                    <select name="prodi" class="form-select">
                        <option value="">-- Semua Prodi --</option>
                        <?php while ($p = mysqli_fetch_assoc($query_prodi)): ?>
                            <option value="<?= htmlspecialchars($p['prodi']) ?>" <?= ($filter_prodi == $p['prodi']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['prodi']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
                <div class="mt-3">
                    <a href="export_pdf.php?prodi=<?= urlencode($filter_prodi) ?>" class="btn btn-danger">Export PDF</a>
                    <a href="export_excel.php?prodi=<?= urlencode($filter_prodi) ?>" class="btn btn-success">Export Excel</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <canvas id="grafikProdi" style="max-height: 200px;"></canvas>
            </div>
        </div>
    </div>

    <div class="card p-3 shadow-sm">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr><th>No</th><th>Nama</th><th>NIM</th><th>Prodi</th></tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result_table)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['prodi']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('grafikProdi').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: <?= json_encode($data_jumlah) ?>,
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0']
            }]
        }
    });
</script>
</body>
</html>