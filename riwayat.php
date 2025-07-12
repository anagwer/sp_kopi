<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Diagnosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css ">
    <style>
        body {
            background: linear-gradient(to right, #f9f4ef, #f0e6dc);
            font-family: 'Segoe UI', sans-serif;
        }

        .page-header {
            background-color: #6f4e37;
            color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .table-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .dataTable thead th {
            background-color: #d2b48c;
            color: #333;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <!-- Header -->
    <div class="page-header mb-4">
        <i class="fas fa-history fa-2x mb-2"></i>
        <h2>Riwayat Diagnosa</h2>
        <p>Daftar riwayat diagnosa penyakit tanaman kopi oleh petani.</p>
    </div>

    <!-- Tabel Riwayat -->
    <div class="table-container">
        <table id="tabelRiwayat" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Petani</th>
                    <th>Penyakit Terdiagnosa</th>
                    <th>Tanggal Diagnosa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = "
                    SELECT d.nama_pengguna, p.nama_penyakit, d.tanggal_diagnosa
                    FROM diagnosa d
                    JOIN penyakit p ON d.id_penyakit = p.id_penyakit
                    ORDER BY d.tanggal_diagnosa DESC
                ";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_pengguna']) ?></td>
                    <td><?= htmlspecialchars($row['nama_penyakit']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_diagnosa']) ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="4" class="text-center">Belum ada riwayat diagnosa.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js "></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js "></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js "></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    $('#tabelRiwayat').DataTable({
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "search": "Cari:",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>

</body>
</html>