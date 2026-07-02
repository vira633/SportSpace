<?php

include "get-admin-dashboard.php";
include "get-booking-terbaru.php";
include "get-users.php";
include "get-verifikasi.php";
include "get-all-booking.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin — SportSpace</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
</head>

<body>
  
  <!-- TOAST NOTIFICATION -->
   <div id="toast" class="toast">
    <i class="ti ti-circle-check"></i>
    <span id="toastText">Berhasil!</span>
  </div>
  
  <!-- MODAL DETAIL USER -->
   <div class="modal-overlay" id="detailModal">
    <div class="detail-modal">
      <div class="modal-header">
        <h2>Detail User</h2>
        <button class="close-btn" onclick="closeDetailModal()"> <i class="ti ti-x"></i> </button>
      </div>
      <div class="detail-content">
        <div class="detail-avatar"> A </div>
        <h3>Riska Aprilia</h3>
        <p class="detail-role"> User SportSpace </p>
        <div class="detail-list">
          <div class="detail-item">
            <span>Email</span>
            <strong>riska@gmail.com</strong>
          </div>
          <div class="detail-item">
            <span>No HP</span>
            <strong>0812-3456-7890</strong>
          </div>
          <div class="detail-item">
            <span>Status</span>
            <strong>Aktif</strong>
          </div>
          <div class="detail-item">
            <span>Bergabung</span>
            <strong>Januari 2026</strong>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- NAVBAR -->
   <nav class="navbar">
    <a href="index.php"class="navbar-brand"> <i class="ti ti-bowling"></i>
      <span>SportSpace</span>
      <div class="dot"></div>
    </a>
    <div class="navbar-actions">
      <div class="notif-container">
        <div class="notif" onclick="toggleNotif()"> <i class="ti ti-bell"></i>
          <div class="notif-badge" id="notifBadge"> 3 </div>
        </div>
        <div class="notif-dropdown"
        id="notifDropdown">
        <div class="notif-item">
          <i class="ti ti-building"></i>
          <span> GOR baru menunggu verifikasi </span>
        </div>
        <div class="notif-item">
          <i class="ti ti-calendar-event"></i>
          <span> Booking baru berhasil masuk </span>
        </div>
        <div class="notif-item">
          <i class="ti ti-users"></i>
          <span> Ada user baru terdaftar </span>
        </div>
      </div>
    </div>
    <a href="login.html">
      <button class="btn btn-outline btn-sm"> <i class="ti ti-logout"> </i> Keluar </button>
    </a>
  </div>
</nav>

<!-- LAYOUT -->
 <div class="dashboard-layout">
  
  <!-- SIDEBAR -->
   <aside class="sidebar">
    <div>
      <div class="sidebar-section"> MENU </div>
      <div class="sidebar-menu">
        <div class="sidebar-item active" onclick="showSection('dashboard', this)"> <i class="ti ti-home"></i>
          <span>Dashboard</span>
        </div>
        <div class="sidebar-item" onclick="showSection('venue', this)"> <i class="ti ti-building"></i>
          <span>Verifikasi GOR</span>
        </div>
        <div class="sidebar-item" onclick="showSection('booking', this)"> <i class="ti ti-calendar-event"></i>
          <span>Semua Booking</span>
        </div>
        <div class="sidebar-item" onclick="showSection('user', this)"> <i class="ti ti-users"></i>
          <span>Kelola User</span>
        </div>
      </div>
      <div class="sidebar-section extra"> LAINNYA </div>
      <div class="sidebar-menu">
        <div class="sidebar-item" onclick="showSection('setting', this)"> <i class="ti ti-settings"></i>
          <span>Pengaturan</span>
        </div>
        <a href="login.html" class="logout-link">
          <div class="sidebar-item logout">
            <i class="ti ti-logout"></i>
            <span>Keluar</span>
          </div>
        </a>
      </div>
    </div>
  </aside>
  
  <!-- CONTENT -->
   <main class="dashboard-content">
    
    <!-- DASHBOARD -->
     <section id="section-dashboard">
      <div class="top-header">
        <div>
          <h1 class="page-title"> Dashboard Admin </h1>
          <p class="page-sub"> Selamat datang! Pantau semua aktivitas platform di sini. </p>
        </div>
        <div class="date-card"> <i class="ti ti-calendar"> </i> Rabu, 14 Mei 2026 </div>
      </div>

       <!-- STATS -->
