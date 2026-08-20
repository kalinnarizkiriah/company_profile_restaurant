<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Restoran</title>

    <!-- FontAwesome Font CDN (Untuk Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- SB Admin 2 CSS CDN (Membaca CSS langsung dari internet) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css">

    <style>
    /* Mengubah warna judul card & teks primary */
    .text-primary, .text-danger {
        color: #E33A26 !important;
    }

    /* Mengubah warna tombol tambah data & tombol utama */
    .btn-primary, .btn-danger {
        background-color: #E33A26 !important;
        border-color: #E33A26 !important;
    }

    /* Efek saat tombol di-hover mouse */
    .btn-primary:hover, .btn-danger:hover {
        background-color: #C82E1C !important;
        border-color: #C82E1C !important;
    }

    /* Mengubah garis/border atas card jika ada */
    .border-left-primary, .border-left-danger {
        border-left-color: #E33A26 !important;
    }
   
       /* 1. Kondisi saat menu sedang AKTIF (Halaman dibuka) */
        .sidebar .nav-item.active {
            border-left: 4px solid #ffffff !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        .sidebar .nav-item.active .nav-link {
            color: #ffffff !important;
            font-weight: bold;
        }

        /* 2. Kondisi saat KURSOR DIARAHKAN (Hover) */
        .sidebar .nav-item:hover {
            border-left: 4px solid rgba(255, 255, 255, 0.7) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            transition: all 0.2s ease-in-out; /* Agar efek perpindahan garis halus */
        }

        .sidebar .nav-item:hover .nav-link,
        .sidebar .nav-item:hover .nav-link i {
            color: #ffffff !important; /* Membuat teks & ikon jadi putih terang saat di-hover */
        }
</style>
</head>