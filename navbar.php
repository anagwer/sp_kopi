<?php
// Dapatkan nama file tanpa path
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-brown shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-mug-hot me-2"></i>Sistem Pakar Kopi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Beranda -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php"><i class="fas fa-home me-1"></i>Beranda</a>
                </li>

                <!-- Gejala -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'gejala.php') ? 'active' : '' ?>" href="gejala.php"><i class="fas fa-list me-1"></i>Gejala</a>
                </li>

                <!-- Penyakit -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'penyakit.php') ? 'active' : '' ?>" href="penyakit.php"><i class="fas fa-virus me-1"></i>Penyakit</a>
                </li>

                <!-- Rule -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'rule.php') ? 'active' : '' ?>" href="rule.php"><i class="fas fa-cogs me-1"></i>Rule</a>
                </li>

                <!-- Diagnosa -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'diagnosa.php') ? 'active' : '' ?>" href="diagnosa.php"><i class="fas fa-diagnoses me-1"></i>Diagnosa</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.bg-brown {
    background-color: #6f4e37;
}
</style>