<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) {
    die("Invoice tidak ditemukan.");
}

$booking_id = (int) $_GET['id'];

$from = $_GET['from'] ?? 'index';

$query = mysqli_query($conn, "
SELECT
    b.*,
    b.status AS booking_status,

    f.*,

    p.total,
    p.metode,
    p.status AS payment_status,

    o.nama AS owner_nama,
    o.telepon,
    o.alamat

FROM booking b

JOIN fields f
ON b.field_id = f.field_id

JOIN payment p
ON b.booking_id = p.booking_id

LEFT JOIN owners o
ON f.field_id = o.field_id

WHERE b.booking_id='$booking_id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Invoice tidak ditemukan.");
}

$durasi =
    (
        strtotime($data['jam_selesai'])
        -
        strtotime($data['jam_mulai'])
    )
    /
    3600;

$invoice =
    "INV-" .
    date('Y') .
    "-" .
    str_pad(
        $booking_id,
        5,
        "0",
        STR_PAD_LEFT
    );

$bookingCode =
    "SS-" .
    date('Y') .
    "-" .
    str_pad(
        $booking_id,
        5,
        "0",
        STR_PAD_LEFT
    );

if ($from == "success") {

    $backLink = "booking-success.php?id=" . $booking_id;
    $backText = "Kembali ke Booking";

} elseif ($from == "riwayat") {

    $backLink = "riwayat.php";
    $backText = "Kembali ke Riwayat";

} else {

    $backLink = "index.php";
    $backText = "Kembali ke Beranda";

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice SportSpace</title>

    <link rel="stylesheet" href="index.css">

    <link rel="stylesheet" href="invoice.css?v=<?= time(); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

</head>

<body>

    <div class="invoice-wrapper">

        <div class="invoice-card">
            <a href="<?= $backLink ?>" class="close-invoice">
                <i class="ti ti-x"></i>
            </a>

            <!-- HEADER -->
            <div class="invoice-header">

                <div>

                    <h1>SportSpace</h1>

                    <p>BOOKING INVOICE</p>

                </div>

                <?php

                if ($data['booking_status'] == "terkonfirmasi") {

                    echo '<span class="status paid">PAID</span>';

                } elseif ($data['booking_status'] == "tertunda") {

                    echo '<span class="status pending">PENDING</span>';

                } elseif ($data['booking_status'] == "dibatalkan") {

                    echo '<span class="status cancel">CANCELLED</span>';

                } else {

                    echo '<span class="status paid">SELESAI</span>';

                }

                ?>

            </div>

            <div class="divider"></div>

            <!-- NOMOR -->
            <div class="invoice-info">

                <div>

                    <span>Invoice</span>

                    <strong><?= $invoice ?></strong>

                </div>

                <div>

                    <span>Booking Code</span>

                    <strong><?= $bookingCode ?></strong>

                </div>

            </div>

            <div class="divider"></div>

            <!-- DETAIL -->
            <div class="invoice-detail">

                <div class="row">

                    <span>Nama Lapangan</span>

                    <strong><?= $data['nama_lapangan'] ?></strong>

                </div>

                <div class="row">

                    <span>Jenis</span>

                    <strong><?= $data['jenis'] ?></strong>

                </div>

                <div class="row">

                    <span>Tanggal</span>

                    <strong><?= date('d F Y', strtotime($data['tanggal'])) ?></strong>

                </div>

                <div class="row">

                    <span>Jam</span>

                    <strong>

                        <?= substr($data['jam_mulai'], 0, 5) ?>

                        -

                        <?= substr($data['jam_selesai'], 0, 5) ?>

                    </strong>

                </div>

                <div class="row">

                    <span>Durasi</span>

                    <strong><?= $durasi ?> Jam</strong>

                </div>

                <div class="row">

                    <span>Metode</span>

                    <strong><?= strtoupper($data['metode_pembayaran']) ?></strong>

                </div>

            </div>

            <div class="divider"></div>

            <!-- TOTAL -->

            <div class="total-box">

                <span>Total Pembayaran</span>

                <h2>

                    Rp<?= number_format($data['total'], 0, ',', '.') ?>

                </h2>

            </div>

            <div class="divider"></div>

            <!-- OWNER -->

            <div class="owner-box">

                <h3>Pemilik GOR</h3>

                <?php
                $inisial = "";

                if (!empty($data['owner_name'])) {

                    $nama = explode(" ", trim($data['owner_name']));

                    foreach ($nama as $n) {
                        $inisial .= strtoupper(substr($n, 0, 1));
                    }

                    $inisial = substr($inisial, 0, 2);

                } else {

                    $inisial = "PG";

                }
                ?>

                <div class="owner-profile">

                    <div class="owner-detail">

                        <h4><?= $data['owner_name'] ?></h4>

                        <div class="owner-contact">

                            <div>

                                <i class="ti ti-phone"></i>

                                <?= $data['owner_phone'] ?>

                            </div>

                            <div>

                                <i class="ti ti-map-pin"></i>

                                <?= $data['owner_address'] ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="divider"></div>

            <p class="thanks">

                Terima kasih telah menggunakan SportSpace.

            </p>

            <div class="invoice-button">

                <button onclick="printInvoice()" class="btn btn-primary btn-lg">

                    <i class="ti ti-printer"></i>

                    Cetak Invoice

                </button>

            </div>

        </div>

    </div>
    <script>

        function printInvoice() {

            window.print();

        }

    </script>
</body>