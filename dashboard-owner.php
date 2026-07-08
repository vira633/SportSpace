<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SESSION['open_section'])){
    $section = $_SESSION['open_section'];
    unset($_SESSION['open_section']);
}
elseif(isset($_GET['section'])){
    $section = $_GET['section'];
}
elseif(isset($_GET['week'])){
    $section = "jadwal";
}
else{
    $section = "dashboard";
}

include "config.php";
include "get-owner-dashboard.php";
include "get-owner-booking.php";
include "get-owner-profile.php";
include "get-owner-fields.php";
include "get-jadwal-info.php";
include "get-pending-booking.php";
include "get-owner-activity.php";
include "helper-time.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pemilik GOR — SportSpace</title>
  <link rel="stylesheet" href="owner.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
</head>
<body>

<?php if(isset($_SESSION['toast'])){ ?>

<div class="toast-success" id="toast-success">

    <i class="ti ti-circle-check"></i>

    <span>
        <?= $_SESSION['toast']; ?>
    </span>

</div>

<?php
unset($_SESSION['toast']);
}
?>

<nav class="navbar">
  
  <a href="index.php" class="navbar-brand">
    <i class="ti ti-bowling"></i>
    <span>SportSpace</span>
    <div class="dot"></div>
  </a>
  <div class="navbar-actions">
    <a href="index.php">
      <button class="btn btn-outline btn-sm">
        <i class="ti ti-logout"></i>
        Keluar
      </button>
    </a>
  </div>
</nav>

<div class="dashboard-layout">

  <aside class="sidebar">
    <div class="sidebar-section">
      Menu
    </div>

    <div class="sidebar-item" onclick="showSection('dashboard',this)">
      <i class="ti ti-home"></i> 
      Dashboard
    </div>

    <div class="sidebar-item" onclick="showSection('lapangan',this)">
      <i class="ti ti-layout-grid"></i> 
      Lapangan Saya
    </div>

    <div class="sidebar-item menu-booking" onclick="showSection('booking',this)">
      <i class="ti ti-calendar"></i> 
      Booking Masuk
      <?php if($pending['total'] > 0): ?>
        <span
        id="pending-badge"
        class="badge">
        <?= $pending['total']; ?>
      </span>
      <?php endif; ?>
    </div>

    <div class="sidebar-item" onclick="showSection('jadwal',this)">
      <i class="ti ti-clock"></i> 
      Kelola Jadwal
    </div>

    <div class="sidebar-section">
      Lainnya
    </div>

    <div class="sidebar-item" onclick="showSection('profil',this)">
      <i class="ti ti-building"></i> 
      Pengaturan
    </div>

    <a href="login.html" style="color:inherit;">
      <div class="sidebar-item sidebar-logout">
        <i class="ti ti-logout"></i> 
        Keluar
      </div>
    </a>
  </aside>

  <main class="dashboard-content">

    <!-- DASHBOARD -->
    <div id="section-dashboard" style="display:none;">
      <h1 class="page-title">Dashboard Owner</h1>
      <div class="stats-grid">
      <div class="stat-card">
        <div class="row-between">

          <div>
            <div class="stat-value">
              <?= $bookingHariIni['total']; ?>
            </div>
            <div class="stat-label">Booking Hari Ini</div>
          </div>

          <div class="icon-badge green">
            <i class="ti ti-calendar-check"></i>
          </div>
        </div>

        <div class="stat-change stat-up">

          <?php if($bookingKemarin['total'] == 0){ ?>

          <i class="ti ti-calendar-check"></i>
          <?= $bookingHariIni['total']; ?> booking terkonfirmasi hari ini

          <?php } elseif($selisihBooking > 0){ ?>

          <i class="ti ti-trending-up"></i>
          +<?= $selisihBooking; ?> dibanding kemarin

          <?php } elseif($selisihBooking < 0){ ?>

          <i class="ti ti-trending-down"></i>
          <?= abs($selisihBooking); ?> dibanding kemarin

          <?php } else { ?>

          <i class="ti ti-minus"></i>
          Sama seperti kemarin

          <?php } ?>

        </div>
      </div>
      <div class="stat-card">
        <div class="row-between">
          <div>
            <div class="stat-value">
              <?= $pending['total']; ?>
            </div>
            <div class="stat-label">Menunggu Konfirmasi</div>
          </div>
          <div class="icon-badge amber">
            <i class="ti ti-clock"></i>
          </div>
        </div>

        <div class="stat-change" style="color:var(--amber);">
          <?php if($pending['total'] == 0){ ?>
          <i class="ti ti-circle-check"></i>
          Tidak ada booking menunggu
          
          <?php }elseif($pending['total'] == 1){ ?>
          <i class="ti ti-alert-circle"></i>
          1 booking menunggu konfirmasi

          <?php }else{ ?>
          <i class="ti ti-alert-circle"></i>
          <?= $pending['total']; ?> booking menunggu konfirmasi
          <?php } ?>
        </div>
        
      </div>
      <div class="stat-card">
        <div class="row-between">
          <div>
            <div class="stat-value">
              Rp<?= number_format($pendapatan['total'],0,',','.'); ?>
            </div>
            <div class="stat-label">Pendapatan Bulan Ini</div>
          </div>
          <div class="icon-badge blue">
            <i class="ti ti-cash"></i>
          </div>
        </div>

        <div class="stat-change">

        <?php if($persentasePendapatan > 0){ ?>

            <i class="ti ti-trending-up"></i>
            +<?= round($persentasePendapatan); ?>% dibanding bulan lalu

        <?php } elseif($persentasePendapatan < 0){ ?>

            <i class="ti ti-trending-down"></i>
            <?= abs(round($persentasePendapatan)); ?>% dibanding bulan lalu

        <?php } else { ?>

            <i class="ti ti-minus"></i>
            Sama dengan bulan lalu

        <?php } ?>

        </div>

    </div>
    <div class="stat-card">
    <div class="row-between">
        <div>

            <div
                class="stat-value"
                id="dashboard-aktif">

                <?= $lapanganAktif['total']; ?>

            </div>

            <div class="stat-label">
                Lapangan Aktif
            </div>

        </div>

        <div class="icon-badge green">
            <i class="ti ti-layout-grid"></i>
        </div>
    </div>

    <?php
    $nonAktif = $totalLapangan['total'] - $lapanganAktif['total'];
    ?>

    <div
        class="stat-change"
        id="dashboard-aktif-text"
        style="color:var(--gray-400);">

        <?= $lapanganAktif['total']; ?>
        dari
        <span id="dashboard-total-lapangan">
            <?= $totalLapangan['total']; ?>
        </span>
        lapangan aktif

    </div>
