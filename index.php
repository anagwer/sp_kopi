<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pakar Kopi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
    <style>
        body {
            background: linear-gradient(to right, #f5e6da, #e9dbc7);
            font-family: 'Segoe UI', sans-serif;
        }

        .hero {
            background-color: #6f4e37;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .hero i {
            font-size: 3rem;
            color: #d2b48c;
        }

        .section-title {
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .feature-box {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: scale(1.03);
        }

        .footer {
            background-color: #6f4e37;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<section class="hero mt-4">
    <i class="fas fa-mug-hot mb-3"></i>
    <h1>Sistem Pakar Mendiagnosis Penyakit Tanaman Kopi</h1>
    <p class="mt-3">Membantu petani Kopi dalam mendiagnosis penyakit tanaman kopi secara cepat dan akurat.</p>
</section>

<!-- Fitur Utama -->
<div class="container mt-5">
    <h2 class="section-title">Fitur Utama Sistem</h2>
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <i class="fas fa-stethoscope fa-2x text-success mb-3"></i>
                <h5>Diagnosa Otomatis</h5>
                <p>Masukkan gejala dan sistem akan mendiagnosis kemungkinan penyakit pada tanaman kopi Anda.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <i class="fas fa-database fa-2x text-primary mb-3"></i>
                <h5>CRUD Gejala & Penyakit</h5>
                <p>Kelola data gejala dan penyakit dengan mudah melalui antarmuka admin yang intuitif.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-box">
                <i class="fas fa-image fa-2x text-warning mb-3"></i>
                <h5>Gambar Visualisasi</h5>
                <p>Tiap penyakit dilengkapi dengan gambar visual untuk memudahkan identifikasi di lapangan.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mx-auto">
            <div class="feature-box">
                <i class="fas fa-project-diagram fa-2x text-info mb-3"></i>
                <h5>Inferensi Engine</h5>
                <p>Logika berbasis aturan yang membantu menemukan solusi dari sekumpulan gejala yang ada.</p>
            </div>
        </div>
    </div>

    <!-- Tombol Diagnosa -->
    <div class="text-center mt-5">
        <a href="diagnosa.php" class="btn btn-lg btn-primary px-4 py-2">
            <i class="fas fa-diagnoses me-2"></i>Mulai Diagnosa Sekarang
        </a>
    </div>
</div>

<!-- Footer -->
<div class="footer mt-5">
    &copy; <?= date('Y') ?> - Sistem Pakar Kopi | Dibuat dengan ❤️ untuk Petani Indonesia
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>