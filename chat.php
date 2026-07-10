<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['field_id'])) {
    die("Lapangan tidak ditemukan.");
}

$field_id = (int) $_GET['field_id'];

$query = mysqli_query($conn, "
SELECT *
FROM fields
WHERE field_id = '$field_id'
");

$field = mysqli_fetch_assoc($query);

if (!$field) {
    die("Lapangan tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Chat Owner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="chat.css">
</head>

<body>
    <nav class="navbar">

        <div class="navbar-left">

            <div class="navbar-brand">

                <i class="ti ti-bowling"></i>

                <span>SportSpace</span>

                <div class="dot"></div>

            </div>

        </div>

    </nav>


    <div class="chat-wrapper">

        <div class="chat-header">

            <a href="detail.php?id=<?= $field_id ?>" class="back-btn">
                <i class="ti ti-arrow-left"></i>
            </a>

            <div class="conv-avatar">
                A
            </div>

            <div class="chat-title">

                <h3>Owner Lapangan</h3>

                <p><?= $field['nama_lapangan']; ?></p>

            </div>

        </div>

        <div class="chat-body" id="chatBox">

        </div>

        <div class="chat-footer">

            <input id="pesan" type="text" placeholder="Ketik pesan...">

            <button id="btnKirim" onclick="kirimPesan()">

                <i class="ti ti-send"></i>

            </button>

        </div>

    </div>

    <script>
        let lastChat = "";
        function loadChat(auto = true) {

            fetch("load-chat.php?field_id=<?= $field_id ?>")

                .then(res => res.text())

                .then(data => {

                    if (auto && data === lastChat) {
                        return;
                    }

                    lastChat = data;

                    const box = document.getElementById("chatBox");

                    const sedangDiBawah =
                        box.scrollHeight - box.scrollTop - box.clientHeight < 120;

                    box.innerHTML = data;

                    if (!auto || sedangDiBawah) {

                        box.scrollTop = box.scrollHeight;

                    }

                });

        }
        function kirimPesan() {

            const input = document.getElementById("pesan");

            const btn = document.getElementById("btnKirim");

            const pesan = input.value.trim();

            if (pesan === "" || btn.disabled) return;

            btn.disabled = true;

            fetch("kirim-chat.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body:
                    "field_id=<?= $field_id ?>&pesan=" + encodeURIComponent(pesan)

            })

                .then(() => {

                    input.value = "";

                    input.focus();

                    btn.disabled = false;

                    setTimeout(function () {

                        loadChat(false);

                    }, 150);

                })

                .catch(() => {

                    btn.disabled = false;

                });

        }
        const inputPesan = document.getElementById("pesan");

        inputPesan.addEventListener("keydown", function (e) {

            if (e.key === "Enter" && !e.shiftKey) {

                e.preventDefault();

                kirimPesan();

            }

        });

        loadChat();

        setInterval(loadChat, 3000);
    </script>
</body>

</html>