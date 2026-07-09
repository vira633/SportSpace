<?php
session_start();
include 'config.php';

if (!isset($_SESSION['owner_id'])) {
    die("Silakan login sebagai pemilik GOR terlebih dahulu.");
}

$owner_id = (int) $_SESSION['owner_id'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Pelanggan — SportSpace</title>
    <link rel="stylesheet" href="chat-admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-brand">
            <i class="ti ti-bowling"></i>
            SportSpace
        </div>

        <a href="dashboard-owner.php" class="back-dashboard">
            <i class="ti ti-arrow-left"></i>
            Kembali ke Dashboard
        </a>
    </nav>

    <div class="chat-admin-layout">

        <!-- SIDEBAR: DAFTAR PERCAKAPAN -->
        <div class="conv-sidebar" id="convSidebar">

            <div class="conv-sidebar-header">
                <h2>Pesan</h2>
                <p>Percakapan dengan pelanggan</p>
            </div>

            <div class="conv-search">
                <i class="ti ti-search"></i>
                <input type="text" id="searchConv" placeholder="Cari nama pelanggan...">
            </div>

            <div class="conv-list" id="convList">
                <div class="conv-empty">Memuat percakapan...</div>
            </div>

        </div>

        <!-- PANEL CHAT AKTIF -->
        <div class="chat-panel" id="chatPanel">

            <div class="chat-panel-empty" id="chatPanelEmpty">
                <i class="ti ti-message-2"></i>
                <p>Pilih percakapan di samping untuk mulai membalas</p>
            </div>

            <div id="chatPanelActive" style="display:none; flex:1; display:flex; flex-direction:column;">

                <div class="chat-panel-header">
                    <div class="conv-avatar" id="activeAvatar">--</div>
                    <div class="chat-panel-title">
                        <h3 id="activeNama">-</h3>
                        <p id="activeLapangan">-</p>
                    </div>
                </div>

                <div id="chatBoxAdmin"></div>

                <div class="chat-panel-footer">
                    <input type="text" id="pesanAdmin" placeholder="Ketik balasan...">
                    <button onclick="kirimBalasan()">
                        <i class="ti ti-send"></i>
                        Kirim
                    </button>
                </div>

            </div>

        </div>

    </div>

    <script>
        let activeFieldId = null;
        let activeUserId = null;
        let daftarPercakapan = [];

        function renderConvList(data) {

            const list = document.getElementById("convList");

            if (data.length === 0) {
                list.innerHTML = '<div class="conv-empty">Belum ada pesan masuk dari pelanggan.</div>';
                return;
            }

            const keyword = document.getElementById("searchConv").value.toLowerCase().trim();

            const filtered = data.filter(c =>
                keyword === "" || c.user_nama.toLowerCase().includes(keyword)
            );

            if (filtered.length === 0) {
                list.innerHTML = '<div class="conv-empty">Tidak ada hasil pencarian.</div>';
                return;
            }

            list.innerHTML = filtered.map(c => {

                const isActive = (c.field_id == activeFieldId && c.user_id == activeUserId);
                const isUnread = c.unread > 0;

                return `
                <div class="conv-item ${isActive ? 'active' : ''} ${isUnread ? 'unread' : ''}"
                     onclick="bukaChat(${c.field_id}, ${c.user_id}, '${c.user_nama.replace(/'/g, "\\'")}', '${c.nama_lapangan.replace(/'/g, "\\'")}', '${c.inisial}')">

                    <div class="conv-avatar">${c.inisial}</div>

                    <div class="conv-body">
                        <div class="conv-top-row">
                            <span class="conv-name">${c.user_nama}</span>
                            <span class="conv-time">${c.last_waktu}</span>
                        </div>
                        <div class="conv-field">${c.nama_lapangan}</div>
                        <div class="conv-preview">${c.last_pesan ?? ''}</div>
                    </div>

                    ${isUnread ? `<span class="conv-unread-badge">${c.unread}</span>` : ''}

                </div>`;

            }).join('');

        }

        function loadConvList() {

            fetch("get-chat-owner.php")
                .then(res => res.json())
                .then(data => {
                    daftarPercakapan = data;
                    renderConvList(data);
                })
                .catch(() => {});

        }

        function bukaChat(fieldId, userId, nama, lapangan, inisial) {

            activeFieldId = fieldId;
            activeUserId = userId;

            document.getElementById("chatPanelEmpty").style.display = "none";
            document.getElementById("chatPanelActive").style.display = "flex";

            document.getElementById("activeAvatar").textContent = inisial;
            document.getElementById("activeNama").textContent = nama;
            document.getElementById("activeLapangan").textContent = lapangan;

            loadChatBox();
            renderConvList(daftarPercakapan);
        }

        function loadChatBox() {

            if (!activeFieldId || !activeUserId) return;

            fetch(`load-chat-admin.php?field_id=${activeFieldId}&user_id=${activeUserId}`)
                .then(res => res.text())
                .then(data => {

                    const box = document.getElementById("chatBoxAdmin");
                    const wasAtBottom =
                        box.scrollHeight - box.scrollTop - box.clientHeight < 60;

                    box.innerHTML = data;

                    if (wasAtBottom) {
                        box.scrollTop = box.scrollHeight;
                    }

                    // sinkronkan badge unread setelah pesan ditandai terbaca
                    loadConvList();
                    if (typeof loadChatBadgeParent === "function") loadChatBadgeParent();

                });

        }

        function kirimBalasan() {

            const input = document.getElementById("pesanAdmin");
            const pesan = input.value.trim();

            if (pesan === "" || !activeFieldId || !activeUserId) return;

            fetch("kirim-chat-admin.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `field_id=${activeFieldId}&user_id=${activeUserId}&pesan=${encodeURIComponent(pesan)}`
            })
                .then(() => {
                    input.value = "";
                    loadChatBox();
                    loadConvList();
                });

        }

        document.getElementById("pesanAdmin")?.addEventListener("keydown", function (e) {
            if (e.key === "Enter") kirimBalasan();
        });

        document.getElementById("searchConv").addEventListener("input", () => renderConvList(daftarPercakapan));

        loadConvList();
        setInterval(loadConvList, 4000);
        setInterval(() => { if (activeFieldId) loadChatBox(); }, 3000);
    </script>

</body>

</html>