<div class="stats-grid">

    <!-- Total User -->
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-value"><?= $totalUser ?></div>
                <div class="stat-label">Total User</div>
            </div>
            <div class="stat-icon blue-bg">
                <i class="ti ti-users"></i>
            </div>
        </div>
    </div>

    <!-- Total Owner -->
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-value"><?= $totalOwner ?></div>
                <div class="stat-label">Total Owner</div>
            </div>
            <div class="stat-icon green-bg">
                <i class="ti ti-user-star"></i>
            </div>
        </div>
    </div>

    <!-- Total Lapangan -->
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-value"><?= $totalLapangan ?></div>
                <div class="stat-label">Total Lapangan</div>
            </div>
            <div class="stat-icon amber-bg">
                <i class="ti ti-building-stadium"></i>
            </div>
        </div>
    </div>

    <!-- Booking Hari Ini -->
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-value"><?= $totalBookingHariIni ?></div>
                <div class="stat-label">Booking Hari Ini</div>
            </div>
            <div class="stat-icon blue-bg">
                <i class="ti ti-calendar-event"></i>
            </div>
        </div>
    </div>

    <!-- Booking Pending -->
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-value"><?= $totalPending ?></div>
                <div class="stat-label">Booking Pending</div>
            </div>
            <div class="stat-icon red-bg">
                <i class="ti ti-clock-hour-4"></i>
            </div>
        </div>
    </div>

    <!-- Booking Selesai -->
    <div class="stat-card">
        <div class="stat-top">
            <div>
                <div class="stat-value"><?= $totalBookingSelesai ?></div>
                <div class="stat-label">Booking Selesai</div>
            </div>
            <div class="stat-icon green-bg">
                <i class="ti ti-circle-check"></i>
            </div>
        </div>
    </div>

</div>
      
      <!-- BOOKING TERBARU -->
       <div class="card">
        <div class="card-header">
          <div class="card-title"> <i class="ti ti-file-invoice"> </i> Booking Terbaru </div>
          <button class="btn btn-outline btn-sm" onclick="openBookingSection()"> Lihat Semua </button>
        </div>
        <div class="table-wrapper">
          <table class="table">
            <thead>
              <tr>
                <th>Kode</th>
                <th>User</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($queryBookingTerbaru)) : ?>
                <tr>
                  <td><?= $row['booking_code']; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['nama_lapangan']; ?></td>
                  <td><?= $row['tanggal']; ?></td>
                  <td>Rp<?= number_format($row['total'], 0, ",", ".") ?></td>
                  <td>
                    <?php
                    $status = strtolower($row['status']);
                    
                    if($status == "terkonfirmasi"){
                      echo '<span class="status-badge success">Terkonfirmasi</span>';
                    }
                    elseif($status == "tertunda"){
                      echo '<span class="status-badge warning">Tertunda</span>';
                    }
                    elseif($status == "dibatalkan"){
                      echo '<span class="status-badge danger">Dibatalkan</span>';
                    }
                    else{
                      echo '<span class="status-badge">'.$row['status'].'</span>';
                    }
                    ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
      
      <!-- VERIFIKASI -->
       <section id="section-venue" class="hidden">
        <div class="top-header">
          <div>
            <h1 class="page-title"> Verifikasi GOR </h1>
            <p class="page-sub"> Kelola dan verifikasi GOR baru sebelum tampil di platform. </p>

            <div class="filter-status">

    <a href="dashboard-admin.php?filter=semua#section-venue" class="filter-btn">
        Semua
    </a>

    <a href="dashboard-admin.php?filter=pending#section-venue" class="filter-btn">
        Pending
    </a>

    <a href="dashboard-admin.php?filter=diterima#section-venue" class="filter-btn">
        Diterima
    </a>

    <a href="dashboard-admin.php?filter=ditolak#section-venue" class="filter-btn">
        Ditolak
    </a>

