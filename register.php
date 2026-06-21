<?php

require 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data dari form
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi: pastikan semua field terisi
    if (empty($nama) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi!']);
        exit;
    }

    // Validasi: password minimal 8 karakter
    if (strlen($password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Password minimal 8 karakter!']);
        exit;
    }

    // Cek apakah email sudah terdaftar
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

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan user baru ke database
    $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $nama, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Langsung buat session setelah register berhasil
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['nama']    = $nama;
        $_SESSION['email']   = $email;
        $_SESSION['role']    = 'user';

        echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil!', 'redirect' => 'index.html']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan, coba lagi.']);
    }

    $stmt->close();
}

$conn->close();
?>