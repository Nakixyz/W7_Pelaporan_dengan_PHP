<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Laporan Terintegrasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Reporting System - Mahasiswa</h2>
        <div class="row">
            <!-- Tombol Export -->
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Export Data</h5>
                    <hr>
                    <a href="laporan_data_pdf_016.php" class="btn btn-danger mb-2">Download PDF</a>
                    <a href="laporan_data_xlsx_016.php" class="btn btn-success mb-2">Download Excel</a>
                </div>
            </div>
            
            <!-- Area Grafik -->
            <div class="col-md-8">
                <div class="card p-3 shadow-sm">
                    <h5>Grafik Sebaran Mahasiswa</h5>
                    <hr>
                    <?php include 'laporan_data_chart_016.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>