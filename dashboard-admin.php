<?php
session_start();

include "get-admin-dashboard.php";
include "get-booking-terbaru.php";
include "get-users.php";
include "get-verifikasi.php";
include "get-all-booking.php";
include "get-admin-profile.php";

?>

<?php

date_default_timezone_set("Asia/Jakarta");

$hari = [
    "Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"
];

$bulan = [
    1=>"Januari","Februari","Maret","April","Mei","Juni",
    "Juli","Agustus","September","Oktober","November","Desember"
];

$today =
$hari[date("w")] . ", " .
date("d") . " " .
$bulan[(int)date("n")] . " " .
date("Y");

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

        <div class="detail-avatar" id="detailAvatar">A</div>

        <h3 id="detailNama"></h3>

        <p class="detail-role" id="detailRole"></p>

        <div class="detail-list">

          <div class="detail-item">
            <span><i class="ti ti-mail"></i> Email</span>
            <strong id="detailEmail"></strong>
          </div>

          <div class="detail-item">
            <span><i class="ti ti-phone"></i> No HP</span>
            <strong id="detailTelepon"></strong>
          </div>

          <div class="detail-item">
            <span><i class="ti ti-calendar"></i> Bergabung</span>
            <strong id="detailCreated"></strong>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ================= Detail Lapangan ================= -->
