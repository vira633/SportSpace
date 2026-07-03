<?php

require 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data dari form front-end
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $role     = isset($_POST['role']) ? trim($_POST['role']) : 'user';

    // Validasi input kosong
    if (empty($nama) || empty($email) || empty($password) || empty($role)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi!']);
        exit;
    }

    // Proteksi keamanan isi role
    if (!in_array($role, ['user', 'owner'])) {
        echo json_encode(['status' => 'error', 'message' => 'Role tidak valid!']);
        exit;
    }

    // Validasi panjang password
    if (strlen($password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Password minimal 8 karakter!']);
        exit;
    }

    // Cek duplikasi email di tabel users
    $cek = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email sudah terdaftar!']);
        $cek->close();
        exit;
    }
    $cek->close();

    // Proses hashing password keamananan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ── PROSES SAKTI INPUT DOUBLE TABEL (TRANSACTION) ──
    $conn->begin_transaction();

    try {
        // 1. Masukkan data ke tabel users terlebih dahulu
        $stmtUser = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
        $stmtUser->bind_param("ssss", $nama, $email, $hashedPassword, $role);
        $stmtUser->execute();
        
        // Ambil ID baru yang barusan digenerate dari tabel users
        $new_user_id = $conn->insert_id;
        $stmtUser->close();

        // 2. Cek jika pendaftar memilih sebagai Owner, masukkan juga ke tabel owners
        if ($role === 'owner') {
            // PERBAIKAN SAKTI: Menyesuaikan kolom asli database: user_id, nama, email
            $stmtOwner = $conn->prepare("INSERT INTO owners (user_id, nama, email) VALUES (?, ?, ?)");
            $stmtOwner->bind_param("iss", $new_user_id, $nama, $email);
            $stmtOwner->execute();
            $stmtOwner->close();
        }

        // Jika kedua proses insert di atas sukses tanpa error, komit data ke database resmi
        $conn->commit();

        // Setel data session akun loginnya
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['nama']    = $nama;
        $_SESSION['email']   = $email;
        $_SESSION['role']    = $role;

        // ── REDIRECT DINAMIS BERDASARKAN ROLE ──
        $redirect_page = 'index.php'; // Default rute buat user biasa
        if ($role === 'owner') {
            $redirect_page = 'dashboard-owner.php'; // Rute lompat khusus owner GOR
        }

        echo json_encode([
            'status' => 'success', 
            'message' => 'Registrasi berhasil!', 
            'redirect' => $redirect_page
        ]);

    } catch (Exception $e) {
        // Jika salah satu insert gagal, batalkan semua perubahan biar database gak pincang sebelah
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
    }
}

$conn->close();
?>