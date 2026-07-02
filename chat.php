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
    <title>Chat Admin</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="chat.css">
</head>

<body>

    <div class="chat-wrapper">

        <div class="chat-header">

            <div class="header-left">

                <a href="detail.php?id=<?= $field_id ?>" class="back-btn">

                    <i class="ti ti-arrow-left"></i>

                </a>

                <div>

                    <h2>Chat Admin</h2>

                    <p><?= $field['nama_lapangan']; ?></p>

                </div>

            </div>

        </div>

        <div class="chat-body" id="chatBox">

        </div>

        <div class="chat-footer">

            <input id="pesan" type="text" placeholder="Ketik pesan...">

            <button onclick="kirimPesan()">

                Kirim

            </button>

        </div>

    </div>
    <script>

        function loadChat() {

            fetch("load-chat.php?field_id=<?= $field_id ?>")

                .then(res => res.text())

                .then(data => {

                    document.getElementById("chatBox").innerHTML = data;

                    document.getElementById("chatBox").scrollTop =
                        document.getElementById("chatBox").scrollHeight;

                });

        }

        function kirimPesan() {

            let pesan = document.getElementById("pesan").value;

            if (pesan == "") return;

            fetch("kirim-chat.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body:
                    "field_id=<?= $field_id; ?>&pesan=" + encodeURIComponent(pesan)

            })

                .then(() => {

                    document.getElementById("pesan").value = "";

                    loadChat();

                });

        }
        loadChat();

        setInterval(loadChat, 1000);
    </script>
</body>

</html>