<div class="modal-overlay" id="fieldDetailModal">

  <div class="detail-modal">

    <div class="modal-header">
      <h2>Detail Lapangan</h2>

      <button class="close-btn" onclick="closeFieldDetail()">
        <i class="ti ti-x"></i>
      </button>
    </div>

    <div class="detail-content">

      <!-- Foto -->
      <div class="field-photo">
        <img id="fieldImage" src="" alt="Foto Lapangan">
      </div>

      <!-- Nama -->
      <h3 id="fieldNama"></h3>

      <!-- Jenis -->
      <p class="detail-role" id="fieldJenis"></p>

      <div class="detail-list">

        <div class="detail-item">
          <span><i class="ti ti-user"></i> Pemilik</span>
          <strong id="fieldOwner"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-phone"></i> No HP</span>
          <strong id="fieldPhone"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-map-pin"></i> Lokasi</span>
          <strong id="fieldLokasi"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-cash"></i> Harga / Jam</span>
          <strong id="fieldHarga"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-users"></i> Kapasitas</span>
          <strong id="fieldKapasitas"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-layout-grid"></i> Jenis Lantai</span>
          <strong id="fieldLantai"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-clock"></i> Jam Operasional</span>
          <strong id="fieldJam"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-file-description"></i> Deskripsi</span>
          <strong id="fieldDeskripsi"></strong>
        </div>

        <div class="detail-item">
          <span><i class="ti ti-circle-check"></i> Status Verifikasi</span>
          <span id="fieldVerifikasi"></span>
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

          <span
            class="notif-badge"
            id="notifBadge"

            <?php if($totalNotif == 0): ?>
                style="display:none;"
            <?php endif; ?>
            >
            <?= $totalNotif ?>
          </span>

        </div>

        <div class="notif-dropdown" id="notifDropdown">

        <?php if($notifLapangan > 0): ?>
        <div 
          class="notif-item"
          id="notifLapanganItem">
          <i class="ti ti-building"></i>
          <span>
            <?= $notifLapangan ?>
            lapangan menunggu verifikasi
          </span>
        </div>
        <?php endif; ?>

        <?php if($notifBooking > 0): ?>
        <div class="notif-item">
            <i class="ti ti-calendar-event"></i>
            <span>
                <?= $notifBooking ?>
                booking baru hari ini
            </span>
        </div>
        <?php endif; ?>

        <?php if($notifUser > 0): ?>
        <div class="notif-item">
            <i class="ti ti-user-plus"></i>
            <span>
                <?= $notifUser ?>
                user baru hari ini
            </span>
        </div>
        <?php endif; ?>

        <?php if(
            $notifLapangan == 0 &&
            $notifBooking == 0 &&
            $notifUser == 0
        ): ?>

        <div class="notif-empty">
            Tidak ada notifikasi baru.
        </div>

        <?php endif; ?>

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

        <div class="sidebar-item" onclick="showSection('venue', this)">
          <i class="ti ti-building"></i>
          <span>Verifikasi Lapangan</span>

          <span
            class="menu-badge"
            id="sidebarVenueBadge"

            <?php if($notifLapangan == 0): ?>
                style="display:none;"
            <?php endif; ?>
            >
            <?= $notifLapangan ?>
          </span>
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
   <main class="dashboard-content loading" id="dashboardContent">
    
    <!-- DASHBOARD -->
     <section id="section-dashboard">
      <div class="top-header">

        <div>
          <h1 class="page-title"> Dashboard Admin </h1>
          <p class="page-sub"> Selamat datang! Pantau semua aktivitas platform di sini. </p>
        </div>

        <div class="date-card">
          <i class="ti ti-calendar"></i>
          <?= $today ?>
        </div>

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
                <div class="stat-label">Menunggu Verifikasi</div>
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
                <th>Jam</th>
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
                  <td>
                    <?= $row['jam_mulai']; ?>
                    -
                    <?= $row['jam_selesai']; ?>
                  </td>
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
                    elseif($status == "selesai"){
                      echo '<span class="status-badge info">Selesai</span>';
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
            <h1 class="page-title"> Verifikasi Lapangan </h1>
            <p class="page-sub"> Kelola dan verifikasi Lapangan baru sebelum tampil di platform. </p>

            <div class="filter-status">
              <a href="dashboard-admin.php?filter=semua"
                class="filter-btn <?= $filter=='semua' ? 'active' : '' ?>">
                Semua (<?= $totalSemua ?>)
              </a>
              
              <a href="dashboard-admin.php?filter=pending"
                class="filter-btn <?= $filter=='pending' ? 'active' : '' ?>">
                Tertunda (<?= $totalPending ?>)
              </a>
              
              <a href="dashboard-admin.php?filter=diterima"
                class="filter-btn <?= $filter=='diterima' ? 'active' : '' ?>">
                Diterima (<?= $totalDiterima ?>)
              </a>
              
             <a href="dashboard-admin.php?filter=ditolak"
              class="filter-btn <?= $filter=='ditolak' ? 'active' : '' ?>">
              Ditolak (<?= $totalDitolak ?>)
            </a>
            </div>
          </div>
        </div>

          <?php if(mysqli_num_rows($queryVerifikasi) > 0): ?>
            <div class="venue-grid">
              <?php while($venue = mysqli_fetch_assoc($queryVerifikasi)) : ?>

            <div class="venue-card">
              <div class="venue-top">

                <div class="venue-icon">

                  <?php if(!empty($venue['gambar'])){ ?>

                  <img
                    src="uploads/fields/<?= $venue['gambar']; ?>"
                    alt="<?= $venue['nama_lapangan']; ?>">

                  <?php }else{ ?>
                    <i class="ti ti-building-stadium"></i>

                  <?php } ?>
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

                <div id="venue-status-<?= $venue['field_id']; ?>">
                  <span class="badge <?= $badge; ?>">
                    <?= ucfirst($venue['verifikasi']); ?>
                  </span>
                </div>

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
                  <i class="ti ti-activity"></i>
                  Jenis:
                  <?= $venue['jenis']; ?>
                </div>
              </div>
              
              <?php if($venue['verifikasi'] == 'pending'){ ?>
              
              <div
                class="venue-actions"
                id="venue-actions-<?= $venue['field_id']; ?>">

              <button
                type="button"
                class="btn btn-primary btn-sm"
                onclick="approveVenue(<?= $venue['field_id']; ?>)">
                Terima
              </button>

              <button
                type="button"
                class="btn btn-outline btn-sm reject-btn"
                onclick="rejectVenue(<?= $venue['field_id']; ?>)">
                Tolak
              </button>

              <button
                  class="btn btn-outline btn-sm"
                  onclick="openFieldDetail(<?= $venue['field_id']; ?>)">
                  Detail
              </button>
            </div>
            <?php } else { ?>
            
            <div class="venue-actions-single">

            <button
                class="btn btn-outline btn-sm"
                onclick="openFieldDetail(<?= $venue['field_id']; ?>)">
                Detail
            </button>
          </div>
          <?php } ?>

            </div>
            <?php endwhile; ?>
            </div>

            <?php else: ?>
              <div class="empty-state">
                <i class="ti ti-building-stadium"></i>
                <h3>Belum ada GOR yang menunggu verifikasi</h3>
                <p>Semua pengajuan GOR sudah diproses.</p>
              </div>
              <?php endif; ?>
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
                    <td style="white-space: nowrap;">
                      <?= $booking['jam_mulai']; ?>
                      -
                      <?= $booking['jam_selesai']; ?>
                    </td>
                    <td>
                      Rp <?= number_format($booking['harga'],0,',','.'); ?>
                    </td>
                    <td>
                      
                      <?php
                      $status = strtolower(trim($booking['status']));
                      if($status == "terkonfirmasi"){
                        echo '<span class="status-badge success">Terkonfirmasi</span>';
                      }
                      elseif($status == "tertunda"){
                        echo '<span class="status-badge warning">Tertunda</span>';
                      }
                      elseif($status == "dibatalkan"){
                        echo '<span class="status-badge danger">Dibatalkan</span>';
                      }
                      elseif($status == "selesai"){
                        echo '<span class="status-badge info">Selesai</span>';
                      }
                      else{
                        echo '<span class="status-badge">'.ucfirst($booking['status']).'</span>';
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

            <div class="user-card" id="user-card-<?= $user['user_id']; ?>">

            <?php
                $role = strtolower($user['role']);
                
                $badgeRole = "role-user";
                $avatarRole = "avatar-user";
                
                if($role == "owner"){
                  $badgeRole = "role-owner";
                  $avatarRole = "avatar-owner";
                }
                elseif($role == "admin"){
                  $badgeRole = "role-admin";
                  $avatarRole = "avatar-admin";
                }
                ?>

              <div class="user-top">

                <div class="user-avatar <?= $avatarRole ?>">
                  <?= strtoupper(substr($user['nama'],0,1)); ?>
                </div>
                
                <span class="role-badge <?= $badgeRole ?>">
                  <?= ucfirst($user['role']); ?>
                </span>
              </div>

              <h3 class="user-name">
                <?= $user['nama']; ?>
              </h3>

              <div class="user-email">
                <?= $user['email']; ?>
              </div>

              <div
                class="user-status"
                id="user-status-<?= $user['user_id']; ?>">

                <?php if($user['aktif'] == 'aktif'){ ?>
                <span class="badge badge-green">Aktif</span>
                <?php } else { ?>
                <span class="badge badge-red">Diban</span>
                <?php } ?>
              </div>

              <div
                class="user-actions"
                id="user-actions-<?= $user['user_id']; ?>">

              <button
                  class="btn btn-outline btn-sm"
                  onclick="openDetailModal(<?= $user['user_id']; ?>)">
                  Detail
              </button>
              
              <?php if($user['aktif'] == 'aktif'){ ?>

              <button
                type="button"
                class="btn btn-outline btn-sm reject-btn"
                onclick="banUser(<?= $user['user_id']; ?>)">
                Ban
              </button>
              
              <?php } else { ?>

              <button
                  type="button"
                  class="btn btn-primary btn-sm"
                  onclick="aktifkanUser(<?= $user['user_id']; ?>)">
                  Aktifkan
              </button>
              
              <?php } ?>

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
            <p class="page-sub"> Kelola informasi akun dan keamanan administrator. </p> </div>
          </div>

          <div class="setting-grid">

            <div class="setting-card">

              <h3>
                <i class="ti ti-user-circle"></i>
                Profil Admin
              </h3>
              
              <form
                id="profileForm"
                onsubmit="return updateProfile(event)">

              <div class="form-group">
                <label> Nama Lengkap </label>
                <input
                  type="text"
                  id="profileNama"
                  name="nama"
                  value="<?= $admin['nama']; ?>">
              </div>

              <div class="form-group">
                <label> Alamat Email </label>
                <input
                  type="email"
                  id="profileEmail"
                  name="email"
                  value="<?= $admin['email']; ?>">
              </div>

              <button
                type="submit"
                class="btn btn-primary btn-sm">
                Perbarui Profil
              </button>

            </form>
          </div>

          <div class="setting-card">

            <h3>
              <i class="ti ti-lock-password"></i>
              Ubah Password
            </h3>

            <form
              action="update-password-admin.php"
              method="POST"
              onsubmit="sessionStorage.setItem('activeSection','setting')">

              <div class="form-group">
                <label>Password Lama</label>
                <input
                  type="password"
                  name="password_lama"
                  placeholder="Masukkan password lama"
                  required>
              </div>
              
              <div class="form-group">
                <label>Password Baru</label>
                <input
                  type="password"
                  name="password_baru"
                  placeholder="Masukkan password baru"
                  required>
              </div>
              
              <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input
                  type="password"
                  name="konfirmasi_password"
                  placeholder="Ulangi password baru"
                  required>
              </div>
              
              <button
                type="submit"
                class="btn btn-primary btn-sm">
                Ubah Password
              </button>
            </form>
          </div>
        </div>  
      </section>
    </main>
  </div>
  
  <?php
$toast = "";

if(isset($_GET['notif'])){

    if($_GET['notif'] == "approve"){
        $toast = "Lapangan berhasil diterima.";
    }
    elseif($_GET['notif'] == "reject"){
        $toast = "Lapangan berhasil ditolak.";
    }
    elseif($_GET['notif'] == "user_banned"){
      $toast = "User berhasil diban.";
    }
    elseif($_GET['notif'] == "user_active"){
      $toast = "User berhasil diaktifkan kembali.";
    }
    elseif($_GET['notif'] == "profil"){
        $toast = "Profil admin berhasil diperbarui.";
    }
    elseif($_GET['notif'] == "gagal"){
        $toast = "Gagal memperbarui profil.";
    }
    elseif($_GET['notif'] == "passwordlama"){
        $toast = "Password lama salah.";
    }
    elseif($_GET['notif'] == "passwordpendek"){
        $toast = "Password baru minimal 8 karakter.";
    }
    elseif($_GET['notif'] == "passwordbeda"){
        $toast = "Konfirmasi password tidak sama.";
    }
    elseif($_GET['notif'] == "passwordberhasil"){
        $toast = "Password berhasil diperbarui.";
    }
    }
    ?>
    
    <script>
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

      // Simpan menu yang sedang dibuka
      sessionStorage.setItem("activeSection", name);
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

      sessionStorage.setItem("activeSection","booking");
    }

    function toggleProfileMenu(){
      const dropdown =
      document.getElementById('profileDropdown');
      dropdown.classList.toggle('active');
    }

    function showToast(message){

    const toast = document.getElementById("toast");
    const toastText = document.getElementById("toastText");

    // Reset animasi
    toast.classList.remove("show");

    // Paksa browser me-render ulang
    void toast.offsetWidth;

    toastText.innerText = message;

    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    },3000);

}