</div>
  </div>
  
  <div class="grid-2col">
    <div class="revenue-card">
      <div class="rev-label">Total Pendapatan Bulan Ini</div>

      <div class="rev-amount">
        Rp<?= number_format($pendapatan['total'],0,",","."); ?>
      </div>

      <div class="rev-target">
        Target bulan ini:
        Rp<?= number_format($targetPendapatan,0,",","."); ?>
      </div>

      <div class="progress-bar progress-bar-inner">
        <div
          class="progress-fill"
          style="width: <?= round($persenTarget,1); ?>%;">
        </div>
      </div>

      <div class="rev-pct">
        <?= round($persenTarget,1); ?>% dari target
      </div>
    </div>

    <div class="card card-no-mb">
    <div class="card-header">Booking 7 Hari Terakhir</div>

    <div class="card-body">

    <?php if(array_sum($booking7Hari) == 0){ ?>

    <div class="chart-empty">
        <i class="ti ti-chart-bar chart-empty-icon"></i>
        <h4>Belum Ada Booking</h4>
    </div>

    <?php } else { ?>

        <div class="chart-bar-wrap">

            <?php
            $translate = [
                "Mon" => "Sen",
                "Tue" => "Sel",
                "Wed" => "Rab",
                "Thu" => "Kam",
                "Fri" => "Jum",
                "Sat" => "Sab",
                "Sun" => "Min"
            ];

            $translateFull = [
                "Monday" => "Senin",
                "Tuesday" => "Selasa",
                "Wednesday" => "Rabu",
                "Thursday" => "Kamis",
                "Friday" => "Jumat",
                "Saturday" => "Sabtu",
                "Sunday" => "Minggu"
            ];

            $hariIni = date('N') - 1;

            foreach($booking7Hari as $index => $jumlah){

                $senin = strtotime("monday this week");
                $tanggal = date("Y-m-d", strtotime("+$index day", $senin));

                $label = $translate[date("D", strtotime($tanggal))];
                $tooltip = $translateFull[date("l", strtotime($tanggal))];

                $tinggi = ($jumlah / $maxBooking) * 90;

                if($jumlah == 0){
                    $tinggi = 4;
                }
            ?>

            <div class="chart-bar-col">
                <div class="chart-bar-area">

                    <div class="chart-tooltip">
                        <?= $tooltip ?><br>
                        <?= $tanggal ?><br>
                        <strong><?= $jumlah ?> Booking</strong>
                    </div>

                    <div
                        class="chart-bar <?= $index==$hariIni ? 'active' : ''; ?>"
                        style="height:<?= $tinggi ?>%">
                    </div>

                </div>

                <div
                    class="chart-bar-label"
                    <?= $index==$hariIni ? 'style="color:var(--green);font-weight:700;"' : ''; ?>>
                    <?= $label ?>
                </div>

            </div>

            <?php } ?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>

<h2 class="section-h2">
  <i class="ti ti-clock icon-amber"></i> 
  Booking Menunggu Konfirmasi
</h2>
<div class="card">
  <div class="overflow-x-auto">
    <table class="table">
      <thead>
        <tr>
          <th>User</th>
          <th>Lapangan</th>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if(mysqli_num_rows($queryPendingBooking) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($queryPendingBooking)){ ?>
        <tr>
          <td><?= $row['nama']; ?></td>
          <td><?= $row['nama_lapangan']; ?></td>
          <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
          <td>
            <?= substr($row['jam_mulai'],0,5); ?>
            -
            <?= substr($row['jam_selesai'],0,5); ?>
          </td>
          
          <td>
            Rp<?= number_format($row['harga'],0,",","."); ?>
          </td>
          <td>
            <div class="dashboard-actions">
              <a
              href="update-booking-status.php?id=<?= $row['booking_id']; ?>&status=terkonfirmasi"
              class="btn btn-primary btn-sm"
              onclick="return confirm('Konfirmasi booking ini?');">
              <i class="ti ti-check"></i>
              Konfirmasi
              </a>
              
              <a
              href="update-booking-status.php?id=<?= $row['booking_id']; ?>&status=dibatalkan"
              class="btn btn-outline btn-sm btn-red"
              onclick="return confirm('Yakin ingin menolak booking ini?');">
              <i class="ti ti-x"></i>
              Batalkan
              </a>
            </div>
          </td>
        </tr>
        <?php } ?>
        <?php }else{ ?>
        <tr>
          <td colspan="6" style="text-align:center;padding:30px;">
            Tidak ada booking yang menunggu konfirmasi.
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<h2 class="section-h2"><i class="ti ti-activity icon-green"></i> Aktivitas Terbaru</h2>
<div class="card">
  <div class="card-body">
    <?php if(mysqli_num_rows($queryActivity) > 0){ ?>
    <?php while($row = mysqli_fetch_assoc($queryActivity)){ ?>

    <?php
    if($row['status'] == "tertunda"){
      $icon = "ti-clock";
      $class = "act-icon-amber";
      $judul = "Booking baru dari ".$row['nama'];
    }
    elseif($row['status'] == "terkonfirmasi"){
      $icon = "ti-circle-check";
      $class = "act-icon-green";
      $judul = "Booking dikonfirmasi";
    }
    elseif($row['status'] == "dibatalkan"){
      $icon = "ti-circle-x";
      $class = "act-icon-red";
      $judul = "Booking dibatalkan";
    }
    elseif($row['status'] == "selesai"){
      $icon = "ti-info-circle";
      $class = "act-icon-blue";
      $judul = "Booking selesai";
    }
    else{
      $icon = "ti-info-circle";
      $class = "act-icon-blue";
      $judul = "Aktivitas";
    }
    ?>
    <div class="activity-item">
      <div class="activity-icon <?= $class ?>">
        <i class="ti <?= $icon ?>"></i>
      </div>

      <div class="act-body">
        <div class="act-title">
          <?= $judul ?>
        </div>
        
        <div class="act-sub">
          <?= $row['nama']; ?>
          •
          <?= $row['nama_lapangan']; ?></div>
      </div>
      
      <div class="act-time">
        <?= waktuLalu($row['created_at']); ?>
      </div>
    </div>
    
    <?php } ?>
    <?php }else{ ?>
    
    <div class="empty-state">
      <i class="ti ti-history"></i>
      <p>Belum ada aktivitas.</p>
    </div>
    
    <?php } ?>
  </div>
</div>
</div>

    <!-- LAPANGAN SAYA -->
    <div id="section-lapangan" style="display:none;">
      <div class="flex-between">
        <h1 class="page-title page-title-inline">Lapangan Saya</h1>
        <button class="btn btn-primary" onclick="document.getElementById('add-modal').classList.add('show')">
          <i class="ti ti-plus"></i> 
          Tambah Lapangan
        </button>
      </div>

      <div class="tab-row">
        <button class="tab-btn active"
          onclick="filterLapangan('semua',this)">
          Semua (<?= $totalLapangan['total']; ?>)
        </button>
        
        <button class="tab-btn"
          onclick="filterLapangan('futsal',this)">
          Futsal (<?= $jumlahJenis['Futsal'] ?? 0; ?>)
        </button>
        
        <button class="tab-btn"
          onclick="filterLapangan('badminton',this)">
          Badminton (<?= $jumlahJenis['Badminton'] ?? 0; ?>)
        </button>
        
        <button class="tab-btn"
          onclick="filterLapangan('basket',this)">
          Basket (<?= $jumlahJenis['Basket'] ?? 0; ?>)
        </button>
      </div>

      <div class="fields-list">
        <?php while($field = mysqli_fetch_assoc($queryFields)){ ?>

        <?php
        $gambarEdit = "";
        
        if (!empty($field['gambar']) && file_exists("uploads/fields/" . $field['gambar'])) {
          $gambarEdit = $field['gambar'];
          }
        ?>
          
          <div class="field-row" data-type="<?= strtolower($field['jenis']); ?>">
            <div class="field-image">

              <?php
              $gambar = "uploads/fields/" . $field['gambar'];
              if(!empty($field['gambar']) && file_exists($gambar)){
              ?>

          <img
            src="<?= $gambar; ?>"
            alt="<?= $field['nama_lapangan']; ?>">
            
          <?php }else{ ?>

          <div class="field-no-image">
            <i class="ti ti-photo"></i>
            <span>Belum ada foto</span>
          </div>

          <?php } ?>
        </div>
          
          <div class="field-body">
            <div class="field-name">
              <?= $field['nama_lapangan']; ?>
            </div>
            
            <div class="field-meta">
              <?= $field['jenis']; ?>
              •
              Rp<?= number_format($field['harga'],0,",","."); ?>/jam
            </div>
          </div>
          
          <div class="field-status">

            <div class="booking-status">
              <small>Status Booking</small>
              <span class="booking-badge <?= strtolower($field['status']) == 'tersedia' ? 'badge-green' : 'badge-red'; ?>">
                <?= ucfirst($field['status']); ?>
              </span>
            </div>
            
            <div class="lapangan-status">
              <small>Status Lapangan</small>
              <span
              id="status-text-<?= $field['field_id']; ?>"
              class="lapangan-badge <?= strtolower($field['aktif']) == 'aktif' ? 'badge-green' : 'badge-red'; ?>">
              <?= ucfirst($field['aktif']); ?>
            </span>
          </div>
          </div>
          
          <div class="field-btns">
            
          <label class="switch">
            <input
            type="checkbox"
            <?= $field['aktif'] == 'aktif' ? 'checked' : ''; ?>
            onchange="toggleFieldStatus(this, <?= $field['field_id']; ?>)">
            <span class="slider"></span>
          </label>
          
          <button
          class="btn btn-outline btn-sm"
          onclick="openEditModal(
            '<?= $field['field_id']; ?>',
            '<?= addslashes($field['nama_lapangan']); ?>',
            '<?= addslashes($field['jenis']); ?>',
            '<?= addslashes($field['lokasi']); ?>',
            '<?= $field['harga']; ?>',
            '<?= $field['kapasitas']; ?>',
            '<?= addslashes($field['jenis_lantai']); ?>',
            '<?= addslashes($field['jam_operasional']); ?>',
            '<?= addslashes($field['deskripsi']); ?>',
            '<?= $gambarEdit; ?>'
            )">
            <i class="ti ti-edit"></i>
            Edit
          </button>
          
          <button
          class="btn btn-outline btn-sm btn-red"
          onclick="hapusLapangan(
            <?= $field['field_id']; ?>,
            '<?= addslashes($field['nama_lapangan']); ?>'
            )">
            <i class="ti ti-trash"></i>
          </button>

        </div>
      </div>
        <?php } ?>
      </div>

      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-top:20px;">

    <div class="stat-card" style="padding:14px;">
        <div class="mini-stat">Total Lapangan</div>
        <div class="mini-stat-val" style="font-size:28px;color:var(--dark);">
            <?= $dataTotal['total']; ?>
        </div>
    </div>

    <div class="stat-card" style="padding:14px;">
      <div class="mini-stat">
        Aktif
      </div>
      
      <div
        id="aktif-count"
        class="mini-stat-val"
        style="font-size:28px;color:var(--green);">
        <?= $dataAktif['total']; ?>
      </div>
    </div>

    <div class="stat-card" style="padding:14px;">
      <div class="mini-stat">
        Nonaktif
      </div>
      
      <div
        id="nonaktif-count"
        class="mini-stat-val"
        style="font-size:28px;color:var(--amber);">
        <?= $dataNonaktif['total']; ?>
      </div>
    </div>

    <div class="stat-card" style="padding:14px;">
        <div class="mini-stat">
          Tarif Rata-rata
        </div>
        
        <div 
          id="rata-harga"
          class="mini-stat-val" 
          style="font-size:22px;color:var(--dark);">
          Rp<?= number_format($dataHarga['rata'],0,",","."); ?>
        </div>
    </div>
    
  </div>
