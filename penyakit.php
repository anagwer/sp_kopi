<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Penyakit Tanaman Kopi</title>
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

        .table img {
            max-width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .card-img {
            max-width: 100px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <!-- Header -->
    <div class="page-header mb-4">
        <i class="fas fa-virus fa-2x mb-2"></i>
        <h2>Data Penyakit Tanaman Kopi</h2>
        <p>Kelola data penyakit lengkap dengan solusi dan gambar visual.</p>
    </div>

    <!-- Tabel Penyakit -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Daftar Penyakit</h5>
            <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i>Tambah Penyakit
            </button>
        </div>

        <table id="tabelPenyakit" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Penyakit</th>
                    <th>Solusi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM penyakit ORDER BY id_penyakit ASC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['kode_penyakit']) ?></td>
                    <td><?= htmlspecialchars($row['nama_penyakit']) ?></td>
                    <td><?= nl2br(htmlspecialchars(substr($row['solusi'], 0, 70) . (strlen($row['solusi']) > 70 ? '...' : ''))) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img" alt="Gambar"></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEdit<?= $row['id_penyakit'] ?>"><i class="fas fa-edit"></i></button>
                        <a href="?hapus=<?= $row['id_penyakit'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit<?= $row['id_penyakit'] ?>">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <input type="hidden" name="id_penyakit" value="<?= $row['id_penyakit'] ?>">
                            <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Penyakit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode Penyakit</label>
                                        <input type="text" name="kode" id="kode" class="form-control" value="<?= htmlspecialchars($row['kode_penyakit']) ?>" required>
                                        <div class="invalid-feedback">Harap masukkan kode penyakit!</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Penyakit</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($row['nama_penyakit']) ?>" required>
                                        <div class="invalid-feedback">Harap masukkan nama penyakit!</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="solusi" class="form-label">Solusi</label>
                                        <textarea name="solusi" id="solusi" class="form-control" rows="4"><?= htmlspecialchars($row['solusi']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label>Gambar Saat Ini</label><br>
                                        <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img mb-2" alt="Gambar">
                                        <input type="file" name="gambar" class="form-control" accept="image/*">
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penyakit Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_tambah" class="form-label">Kode Penyakit</label>
                        <input type="text" name="kode" id="kode_tambah" class="form-control" required>
                        <div class="invalid-feedback">Harap masukkan kode penyakit!</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_tambah" class="form-label">Nama Penyakit</label>
                        <input type="text" name="nama" id="nama_tambah" class="form-control" required>
                        <div class="invalid-feedback">Harap masukkan nama penyakit!</div>
                    </div>
                    <div class="mb-3">
                        <label for="solusi_tambah" class="form-label">Solusi</label>
                        <textarea name="solusi" id="solusi_tambah" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_tambah" class="form-label">Gambar</label>
                        <input type="file" name="gambar" id="gambar_tambah" class="form-control" required>
                        <div class="invalid-feedback">Harap unggah gambar!</div>
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
    $('#tabelPenyakit').DataTable({
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
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $solusi = $_POST['solusi'];
    $gambar = basename($_FILES["gambar"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $gambar;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO penyakit (kode_penyakit, nama_penyakit, solusi, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $kode, $nama, $solusi, $gambar);
        $stmt->execute();
    } else {
        echo "<script>alert('Gagal mengunggah gambar!')</script>";
    }

    echo "<script>window.location.href='penyakit.php';</script>";
}

// EDIT DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id_penyakit'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $solusi = $_POST['solusi'];
    $gambar_lama = $_POST['gambar_lama'];

    if ($_FILES['gambar']['name']) {
        $gambar_baru = basename($_FILES["gambar"]["name"]);
        $target_dir = "uploads/";
        $target_file = $target_dir . $gambar_baru;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            unlink("uploads/" . $gambar_lama); // Hapus gambar lama
        } else {
            echo "<script>alert('Gagal mengunggah gambar baru!')</script>";
            exit;
        }
    } else {
        $gambar_baru = $gambar_lama;
    }

    $stmt = $conn->prepare("UPDATE penyakit SET kode_penyakit=?, nama_penyakit=?, solusi=?, gambar=? WHERE id_penyakit=?");
    $stmt->bind_param("ssssi", $kode, $nama, $solusi, $gambar_baru, $id);
    $stmt->execute();

    echo "<script>window.location.href='penyakit.php';</script>";
}

// HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = $conn->query("SELECT gambar FROM penyakit WHERE id_penyakit=$id")->fetch_assoc();
    unlink("uploads/" . $data['gambar']);
    $conn->query("DELETE FROM penyakit WHERE id_penyakit=$id");
    echo "<script>window.location.href='penyakit.php';</script>";
}
?>
</body>
</html>