function updateNotificationBadge(){

    // Badge sidebar
    const sidebarBadge = document.getElementById("sidebarVenueBadge");

    if(sidebarBadge){

        let total = parseInt(sidebarBadge.innerText);

        total--;

        if(total <= 0){

            sidebarBadge.style.display = "none";

        }else{

            sidebarBadge.innerText = total;

        }

    }

    // Badge lonceng
    const notifBadge = document.getElementById("notifBadge");

    if(notifBadge){

        let total = parseInt(notifBadge.innerText);

        total--;

        if(total <= 0){

            notifBadge.style.display = "none";

        }else{

            notifBadge.innerText = total;

        }

    }

    // Item dropdown
    const notifItem = document.getElementById("notifLapanganItem");

    if(notifItem && sidebarBadge && sidebarBadge.style.display != "none"){

        notifItem.querySelector("span").innerHTML =
            sidebarBadge.innerText +
            " lapangan menunggu verifikasi";

    }
    else if(notifItem){

        notifItem.remove();

    }

}

function refreshNotifications(){

    fetch("get-notification-count.php")
    .then(response => response.json())
    .then(data => {

        // ==========================
        // Badge lonceng
        // ==========================
        const notifBadge = document.getElementById("notifBadge");

        if(data.total > 0){

            notifBadge.style.display = "flex";
            notifBadge.innerText = data.total;

        }else{

            notifBadge.style.display = "none";

        }

        // ==========================
        // Badge sidebar
        // ==========================
        const sidebarBadge =
        document.getElementById("sidebarVenueBadge");

        if(data.lapangan > 0){

            sidebarBadge.style.display = "flex";
            sidebarBadge.innerText = data.lapangan;

        }else{

            sidebarBadge.style.display = "none";

        }

        // ==========================
        // Dropdown
        // ==========================
        const dropdown =
        document.getElementById("notifDropdown");

        let html = "";

        if(data.lapangan > 0){

            html += `
            <div class="notif-item">
                <i class="ti ti-building"></i>
                <span>${data.lapangan} lapangan menunggu verifikasi</span>
            </div>`;
        }

        if(data.booking > 0){

            html += `
            <div class="notif-item">
                <i class="ti ti-calendar-event"></i>
                <span>${data.booking} booking baru hari ini</span>
            </div>`;
        }

        if(data.user > 0){

            html += `
            <div class="notif-item">
                <i class="ti ti-user-plus"></i>
                <span>${data.user} user baru hari ini</span>
            </div>`;
        }

        if(html == ""){

            html = `
            <div class="notif-empty">
                Tidak ada notifikasi baru.
            </div>`;
        }

        dropdown.innerHTML = html;

    });

}

    function openDetailModal(id){

    fetch("get-user-detail.php?id=" + id)
    .then(response => response.json())
    .then(user => {

        document.getElementById("detailAvatar").innerHTML =
            user.nama.charAt(0).toUpperCase();

        const avatar = document.getElementById("detailAvatar");
        avatar.classList.remove(
          "avatar-user",
          "avatar-owner",
        );
        
        if(user.role == "owner"){
          avatar.classList.add("avatar-owner");
        }
        else{
          avatar.classList.add("avatar-user");
        }

        document.getElementById("detailNama").innerHTML =
            user.nama;

        document.getElementById("detailRole").textContent =
        user.role.charAt(0).toUpperCase() + user.role.slice(1);

        document.getElementById("detailEmail").innerHTML =
            user.email;

        document.getElementById("detailTelepon").innerHTML =
            user.telepon ? user.telepon : "-";

        let tanggal = new Date(user.created_at);

        let bulan = [
            "Januari","Februari","Maret","April","Mei","Juni",
            "Juli","Agustus","September","Oktober","November","Desember"
        ];

        document.getElementById("detailCreated").innerHTML =
            bulan[tanggal.getMonth()] + " " + tanggal.getFullYear();

        document
            .getElementById("detailModal")
            .classList.add("active");

    });
}

    function closeDetailModal(){
      document
      .getElementById('detailModal')
      .classList.remove('active');
    }

    function closeFieldDetail(){
      document
      .getElementById("fieldDetailModal")
      .classList.remove("active");
    }

    function openFieldDetail(id){

    fetch("get-field-detail.php?id=" + id)
    .then(response => response.json())
    .then(field => {

    document.getElementById("fieldNama").innerHTML =
        field.nama_lapangan;

    document.getElementById("fieldJenis").textContent =
    field.jenis;

    document.getElementById("fieldOwner").innerHTML =
        field.owner_name || "-";

    document.getElementById("fieldPhone").innerHTML =
        field.owner_phone || "-";

    document.getElementById("fieldLokasi").innerHTML =
        field.lokasi || "-";

    document.getElementById("fieldHarga").innerHTML =
        "Rp " + Number(field.harga).toLocaleString("id-ID");

    document.getElementById("fieldKapasitas").innerHTML =
        field.kapasitas + " Orang";

    document.getElementById("fieldLantai").innerHTML =
        field.jenis_lantai || "-";

    document.getElementById("fieldJam").innerHTML =
        field.jam_operasional || "-";

    document.getElementById("fieldDeskripsi").innerHTML =
        field.deskripsi || "-";


// Status Verifikasi
let verifikasiClass = "badge-amber";

if(field.verifikasi == "diterima"){
    verifikasiClass = "badge-green";
}
else if(field.verifikasi == "ditolak"){
    verifikasiClass = "badge-red";
}

document.getElementById("fieldVerifikasi").innerHTML =
    `<span class="badge ${verifikasiClass}">
        ${field.verifikasi}
    </span>`;

    // Foto
    if(field.gambar && field.gambar != ""){

        document.getElementById("fieldImage").src =
        "uploads/fields/" + field.gambar;

    }else{

        document.getElementById("fieldImage").src =
            "images/no-image.png";

    }

    document
        .getElementById("fieldDetailModal")
        .classList.add("active");

});

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

    document.addEventListener("DOMContentLoaded", function(){

    <?php if($toast != ""): ?>
        showToast("<?= $toast ?>");

        const url = new URL(window.location);
        url.searchParams.delete("notif");
        history.replaceState({}, "", url);

    <?php endif; ?>
    
    const lastSection = sessionStorage.getItem("activeSection") || "dashboard";
    
    const menuMap = {
      dashboard: 0,
      venue: 1,
      booking: 2,
      user: 3,
      setting: 4
    };
    
    showSection(
      lastSection,
      document.querySelectorAll(".sidebar-item")[menuMap[lastSection]]
    );

    document
    .getElementById("dashboardContent")
    .classList.add("ready");

    refreshNotifications();
  }
);

function banUser(id){

    if(!confirm("Yakin ingin memban user ini?")){
        return;
    }

    fetch("ban-user-ajax.php",{
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"id="+id
    })
    .then(response => response.json())
    .then(result =>{

      if(result.success){
        showToast("User berhasil diban.");
        
        // Ubah badge status
        document.getElementById("user-status-" + id).innerHTML =
        '<span class="badge badge-red">Diban</span>';
        
        // Ubah tombol Ban menjadi Aktifkan
        document.getElementById("user-actions-" + id).innerHTML = `
        <button
            class="btn btn-outline btn-sm"
            onclick="openDetailModal(${id})">
            Detail
        </button>

        <button
            type="button"
            class="btn btn-primary btn-sm"
            onclick="aktifkanUser(${id})">
            Aktifkan
        </button>
        `;
      }
      else{
        alert("Gagal memban user.");
      }
    });
  }

  function aktifkanUser(id){

    if(!confirm("Aktifkan kembali akun ini?")){
        return;
    }

    fetch("aktifkan-user-ajax.php",{
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"id="+id
    })
    .then(response => response.json())
    .then(result =>{

        if(result.success){

            showToast("User berhasil diaktifkan.");

            // Badge
            document.getElementById("user-status-"+id).innerHTML =
            '<span class="badge badge-green">Aktif</span>';

            // Tombol
            document.getElementById("user-actions-"+id).innerHTML = `
                <button
                    class="btn btn-outline btn-sm"
                    onclick="openDetailModal(${id})">
                    Detail
                </button>

                <button
                    type="button"
                    class="btn btn-outline btn-sm reject-btn"
                    onclick="banUser(${id})">
                    Ban
                </button>
            `;

        }else{

            alert("Gagal mengaktifkan user.");

        }

    });
}

function updateProfile(event){

    event.preventDefault();

    const nama = document.getElementById("profileNama").value;
    const email = document.getElementById("profileEmail").value;

    fetch("update-admin-profile-ajax.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:
            "nama="+encodeURIComponent(nama)+
            "&email="+encodeURIComponent(email)

    })
    .then(response => response.text())
    .then(result => {

        console.log(result);

        try{

            result = JSON.parse(result);

            if(result.success){

                showToast("Profil berhasil diperbarui.");

            }else{

                alert("Gagal memperbarui profil.");

            }

        }catch(e){

            console.error("JSON Error :", result);

        }

    });

    return false;

}

