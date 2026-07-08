<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
$user = mysqli_fetch_assoc($query);

// Proses update profile
if (isset($_POST['update_profile'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);

    $update = mysqli_query($conn, "UPDATE users SET nama='$nama', email='$email', telepon='$telepon' WHERE user_id='$user_id'");

    if ($update) {
        $_SESSION['nama'] = $nama;
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil.');</script>";
    }
}

// Ambil inisial nama untuk avatar
$inisial = strtoupper(substr($user['nama'], 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SportSpace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="profile.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="profile-navbar">
        <a href="index.php" class="navbar-brand">
            <i class="ti ti-bowling"></i>
            </i> SportSpace<span class="dot"></span>
        </a>
        <div class="navbar-actions">
            <a href="riwayat.php" class="nav-link"><i class="ti ti-calendar"></i> Riwayat</a>
            <a href="logout.php" class="btn-logout"><i class="ti ti-logout"></i> Keluar</a>
        </div>
    </nav>

    </nav>

    <div class="back-button-container">
        <a href="index.php" class="btn-back">
            <i class="ti ti-arrow-left"></i>
        </a>
    </div>

    <!-- CONTENT -->
    <div class="profile-container">
        <div class="profile-card">

            <!-- PINDAHKAN KE SINI & SESUAIKAN SAMA GAMBAR SEBELUMNYA -->
            <div class="profile-header-center">
                <div class="center-avatar">
                    <i class="ti ti-user"></i>
                </div>
                <h1>Halo, <?= htmlspecialchars($user['nama']) ?>!</h1>
                <p>Kelola informasi profil akun SportSpace kamu di sini.</p>
            </div>

            <!-- <div class="card-title"> yang lama bisa dihapus atau diganti dengan header di atas -->

            <form action="" method="POST" class="profile-form">

                <div class="form-group">
                    <label><i class="ti ti-id"></i> Nama Lengkap</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
                </div>

                <div class="form-group">
                    <label><i class="ti ti-mail"></i> Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label><i class="ti ti-phone"></i> Nomor Telepon</label>
                    <input type="text" name="telepon" value="<?= htmlspecialchars($user['telepon'] ?? '') ?>"
                        placeholder="Belum diatur">
                </div>

                <div class="form-group">
                    <label><i class="ti ti-shield"></i> Role Akun</label>
                    <input type="text" value="<?= ucfirst($user['role']) ?>" disabled
                        style="background:#f4f7f5;cursor:not-allowed;">
                </div>

                <button type="submit" name="update_profile" class="btn-save">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>

            </form>
        </div>

        <!-- CARD AKSI CEPAT -->
        <div class="quick-actions">
            <a href="riwayat.php" class="quick-card">
                <i class="ti ti-calendar-check"></i>
                <span>Riwayat Booking</span>
                <i class="ti ti-arrow-right" style="margin-left:auto;"></i>
            </a>
            <a href="index.php#lapangan" class="quick-card">
                <i class="ti ti-ball-football"></i>
                <span>Cari Lapangan</span>
                <i class="ti ti-arrow-right" style="margin-left:auto;"></i>
            </a>
            <a href="logout.php" class="quick-card" style="color:#e53e3e;">
                <i class="ti ti-logout"></i>
                <span>Keluar</span>
                <i class="ti ti-arrow-right" style="margin-left:auto;"></i>
            </a>
        </div>
    </div>

</body>

</html>