<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gejala Tanaman Kopi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
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
        <i class="fas fa-list-alt fa-2x mb-2"></i>
        <h2>Data Gejala Tanaman Kopi</h2>
        <p>Kelola gejala yang digunakan dalam sistem pakar untuk diagnosa penyakit kopi.</p>
    </div>

    <!-- Tabel Gejala -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Daftar Gejala</h5>
            <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i>Tambah Gejala
            </button>
        </div>

        <table id="tabelGejala" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Gejala</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM gejala ORDER BY id_gejala ASC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['kode_gejala']) ?></td>
                    <td><?= htmlspecialchars($row['nama_gejala']) ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEdit<?= $row['id_gejala'] ?>"><i class="fas fa-edit"></i></button>
                        <a href="?hapus=<?= $row['id_gejala'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit<?= $row['id_gejala'] ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <form method="post" class="needs-validation" novalidate>
                            <input type="hidden" name="id_gejala" value="<?= $row['id_gejala'] ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Gejala</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode Gejala</label>
                                        <input type="text" name="kode" id="kode" class="form-control" value="<?= htmlspecialchars($row['kode_gejala']) ?>" required>
                                        <div class="invalid-feedback">Harap masukkan kode gejala!</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Gejala</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($row['nama_gejala']) ?>" required>
                                        <div class="invalid-feedback">Harap masukkan nama gejala!</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                    <h5 class="modal-title">Tambah Gejala Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_tambah" class="form-label">Kode Gejala</label>
                        <input type="text" name="kode" id="kode_tambah" class="form-control" required>
                        <div class="invalid-feedback">Harap masukkan kode gejala!</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_tambah" class="form-label">Nama Gejala</label>
                        <input type="text" name="nama" id="nama_tambah" class="form-control" required>
                        <div class="invalid-feedback">Harap masukkan nama gejala!</div>
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
    $('#tabelGejala').DataTable({
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
// Tambah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stmt = $conn->prepare("INSERT INTO gejala (kode_gejala, nama_gejala) VALUES (?, ?)");
    $stmt->bind_param("ss", $kode, $nama);
    $stmt->execute();
    echo "<script>window.location.href='gejala.php';</script>";
}

// Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id_gejala'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stmt = $conn->prepare("UPDATE gejala SET kode_gejala=?, nama_gejala=? WHERE id_gejala=?");
    $stmt->bind_param("ssi", $kode, $nama, $id);
    $stmt->execute();
    echo "<script>window.location.href='gejala.php';</script>";
}

// Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM gejala WHERE id_gejala=$id");
    echo "<script>window.location.href='gejala.php';</script>";
}
?>
</body>
</html>