function approveVenue(id){

    if(!confirm("Terima pengajuan lapangan ini?")){
        return;
    }

    fetch("approve-gor-ajax.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"id="+id

    })
    .then(response => response.json())
    .then(result =>{

        if(result.success){

            showToast("Lapangan berhasil diterima.");

            refreshNotifications();

            updateNotificationBadge();

            // Ubah badge
            document.getElementById("venue-status-"+id).innerHTML = `
                <span class="badge badge-green">
                    Diterima
                </span>
            `;

            // Ubah tombol
            document.getElementById("venue-actions-"+id).innerHTML = `
                <button
                    class="btn btn-outline btn-sm"
                    onclick="openFieldDetail(${id})"
                    style="width:100%;">
                    Detail
                </button>
            `;

        }else{

            alert("Gagal menerima lapangan.");

        }

    })
    .catch(error=>{
        console.error(error);
    });

}

function rejectVenue(id){

    if(!confirm("Tolak pengajuan lapangan ini?")){
        return;
    }

    fetch("reject-gor-ajax.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"id="+id

    })
    .then(response => response.json())
    .then(result =>{

        if(result.success){

            showToast("Lapangan berhasil ditolak.");

            refreshNotifications();

            updateNotificationBadge();

            // Badge
            document.getElementById("venue-status-"+id).innerHTML = `
                <span class="badge badge-red">
                    Ditolak
                </span>
            `;

            // Tombol
            document.getElementById("venue-actions-"+id).innerHTML = `
                <button
                    class="btn btn-outline btn-sm"
                    onclick="openFieldDetail(${id})"
                    style="width:100%;">
                    Detail
                </button>
            `;

        }else{

            alert("Gagal menolak lapangan.");

        }

    })
    .catch(error=>{
        console.error(error);
    });

}
    
    </script>
    </body>
    </html>