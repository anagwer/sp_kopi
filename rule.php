<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mapping Gejala - Penyakit</title>
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

        .btn-custom {
            background-color: #8b5e3c;
            color: white;
        }

        .btn-custom:hover {
            background-color: #7a4d2b;
        }

        .modal-content {
            border-radius: 10px;
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
        <i class="fas fa-project-diagram fa-2x mb-2"></i>
        <h2>Mapping Rule Gejala - Penyakit</h2>
        <p>Kelola hubungan antara gejala dan penyakit untuk sistem forward chaining.</p>
    </div>

    <!-- Tabel Rule -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Daftar Mapping Rule</h5>
            <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i>Tambah Rule
            </button>
        </div>

        <table id="tabelRule" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID Rule</th>
                    <th>Penyakit</th>
                    <th>Gejala</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("
                    SELECT r.id_rule, p.nama_penyakit, g.nama_gejala 
                    FROM rule r
                    JOIN penyakit p ON p.id_penyakit = r.id_penyakit
                    JOIN gejala g ON g.id_gejala = r.id_gejala
                    ORDER BY r.id_rule ASC
                ");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_rule']) ?></td>
                    <td><?= htmlspecialchars($row['nama_penyakit']) ?></td>
                    <td><?= htmlspecialchars($row['nama_gejala']) ?></td>
                    <td>
                        <a href="?hapus=<?= $row['id_rule'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" class="needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rule Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="penyakit" class="form-label">Penyakit</label>
                        <select name="id_penyakit" id="penyakit" class="form-select" required>
                            <option value="">-- Pilih Penyakit --</option>
                            <?php
                            $penyakit = $conn->query("SELECT * FROM penyakit");
                            while ($p = $penyakit->fetch_assoc()):
                                echo "<option value='{$p['id_penyakit']}'>{$p['nama_penyakit']}</option>";
                            endwhile;
                            ?>
                        </select>
                        <div class="invalid-feedback">Harap pilih penyakit!</div>
                    </div>
                    <div class="mb-3">
                        <label for="gejala" class="form-label">Gejala</label>
                        <select name="id_gejala" id="gejala" class="form-select" required>
                            <option value="">-- Pilih Gejala --</option>
                            <?php
                            $gejala = $conn->query("SELECT * FROM gejala");
                            while ($g = $gejala->fetch_assoc()):
                                echo "<option value='{$g['id_gejala']}'>{$g['nama_gejala']}</option>";
                            endwhile;
                            ?>
                        </select>
                        <div class="invalid-feedback">Harap pilih gejala!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js "></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js "></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js "></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    $('#tabelRule').DataTable({
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

// Validasi Form Bootstrap
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php
// TAMBAH DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $id_penyakit = $_POST['id_penyakit'];
    $id_gejala = $_POST['id_gejala'];

    // Cek apakah sudah ada rule yang sama
    $cek = $conn->query("SELECT * FROM rule WHERE id_penyakit = $id_penyakit AND id_gejala = $id_gejala");
    if ($cek->num_rows > 0) {
        echo "<script>alert('Rule ini sudah ada!')</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO rule (id_penyakit, id_gejala) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_penyakit, $id_gejala);
        $stmt->execute();
    }

    echo "<script>window.location.href='rule.php';</script>";
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM rule WHERE id_rule=$id");
    echo "<script>window.location.href='rule.php';</script>";
}
?>
</body>
</html>