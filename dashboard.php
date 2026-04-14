<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php include "sidebar.php"; ?>

    <h1>Dashboard</h1>

    <!-- CARD STATISTIK -->
    <div class="cards">
        <div class="card">
            <h3>Total Menu</h3>
            <p class="number">0</p>
        </div>
        <div class="card">
            <h3>Total Kategori</h3>
            <p class="number">0</p>
        </div>
        <div class="card">
            <h3>Pesanan Masuk</h3>
            <p class="number">0</p>
        </div>
        <div class="card">
            <h3>Pesanan Selesai</h3>
            <p class="number">0</p>
        </div>
    </div>

    <!-- TABLE DUMMY -->
    <div class="table-box">
        <h3>Pesanan Terbaru</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Menu</th>
                <th>Status</th>
            </tr>
            <tr>
                <td colspan="4" class="empty">
                    Belum ada data pesanan
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