</div>

    <!-- BOOKING MASUK -->
    <div id="section-booking" style="display:none;">
      <h1 class="page-title">Booking Masuk</h1>

      <div class="filter-bar">

        <div class="search-input-wrap">
          <i class="ti ti-search"></i>
          <input
            type="text"
            id="search-booking"
            placeholder="Cari booking, nama user...">
        </div>
        
        <select
          class="form-input select-status"
          id="filter-status">
          <option value="">Semua Status</option>
          <option value="tertunda">Tertunda</option>
          <option value="terkonfirmasi">Terkonfirmasi</option>
          <option value="dibatalkan">Dibatalkan</option>
          <option value="selesai">Selesai</option>
        </select>

        <select
          class="form-input select-field"
          id="filter-lapangan">
          <option value="">Semua Lapangan</option>

          <?php
          $queryFilterLapangan = mysqli_query($conn,"
            SELECT nama_lapangan
            FROM fields
            WHERE owner_id='$owner_id'
            ORDER BY nama_lapangan
          ");
          
          while($lapangan = mysqli_fetch_assoc($queryFilterLapangan)){
          ?>
          
          <option value="<?= $lapangan['nama_lapangan']; ?>">
            <?= $lapangan['nama_lapangan']; ?>
          </option>
          
          <?php } ?>
        </select>

        <input 
          type="date"
          class="form-input input-date"
          id="filter-tanggal">
      </div>

      <div class="stat-chips">

        <div class="stat-chip amber">
          <i class="ti ti-clock"></i>
          <span><?= $pending['total']; ?> Tertunda</span>
        </div>

        <div class="stat-chip blue">
          <i class="ti ti-calendar-check"></i>
          <span><?= $konfirmasi['total']; ?> Terkonfirmasi</span>
        </div>

        <div class="stat-chip green">
          <i class="ti ti-circle-check"></i>
          <span><?= $selesai['total']; ?> Selesai</span>
        </div>

        <div class="stat-chip red">
          <i class="ti ti-circle-x"></i>
          <span><?= $dibatalkan['total']; ?> Dibatalkan</span>
        </div>

      </div>

      <div class="card">
        <div class="overflow-x-auto">
          <table class="table">
            <thead>
              <tr>
                <th>Kode</th>
                <th>User</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while($booking = mysqli_fetch_assoc($queryOwnerBooking)) : ?>
                <tr>

                  <td>
                      <?= $booking['booking_code']; ?>
                  </td>

                  <td>
                    <?= $booking['nama']; ?>
                  </td>
                  
                  <td class="booking-field">
                    <?= $booking['nama_lapangan']; ?>
                  </td>
                  
                  <td>
                    <?= $booking['tanggal']; ?>
                  </td>
                  
                  <td>
                    <?= $booking['jam_mulai']; ?>
                    -
                    <?= $booking['jam_selesai']; ?>
                  </td>
                  
                  <td>
                    Rp <?= number_format($booking['harga'],0,',','.'); ?>
                  </td>
                  
                  <td>
                    <?php
                    $status = $booking['status'];
                    
                    if($status == "tertunda"){
                      $class = "badge-pending";
                      }

                      elseif($status == "terkonfirmasi"){
                      $class = "badge-confirm";
                      }

                      elseif($status == "dibatalkan"){
                        $class = "badge-cancel";
                        }

                        else{
                          $class = "badge-finish";
                          }
                    ?>
                    
                    <span class="<?= $class; ?>">
                      <?= ucfirst($status); ?>
                    </span>
                  </td>
                  
                  <td>
                    <?php if($booking['status'] == 'tertunda') : ?>
                      <div class="booking-table-actions">
                        <a
                        href="konfirmasi-booking.php?id=<?= $booking['booking_id']; ?>"
                        class="btn btn-primary btn-sm">
                        Konfirmasi
                        </a>

                        <a
                        href="tolak-booking.php?id=<?= $booking['booking_id']; ?>"
                        class="btn btn-outline btn-sm btn-red">
                        Batalkan
                        </a>
                      </div>
                      <?php else : ?>
                      —
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    <!-- KELOLA JADWAL -->
     <div id="section-jadwal" style="display:none;">
      <h1 class="page-title">Kelola Jadwal</h1>
      <div class="flex-between">

      <div class="jadwal-filter">

    <label>Pilih Lapangan</label>

    <select
        id="field-filter"
        onchange="gantiLapangan(this.value)">

        <?php
        $qField = mysqli_query($conn,"
            SELECT field_id,nama_lapangan
            FROM fields
            WHERE owner_id='$owner_id'
            ORDER BY nama_lapangan
        ");

        while($f = mysqli_fetch_assoc($qField)){
        ?>

        <option
            value="<?= $f['field_id']; ?>"
            <?= (isset($_GET['field']) && $_GET['field']==$f['field_id']) ? 'selected' : ''; ?>>

            <?= $f['nama_lapangan']; ?>

        </option>

        <?php } ?>

    </select>

</div>

      <div class="flex-between">
        <div class="lapangan-selector">
          <?php
          $aktif = true;
          while($field = mysqli_fetch_assoc($queryFields)) :
          ?>

          
          <div
            class="lapangan-pill <?= $aktif ? 'active' : ''; ?>"
            onclick="selectJadwalLapangan(this)">
            <i class="ti ti-building-stadium"></i>
            <?= $field['nama_lapangan']; ?>
          </div>
          
          <?php
          $aktif = false;
          endwhile;
          ?>
        </div>
        
        <?php
        $week = isset($_GET['week']) ? (int)$_GET['week'] : 0;
        $awalMinggu = strtotime("monday this week ".$week." week");
        $akhirMinggu = strtotime("sunday this week ".$week." week");
        $periode =
        date("d M", $awalMinggu) .
        " - " .
        date("d M Y", $akhirMinggu);
        ?>

        <div class="jadwal-nav">
          <a
            href="dashboard-owner.php?week=<?= $week-1; ?>"
            class="btn btn-outline btn-sm">
            <i class="ti ti-chevron-left"></i>
          </a>

          <span><?= $periode; ?></span>

          <a
            href="dashboard-owner.php?week=<?= $week+1; ?>"
            class="btn btn-outline btn-sm">
            <i class="ti ti-chevron-right"></i>
          </a>
        </div>
      </div>
    </div>
      
      <div class="legend">
        <div class="legend-item"><div class="legend-dot booked"></div> Terpesan</div>
        <div class="legend-item"><div class="legend-dot available"></div> Tersedia</div>
        <div class="legend-item"><div class="legend-dot blocked"></div> Libur</div>

      </div>
      
      <div class="card card-overflow">
        <div class="schedule-grid">
          <div class="schedule-header">Jam</div>
          
          <?php
          $hari = [
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat",
            "Sabtu",
            "Minggu"
          ];

          for($i=0;$i<7;$i++){
            $tanggal = date(
              "Y-m-d",
              $awalMinggu + ($i * 86400)
            );
          ?>
          
          <?php
          $isToday = ($tanggal == date("Y-m-d"));
          ?>
          
          <div class="schedule-header <?= $isToday ? 'today' : ''; ?>">
            <strong><?= $hari[$i]; ?></strong>
            <br>
            <span><?= date("d M", strtotime($tanggal)); ?></span>
          </div>
          
          <?php } ?>

          <?php
            $jam = explode('-', $info['jam_operasional']);
            $jam_buka = isset($jam[0]) ? date("H:i", strtotime(trim($jam[0]))) : "";
            $jam_tutup = isset($jam[1]) ? date("H:i", strtotime(trim($jam[1]))) : "";
        

            $jamMulai = strtotime($jam_buka);
            $jamSelesai = strtotime($jam_tutup);
            $durasi = isset($info['durasi_slot'])
            ? $info['durasi_slot'] * 3600
            : 3600;
            for($jam = $jamMulai; $jam < $jamSelesai; $jam += $durasi){
          ?>
          
          <div class="schedule-time">
            <?= date("H:i",$jam); ?>
          </div>
          
          <?php
          for($i=0;$i<7;$i++){
            $tanggalSlot = date(
              "Y-m-d",
              $awalMinggu + ($i * 86400)
            );
            
            $statusSlot = "available";
            
            /* CEK HARI LIBUR */
            if(
              !empty($tanggal_mulai) &&
              !empty($tanggal_selesai)
            ){
              if(
                $tanggalSlot >= $tanggal_mulai &&
                $tanggalSlot <= $tanggal_selesai
              ){
                $statusSlot = "blocked";
              }
            }
            
            /* CEK BOOKING */
            mysqli_data_seek($queryJadwalBooking, 0);
            while($booking = mysqli_fetch_assoc($queryJadwalBooking)){

              $slot = strtotime(date("H:i",$jam));
              $mulai = strtotime(substr($booking['jam_mulai'],0,5));
              $selesai = strtotime(substr($booking['jam_selesai'],0,5));
              if (
                $booking['tanggal'] == $tanggalSlot &&
                $slot >= $mulai &&
                $slot < $selesai
                ){
                  if($statusSlot != "blocked"){
                    $statusSlot = "booked";
                    }
                    break;
                  }
              }
          ?>

          <div
            class="schedule-slot <?= $statusSlot; ?>"
            title="<?=
              $statusSlot == 'available'
              ? 'Tersedia'
              : ($statusSlot == 'booked'
              ? 'Terbooking'
              : 'Hari Libur');
            ?>">
          </div>

          <?php } ?>
          <?php } ?>
        </div>
      </div>
      
      <form action="update-jadwal.php" method="POST">
        <input
          type="hidden"
          name="field_id"
          value="<?= $info['field_id']; ?>">

      <div class="grid-jadwal">
            
            <!-- CARD JAM OPERASIONAL -->
            <div class="card card-no-mb">
              <div class="card-header">
                <i class="ti ti-clock icon-green"></i>
                Jam Operasional
              </div>
              
              <div class="card-body">
                <div class="form-group form-group-sm">
                  <label class="form-label">Jam Buka</label>
                  <input
                    type="time"
                    name="jam_buka"
                    class="form-input"
                    value="<?= $jam_buka; ?>">
                </div>
                
                <div class="form-group form-group-sm">
                  <label class="form-label">Jam Tutup</label>
                  <input
                    type="time"
                    name="jam_tutup"
                    class="form-input"
                    value="<?= $jam_tutup; ?>">
                </div>
                
                <div class="form-group form-group-last">
                  <label class="form-label">
                    Durasi Slot (jam)
                  </label>
                  
                  <select name="durasi_slot" class="form-input">
                    <option
                      value="1"
                      <?= (($info['durasi_slot'] ?? 1)==1) ? 'selected' : ''; ?>>
                      1 Jam
                    </option>
                    
                    <option
                      value="2"
                      <?= (($info['durasi_slot'] ?? 1)==2) ? 'selected' : ''; ?>>
                      2 Jam
                    </option>
                  </select>
                </div>
              </div>
            </div>
            
            <!-- CARD HARI LIBUR -->
             <div class="card card-no-mb">
              <div class="card-header">
                <i class="ti ti-calendar-off icon-red"></i>
                Hari Libur
              </div>
              
              <div class="card-body">
                <div class="form-group form-group-sm">
                  <label class="form-label">
                    Tanggal Mulai
                  </label>
                  
                  <input
                    type="date"
                    name="tanggal_mulai"
                    class="form-input"
                    value="<?= $tanggal_mulai; ?>">
                </div>
                
                <div class="form-group form-group-sm">
                  <label class="form-label">
                    Tanggal Selesai
                  </label>
                  
                  <input
                    type="date"
                    name="tanggal_selesai"
                    class="form-input"
                    value="<?= $tanggal_selesai; ?>">
                </div>
                
                <button
                  type="submit"
                  class="btn btn-danger">
                  <i class="ti ti-device-floppy"></i>
                  Simpan Jadwal
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>

    <!-- PROFIL OWNER -->
    <div id="section-profil" style="<?= $section=='profil' ? 'display:block;' : 'display:none;' ?>">

    <h1 class="page-title">Pengaturan</h1>

    <div class="setting-grid">

        <!-- CARD PROFIL OWNER -->

        <div class="setting-card">

              <h3>
                <i class="ti ti-user-circle"></i>
                Profil Owner
              </h3>

            <form action="update-profile-owner.php" method="POST">

              <div class="form-group">
                  <label>Nama Owner</label>
                  <input
                      type="text"
                      name="nama"
                      class="form-input"
                      value="<?= htmlspecialchars($profil['nama'] ?? ''); ?>">
              </div>

              <div class="form-group">
                  <label>Email</label>
                  <input
                      type="email"
                      name="email"
                      class="form-input"
                      value="<?= htmlspecialchars($profil['email'] ?? ''); ?>"
                      required>
              </div>

              <div class="form-group">
                  <label>Nomor HP / WA</label>
                  <input
                      type="text"
                      name="telepon"
                      class="form-input"
                      value="<?= htmlspecialchars($profil['telepon'] ?? ''); ?>">
              </div>

              <button
                  type="submit"
                  class="btn btn-primary btn-sm">
                  Perbarui Profil
              </button>

          </form>

        </div>

        <!-- CARD PASSWORD -->

        <div class="setting-card">

            <h3>
                <i class="ti ti-lock-password"></i>
                Ubah Password
            </h3>

            <form action="update-password-owner.php" method="POST">

              <div class="form-group">
                  <label>Password Lama</label>
                  <input
                    type="password"
                    name="password_lama"
                    class="form-input"
                    placeholder="Masukkan password lama"
                    required>
              </div>

              <div class="form-group">
                  <label>Password Baru</label>
                  <input
                    type="password"
                    name="password_baru"
                    class="form-input"
                    placeholder="Masukkan password baru"
                    required>
              </div>

              <div class="form-group">
                  <label>Konfirmasi Password Baru</label>
                  <input
                    type="password"
                    name="konfirmasi_password"
                    class="form-input"
                    placeholder="Ulangi password baru"
                    required>
              </div>

              <button
                  type="submit"
                  class="btn btn-primary">
                  Ubah Password
              </button>

          </form>

        </div>

    </div>

</div>
</main>
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="add-modal">
  <div class="modal-box">
    <form
      action="add-field.php"
      method="POST"
      enctype="multipart/form-data">
      
      <div class="modal-header">
        <div>
          <h3 class="modal-title">Tambah Lapangan Baru</h3>
          <p class="modal-sub">Isi detail lapangan yang akan ditambahkan</p>
        </div>
        
        <button
          type="button"
          class="modal-close-btn"
          onclick="document.getElementById('edit-modal').classList.remove('show')">
          <i class="ti ti-x"></i>
      </div>
      
      <input 
        type="hidden" 
        id="add-id" 
        name="field_id">
        
        <div class="form-group">
          <label class="form-label"> Nama Lapangan </label>
          <input
            type="text"
            class="form-input"
            id="new-nama"
            name="nama_lapangan"
            required>
        </div>
        
        <div class="form-group">
          <label class="form-label">Jenis Olahraga</label>
          <select
            class="form-input"
            id="new-jenis"
            name="jenis"
            required>
            <option>Futsal</option>
            <option>Badminton</option>
            <option>Basket</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Lokasi</label>
          <input
            type="text"
            class="form-input"
            id="new-lokasi"
            name="lokasi"
            required>
        </div>
        
        <div class="grid-2col-sm">
          <div class="form-group">
            <label class="form-label">Harga / Jam</label>
            <input
              type="number"
              class="form-input"
              id="new-harga"
              name="harga"
              equired>
            </div>
            
            <div class="form-group">
              <label class="form-label">Kapasitas</label>
              <input
                type="number"
                class="form-input"
                id="new-kapasitas"
                name="kapasitas"
                placeholder="10">
              </div>
            </div>
            
            <div class="form-group">
              <label class="form-label">Jenis Lantai</label>
              <input
                type="text"
                class="form-input"
                id="new-lantai"
                name="jenis_lantai">
              </div>

            <div class="form-group">
              <label class="form-label">Jam Operasional</label>
              <input
                type="text"
                class="form-input"
                id="new-jam"
                name="jam_operasional"
                placeholder="08:00 - 22:00">
              </div>
              
              <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea
                  class="form-input"
                  rows="3"
                  name="deskripsi">
                </textarea>
              </div>

              <div class="form-group">
                <label class="form-label">
                  Foto Lapangan
                </label>
                <input
                  type="file"
                  class="form-input"
                  id="new-gambar"
                  name="gambar"
                  accept="image/*" required>
                  
                <div id="preview-container" style="display:none; margin-top:12px;">
                  <img
                    id="preview-image"
                    src=""
                    alt="Preview"
                    style="
                      width:100%;
                      max-width:260px;
                      height:170px;
                      object-fit:cover;
                      border-radius:12px;
                      border:1px solid #ddd;">
                </div>
              </div>
              
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-outline btn-full"
                  onclick="document.getElementById('add-modal').classList.remove('show')">
                  Batal
                </button>
                
                <button
                  type="submit"
                  class="btn btn-primary btn-full">
                  <i class="ti ti-plus"></i>
                  Tambahkan
                </button>
              </div>
            </form>
          </div>
        </div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="edit-modal">

  <div class="modal-box">
    <form
      action="update-field.php"
      method="POST"
      enctype="multipart/form-data">

    <input
      type="hidden"
      id="edit-id"
      name="field_id">
    
    <div class="modal-header">
      <div>
        <h3 class="modal-title">Edit Lapangan</h3>
        <p class="modal-sub">Perbarui detail lapangan</p>
      </div>
      
      <button
        type="button"
        class="modal-close-btn"
        onclick="document.getElementById('edit-modal').classList.remove('show')">
        <i class="ti ti-x"></i>
      </div>

    <div class="form-group">
      <label class="form-label">Nama Lapangan</label>
      <input 
        type="text"
        class="form-input"
        id="edit-nama"
        name="nama_lapangan">
    </div>

    <div class="form-group">
      <label class="form-label">Jenis Olahraga</label>
      <select class="form-input"
        id="edit-jenis"
        name="jenis">
        <option>Futsal</option>
        <option>Badminton</option>
        <option>Basket</option>
      </select>
    </div>

    <div class="form-group">
          <label class="form-label">Lokasi</label>
          <input
            type="text"
            class="form-input"
            id="edit-lokasi"
            name="lokasi"
            required>
        </div>

    <div class="grid-2col-sm">
      <div class="form-group">
        <label class="form-label">Harga per Jam (Rp)</label>
        <input 
          type="number"
          class="form-input"
          id="edit-harga"
          name="harga">
      </div>

      <div class="form-group">
              <label class="form-label">Kapasitas</label>
              <input
                type="number"
                class="form-input"
                id="edit-kapasitas"
                name="kapasitas"
                placeholder="10">
              </div>
            </div>

      <div class="form-group">
        <label class="form-label">Jenis Lantai</label>
        <input 
          type="text"
          class="form-input"
          id="edit-lantai"
          name="jenis_lantai">
      </div>

    <div class="form-group">
              <label class="form-label">Jam Operasional</label>
              <input
                type="text"
                class="form-input"
                id="edit-jam"
                name="jam_operasional"
                placeholder="08:00 - 22:00">
              </div>

    <div class="form-group">
      <label class="form-label">Deskripsi</label>
      <textarea
        class="form-input"
        id="edit-deskripsi"
        name="deskripsi"
        rows="3"></textarea>
    </div>



    <div class="form-group"></div>

    <div class="form-group">
      <label class="form-label">
        Foto Saat Ini
      </label>
      
      <div id="edit-preview-container">
        <img
          id="edit-preview-image"
          style="
            width:220px;
            height:150px;
            object-fit:cover;
            border-radius:12px;
            border:1px solid #ddd;
            display:none;">
            
        <div
          id="no-photo"
          style="
            width:220px;
            height:150px;
            border:1px dashed #ccc;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#888;
            font-size:14px;">
            Belum ada foto lapangan
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">
        Ganti Foto
      </label>
      
      <input
        type="file"
        class="form-input"
        id="edit-gambar"
        name="gambar"
        accept="image/*">
    </div>

    <div class="modal-footer">
      <button
        type="button"
        class="btn btn-outline btn-full"
        onclick="document.getElementById('edit-modal').classList.remove('show')">
        Batal
      </button>

      <button type="submit" class="btn btn-primary btn-full">
        <i class="ti ti-device-floppy"></i>
        Simpan Perubahan
      </button>
    </div>
  </form>
</div>
</div>

<script src="main.js"></script>
<script>

function showSection(name, item) {

  document.querySelectorAll('[id^="section-"]').forEach(s => {
    s.style.display = "none";
  });

  const t = document.getElementById("section-" + name);

  if (t) {
    t.style.display = "block";

    // pindah ke awal halaman dashboard
    document.querySelector(".dashboard-content").scrollTo({
      top: 0,
      behavior: "instant"
    });
  }

  document.querySelectorAll(".sidebar-item").forEach(i => {
    i.classList.remove("active");
  });

  if (item) item.classList.add("active");
}

function openEditModal(
  id,
  nama,
  jenis,
  lokasi,
  harga,
  kapasitas,
  jenis_lantai,
  jam_operasional,
  deskripsi,
  gambar
){
  document.getElementById("edit-id").value = id;

  document.getElementById("edit-nama").value = nama;
  document.getElementById("edit-harga").value = harga;
  document.getElementById("edit-lantai").value = jenis_lantai;

  document.getElementById("edit-lokasi").value = lokasi;
  document.getElementById("edit-kapasitas").value = kapasitas;
  document.getElementById("edit-jam").value = jam_operasional;
  document.getElementById("edit-deskripsi").value = deskripsi;
  
  const sel = document.getElementById("edit-jenis");
  
  for(let o of sel.options){
    if(o.value===jenis || o.text===jenis){
      o.selected = true;
      break;
    }
  }
  
  document.getElementById("edit-modal").classList.add("show");
  const preview = document.getElementById("edit-preview-image");
  const noPhoto = document.getElementById("no-photo");
  if(gambar){
    preview.src = "uploads/fields/" + gambar;
    preview.style.display = "block";
    noPhoto.style.display = "none";
  }else{
    preview.style.display = "none";
    noPhoto.style.display = "flex";
  }
}

function hapusLapangan(id, nama){
  if(confirm("Yakin ingin menghapus\n\n" + nama + " ?")){
    window.location.href =
    "delete-field.php?id=" + id;
  }
}

async function toggleFieldStatus(element, fieldId) {

    const statusSebelumnya = element.checked;

    try {

        const response = await fetch(
            `toggle-field-status-ajax.php?id=${fieldId}`
        );

        const result = await response.json();

        const statusText = document.getElementById(`status-text-${fieldId}`);

        if(result.success && statusText){
          statusText.textContent =
          result.status.charAt(0).toUpperCase() +
          result.status.slice(1);

          statusText.classList.remove("badge-green", "badge-red");
          if(result.status === "aktif"){
            statusText.classList.add("badge-green");
          }else{
            statusText.classList.add("badge-red");
          }
        }
        if (!result.success) {

            element.checked = !statusSebelumnya;

            alert("Gagal mengubah status.");

        }

        const aktifCount = document.getElementById("aktif-count");
const nonaktifCount = document.getElementById("nonaktif-count");

const dashboardAktif = document.getElementById("dashboard-aktif");
const dashboardAktifText = document.getElementById("dashboard-aktif-text");
const totalLapangan = document.getElementById("dashboard-total-lapangan");

if(result.success){

    // Ambil angka langsung dari database
    if(aktifCount){
        aktifCount.textContent = result.aktif;
    }

    if(nonaktifCount){
        nonaktifCount.textContent = result.nonaktif;
    }

    if(dashboardAktif){
        dashboardAktif.textContent = result.aktif;
    }

    if(dashboardAktifText && totalLapangan){
        dashboardAktifText.textContent =
            result.aktif + " dari " + result.total + " lapangan aktif";
    }

    const rataHarga = document.getElementById("rata-harga");
    
    if(rataHarga){
      rataHarga.textContent =
      "Rp" + Number(result.rata).toLocaleString("id-ID");
    }

}

    } catch (error) {

        element.checked = !statusSebelumnya;

        alert("Terjadi kesalahan koneksi.");

        console.error(error);

    }

}

function filterLapangan(type, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.field-row').forEach(row => {
    row.style.display = (type==='semua' || row.dataset.type===type) ? 'flex' : 'none';
  });
}

