<?php include 'config.php'; ?>
<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengguna = htmlspecialchars($_POST['nama_pengguna']);
    $gejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

    // Validasi minimal 3 gejala
    if (count($gejala) < 3) {
        header("Location: diagnosa.php?error=min_gejala");
        exit();
    }

    $ids = implode(',', array_map('intval', $gejala));

    // Cari penyakit berdasarkan match gejala
    $sql = "
        SELECT p.id_penyakit, p.nama_penyakit, p.solusi, p.gambar, COUNT(r.id_gejala) as match_count
        FROM rule r
        JOIN penyakit p ON p.id_penyakit = r.id_penyakit
        WHERE r.id_gejala IN ($ids)
        GROUP BY p.id_penyakit
        ORDER BY match_count DESC
        LIMIT 1
    ";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();

        // Simpan riwayat diagnosa
        $stmt = $conn->prepare("INSERT INTO diagnosa (nama_pengguna, id_penyakit) VALUES (?, ?)");
        $stmt->bind_param("si", $nama_pengguna, $data['id_penyakit']);
        $stmt->execute();
        $stmt->close();

        // Redirect ke hasil.php dengan id_diagnosa
        $id_diagnosa = $conn->insert_id;
        header("Location: hasil.php?id=$id_diagnosa");
        exit();
    } else {
        echo "<div class='alert alert-danger mt-4 text-center'>Tidak ditemukan penyakit yang cocok.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Diagnosa Penyakit Kopi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css " rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f5e6da, #e9dbc7);
            font-family: 'Segoe UI', sans-serif;
        }

        .hero {
            background-color: #d2b48c;
            color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .form-check-input:checked {
            background-color: #8b5e3c;
            border-color: #8b5e3c;
        }

        .card {
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .btn-primary {
            background-color: #6f4e37;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5c3d2e;
        }

        .coffee-icon {
            font-size: 2rem;
            color: #8b5e3c;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="hero mb-4 d-flex align-items-center justify-content-center">
        <i class="fa-solid fa-mug-hot coffee-icon me-3"></i>
        <h1 class="mb-0">Diagnosa Penyakit Tanaman Kopi</h1>
    </div>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'min_gejala'): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Oops!</strong> Silakan pilih minimal 3 gejala.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <p class="text-center mb-4">Silakan pilih gejala yang dialami oleh tanaman kopi Anda:</p>

    <form method="post">
        <div class="mb-3">
            <label for="nama_pengguna" class="form-label">Nama Petani:</label>
            <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" required placeholder="Masukkan nama Anda">
        </div>

        <div class="row">
            <?php
            $sql = "SELECT * FROM gejala ORDER BY id_gejala ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-check p-3 bg-white rounded shadow-sm border border-1">
                            <input class="form-check-input" type="checkbox" name="gejala[]" value="<?= $row['id_gejala'] ?>" id="gejala<?= $row['id_gejala'] ?>">
                            <label class="form-check-label" for="gejala<?= $row['id_gejala'] ?>">
                                <?= $row['nama_gejala'] ?>
                            </label>
                        </div>
                    </div>
            <?php endwhile; else: ?>
                <div class="col-12"><p class="text-center">Tidak ada data gejala.</p></div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary px-4 py-2" type="submit">
                <i class="fas fa-diagnoses me-2"></i>Diagnosa Sekarang
            </button>
        </div>
    </form>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>