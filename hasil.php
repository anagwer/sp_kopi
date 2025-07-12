<?php
include 'config.php';
$id_diagnosa = intval($_GET['id']);

$sql = "
    SELECT d.nama_pengguna, p.nama_penyakit, p.solusi, p.gambar, d.tanggal_diagnosa
    FROM diagnosa d
    JOIN penyakit p ON d.id_penyakit = p.id_penyakit
    WHERE d.id_diagnosa = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_diagnosa);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Diagnosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css " rel="stylesheet">
    <style>
        /* Styling sama seperti diagnosa.php */
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
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="hero mb-4">
        <h2>Hasil Diagnosa</h2>
    </div>

    <div class="card mt-4 mx-auto shadow" style="max-width: 500px;">
        <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" class="card-img-top" alt="Gambar Penyakit">
        <div class="card-body text-center">
            <h5 class="card-title"><?= htmlspecialchars($data['nama_penyakit']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($data['solusi'])) ?></p>
            <p class="text-muted small">Diagnosa oleh: <?= htmlspecialchars($data['nama_pengguna']) ?> - <?= $data['tanggal_diagnosa'] ?></p>
            <a href="riwayat.php" class="btn btn-primary">Lihat Riwayat</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>