function selectJadwalLapangan(el) {
  document.querySelectorAll('.lapangan-pill').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
}

document.addEventListener('change', e => {
  if (e.target.type==='checkbox' && e.target.closest('.toggle')) {
    const span = e.target.nextElementSibling;
    if (span) { span.textContent = e.target.checked ? 'Aktif' : 'Nonaktif'; span.style.color = e.target.checked ? 'var(--green)' : 'var(--gray-400)'; }
  }
});

document.addEventListener('click', e => {
  const slot = e.target.classList.contains('schedule-slot') ? e.target : e.target.closest('.schedule-slot');
  if (!slot || slot.classList.contains('booked')) return;
  slot.classList.toggle('blocked'); slot.classList.toggle('available');
});

document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target===o) o.classList.remove('show'); });
});

document.querySelector('.menu-booking').addEventListener('click', () => {
  document.querySelector('.notif-badge').style.display = 'none';
});

window.onload = function(){

    const activeSection = "<?= $section ?>";

    const menu = document.querySelector(
        `.sidebar-item[onclick*="${activeSection}"]`
    );

    showSection(activeSection, menu);

}

function closeToast(){

    const toast = document.getElementById("toast-success");

    if(!toast) return;

    toast.style.animation = "toastHide .35s ease forwards";

    setTimeout(function(){

        toast.remove();

    },300);

}

