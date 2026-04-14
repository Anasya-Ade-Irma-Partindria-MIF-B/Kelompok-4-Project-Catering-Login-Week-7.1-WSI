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
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catering Enak</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="hero">
<div class="overlay">
<div class="container text-center">

<h1>
<?= isset($_SESSION['user']['nama']) 
    ? "Halo, ".$_SESSION['user']['nama']." Selamat datang di Catering Enak"
    : "Catering Anti Ribet"; ?>
</h1>

<p>Makan enak tanpa drama</p>

<a href="katalog.php" class="btn btn-success">Gas lihat menu</a>

</div>
</div>
</section>

<section class="container py-5">
<h3 class="mb-4 text-center">Menu Andalan</h3>

<div class="row g-4">

<div class="col-md-4">
<div class="card card-hover shadow-sm">
<div class="card-body text-center">
<h5>Ayam Bakar</h5>
<p>Rp25.000</p>
<a href="detail.php" class="btn btn-success btn-sm">Detail</a>
</div>
</div>
</div>

</div>
</section>

</body>
</html>