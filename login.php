<?php
require 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi: pastikan semua field terisi
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email dan password harus diisi!']);
        exit;
    }

    // Cari user berdasarkan email
    $stmt = $conn->prepare("
    SELECT user_id, nama, email, password, role, aktif
    FROM users
    WHERE email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email tidak ditemukan!']);
        $stmt->close();
        exit;
    }

    $user = $result->fetch_assoc();

    // Cek password
    if (!password_verify($password, $user['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Password salah!']);
        $stmt->close();
        exit;
    }

    // Cek apakah akun diban
    if ($user['aktif'] == 'nonaktif') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.'
        ]);
        $stmt->close();
        exit;
        }

    // Login berhasil — simpan ke session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['email']   = $user['email'];
    $_SESSION['role']    = $user['role'];

    // Arahkan berdasarkan role
    if ($user['role'] === 'admin') {
        echo json_encode(['status' => 'success', 'message' => 'Login berhasil!', 'redirect' => 'dashboard-admin.php']);
    } elseif ($user['role'] === 'owner') {
        echo json_encode(['status' => 'success', 'message' => 'Login berhasil!', 'redirect' => 'dashboard-owner.php']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Login berhasil!', 'redirect' => 'index.php']);
    }

    $stmt->close();
}

$conn->close();
?>