window.addEventListener("load", function(){

    const toast = document.getElementById("toast-success");

    if(!toast) return;

    setTimeout(function(){

        closeToast();

        // hapus parameter section dari URL
        history.replaceState({}, "", "dashboard-owner.php");

    },3000);

});

document
.getElementById("new-gambar")
.addEventListener("change", function(e){

    const file = e.target.files[0];

    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(event){

        document
        .getElementById("preview-image")
        .src = event.target.result;

        document
        .getElementById("preview-container")
        .style.display = "block";

    }

    reader.readAsDataURL(file);

});

document
.getElementById("edit-gambar")
.addEventListener("change", function(e){

    const file = e.target.files[0];

    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(event){

        document
        .getElementById("edit-preview-image")
        .src = event.target.result;

        document
        .getElementById("edit-preview-image")
        .style.display = "block";

        document
        .getElementById("no-photo")
        .style.display = "none";

    }

    reader.readAsDataURL(file);

});

const searchBooking = document.getElementById("search-booking");

const filterStatus = document.getElementById("filter-status");

const filterLapanganBooking = document.getElementById("filter-lapangan");

const filterTanggal = document.getElementById("filter-tanggal");

function filterBooking(){

    const keyword = searchBooking.value.toLowerCase().trim();

    const status = filterStatus.value.toLowerCase().trim();

    const lapangan = filterLapanganBooking.value.toLowerCase().trim();

    const tanggal = filterTanggal.value;

    const rows = document.querySelectorAll("#section-booking tbody tr");

    rows.forEach(function(row){
      const text = row.innerText.toLowerCase();
      const statusCell = row.cells[6].innerText.toLowerCase().trim();
      const lapanganCell = row.cells[2].innerText.toLowerCase().trim();
      const tanggalCell = row.cells[3].innerText.trim();

      const cocokKeyword =
      keyword === "" || text.includes(keyword);
      
      const cocokStatus =
      status === "" || statusCell === status;
      
      const cocokLapangan =
      lapangan === "" || lapanganCell === lapangan;
      
      const cocokTanggal =
      tanggal === "" || tanggalCell === tanggal;

      if(
        cocokKeyword &&
        cocokStatus &&
        cocokLapangan &&
        cocokTanggal
      ){
        row.style.display = "";
      }
      else{
        row.style.display = "none";
      }
    });
  }

  if(searchBooking){
    searchBooking.addEventListener("keyup", filterBooking);
}

if(filterStatus){
    filterStatus.addEventListener("change", filterBooking);
}

if(filterLapanganBooking){
    filterLapanganBooking.addEventListener("change", filterBooking);
}

if(filterTanggal){
    filterTanggal.addEventListener("change", filterBooking);
}

function gantiLapangan(id){

    const url =
    "dashboard-owner.php?section=jadwal&field=" + id;

    window.location.href = url;

}

function loadPendingBadge(){

    fetch("get-pending-count.php")
    .then(res => res.json())
    .then(data => {

        const badge = document.getElementById("pending-badge");

        if(!badge) return;

        if(data.total > 0){

            badge.style.display = "inline-flex";
            badge.textContent = data.total;

        }else{

            badge.style.display = "none";

        }

    });

}

setInterval(loadPendingBadge,5000);

</script>
</body>
</html>