</div>

          </div>
        </div>

        <div class="venue-grid">
          <?php if(mysqli_num_rows($queryVerifikasi) > 0): ?>
            <?php while($venue = mysqli_fetch_assoc($queryVerifikasi)) : ?>

            <div class="venue-card">
              <div class="venue-top">

                <div class="venue-icon">
                  <i class="ti ti-building-stadium"></i>
                </div>

                <?php
                $badge = "badge-amber";
                if($venue['verifikasi'] == "diterima"){
                  $badge = "badge-green";
                }
                elseif($venue['verifikasi'] == "ditolak"){
                  $badge = "badge-red";
                }
                ?>

                <span class="badge <?= $badge; ?>">
                  <?= ucfirst($venue['verifikasi']); ?>
                </span>
              </div>
              
              <h3 class="venue-title">
                <?= $venue['nama_lapangan']; ?>
              </h3>
              
              <div class="venue-location">
                <i class="ti ti-map-pin"></i>
                <?= $venue['lokasi']; ?>
              </div>
              
              <div class="venue-info-list">

                <div>
                  <i class="ti ti-user"></i>
                  Pemilik:
                  <?= $venue['owner_name'] ?? '-'; ?>
                </div>
                
                <div>
                  <i class="ti ti-circle-check"></i>
                  Status:
                  <?= $venue['status']; ?>
                </div>
              </div>
              
              <div class="venue-actions">
                <a
                  href="approve-gor.php?id=<?= $venue['field_id']; ?>"
                  class="btn btn-primary btn-sm"
                  onclick="return confirm('Yakin ingin menerima GOR ini?')">
                  Terima
                </a>
                
                <a
                  href="reject-gor.php?id=<?= $venue['field_id']; ?>"
                  class="btn btn-outline btn-sm reject-btn"
                  onclick="return confirm('Yakin ingin menolak GOR ini?')">
                  Tolak
                </a>
              </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
              <div class="empty-state">
                <i class="ti ti-building-stadium"></i>
                <h3>Belum ada GOR yang menunggu verifikasi</h3>
                <p>Semua pengajuan GOR sudah diproses.</p>
              </div>
              <?php endif; ?>
            </div>
          </section>
      
      <!-- BOOKING -->
       <section id="section-booking" class="hidden">
        <div class="top-header">
          <div>
            <h1 class="page-title"> Semua Booking </h1>
            <p class="page-sub"> Pantau seluruh transaksi booking pengguna SportSpace. </p>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="card-title"> <i class="ti ti-receipt"> </i> Data Booking </div>
          </div>
          <div class="table-wrapper">
            <table class="table">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>User</th>
                  <th>Lapangan</th>
                  <th>Tanggal</th>
                  <th>Jam</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php while($booking = mysqli_fetch_assoc($queryAllBooking)) : ?>
                  <tr>
                    <td><?= $booking['booking_code']; ?></td>
                    <td><?= $booking['nama']; ?></td>
                    <td><?= $booking['nama_lapangan']; ?></td>
                    <td><?= $booking['tanggal']; ?></td>
                    <td>
                      <?= $booking['jam_mulai']; ?>
                      -
                      <?= $booking['jam_selesai']; ?>
                    </td>
                    <td>
                      Rp <?= number_format($booking['harga'],0,',','.'); ?>
                    </td>
                    <td><?= ucfirst($booking['status']); ?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      
      <!-- USER -->
       <section id="section-user" class="hidden">
        <div class="top-header">
          <div>
            <h1 class="page-title"> Kelola User </h1>
            <p class="page-sub"> Pantau akun pengguna dan owner yang terdaftar. </p>
          </div>
        </div>
        <div class="user-grid">
          <?php while($user = mysqli_fetch_assoc($queryUsers)) : ?>
            <div class="user-card">

              <div class="user-top">

                <div class="user-avatar">
                  <?= strtoupper(substr($user['nama'],0,1)); ?>
                </div>

                <span class="badge badge-blue">
                  <?= ucfirst($user['role']); ?>
                </span>
              </div>

              <h3 class="user-name">
                <?= $user['nama']; ?>
              </h3>

              <div class="user-email">
                <?= $user['email']; ?>
              </div>

              <div class="user-role">
                Role : <?= $user['role']; ?>
              </div>

              <div class="user-actions">

                <button class="btn btn-outline btn-sm">
                  Detail
                </button>

                <button class="btn btn-outline btn-sm reject-btn">
                  Ban
                </button>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
        </section>
      
      <!-- SETTING -->
       <section id="section-setting" class="hidden">
        <div class="top-header">
          <div>
            <h1 class="page-title"> Pengaturan </h1>
            <p class="page-sub"> Atur konfigurasi utama platform SportSpace. </p> </div>
          </div>
          <div class="setting-grid">
            <div class="setting-card">
              <h3> Pengaturan Platform </h3>
              <div class="form-group">
                <label> Nama Platform </label>
                <input type="text" value="SportSpace">
              </div>
              <div class="form-group">
                <label> Email Admin </label>
                <input type="email" value="admin@sportspace.com">
              </div>
              <button class="btn btn-primary btn-sm" onclick="showToast('Perubahan berhasil disimpan!')"> Simpan Perubahan </button>
            </div>
          </div>
        </section>
      </main>
    </div>

    <?php
    $toast = "";
    if(isset($_GET['notif'])){
      if($_GET['notif'] == "approve"){
        $toast = "GOR berhasil diterima.";
      }
      elseif($_GET['notif'] == "reject"){
        $toast = "GOR berhasil ditolak.";
      }
    }
    ?>
    
    <script>
      console.log("SCRIPT BERJALAN");

      window.addEventListener("load", function(){

    <?php if($toast != ""): ?>
        showToast("<?= $toast ?>");

        const url = new URL(window.location);
        url.searchParams.delete("notif");
        history.replaceState({}, "", url);
    <?php endif; ?>

    const hash = window.location.hash;

    if(hash === "#section-venue"){
        showSection("venue", document.querySelectorAll(".sidebar-item")[1]);
    }
    else if(hash === "#section-booking"){
        showSection("booking", document.querySelectorAll(".sidebar-item")[2]);
    }
    else if(hash === "#section-user"){
        showSection("user", document.querySelectorAll(".sidebar-item")[3]);
    }
    else if(hash === "#section-setting"){
        showSection("setting", document.querySelectorAll(".sidebar-item")[4]);
    }

});

    function showSection(name, item){
      document
      .querySelectorAll('[id^="section-"]')
      .forEach(section => {
        section.classList.add('hidden');
      });

      document
      .getElementById('section-' + name)
      .classList.remove('hidden');

      document
      .querySelectorAll('.sidebar-item')
      .forEach(menu => {
        menu.classList.remove('active');
      });

      item.classList.add('active');
    }

    function openBookingSection(){
      document
      .querySelectorAll('[id^="section-"]')
      .forEach(section => {
        section.classList.add('hidden');
      });

      document
      .getElementById('section-booking')
      .classList.remove('hidden');

      document
      .querySelectorAll('.sidebar-item')
      .forEach(menu => {
        menu.classList.remove('active');
      });

      document
      .querySelectorAll('.sidebar-item')[2]
      .classList.add('active');
    }

    function toggleProfileMenu(){
      const dropdown =
      document.getElementById('profileDropdown');
      dropdown.classList.toggle('active');
    }

    function showToast(message){
      const toast =
      document.getElementById('toast');
      const toastText =
      document.getElementById('toastText');
      toastText.innerText = message;
      toast.classList.add('show');

      setTimeout(() => {
        toast.classList.remove('show');
      }, 3000);
    }

    function openDetailModal(){
      document
      .getElementById('detailModal')
      .classList.add('active');
    }

    function closeDetailModal(){
      document
      .getElementById('detailModal')
      .classList.remove('active');
    }
    
    function toggleNotif(){
      const dropdown =
      document.getElementById('notifDropdown');
      const badge =
      document.getElementById('notifBadge');
      dropdown.classList.toggle('active');
      if(dropdown.classList.contains('active')){
         badge.style.display = 'none';
        }
      }
      window.addEventListener('click', function(e){
        if(
          !e.target.closest('.notif-container')
        ){
          const notif =
          document.getElementById('notifDropdown');
          
          if(notif){
            notif.classList.remove('active');
          }
        }
      }
    );

    window.addEventListener("load", function () {

    const hash = window.location.hash;

    if(hash === "#section-venue"){
        showSection("venue", document.querySelectorAll(".sidebar-item")[1]);
    }
    else if(hash === "#section-booking"){
        showSection("booking", document.querySelectorAll(".sidebar-item")[2]);
    }
    else if(hash === "#section-user"){
        showSection("user", document.querySelectorAll(".sidebar-item")[3]);
    }
    else if(hash === "#section-setting"){
        showSection("setting", document.querySelectorAll(".sidebar-item")[4]);
    }

});
    
    </script>
    </body>
    </html>