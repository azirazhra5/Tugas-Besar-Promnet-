<?php
require '../function.php';

if (!isset($_SESSION['admin'])) { 
    header("Location: login_admin.php"); 
    exit; 
}

// update status pesanan
if (isset($_POST['update_status'])) {
    $id_pesanan = (int)$_POST['id_pesanan'];
    $status     = $_POST['status'];
    mysqli_query($conn, "UPDATE pesanan SET status='$status' WHERE id_pesanan=$id_pesanan");
}

$pesanan = mysqli_query($conn, "
    SELECT 
        pesanan.id_pesanan,
        pesanan.tanggal,
        pesanan.no_hp,
        pesanan.alamat,
        pesanan.pembayaran,
        pesanan.total,
        pesanan.status,
        `user`.username
    FROM pesanan
    JOIN `user` ON pesanan.id_user = `user`.id
    ORDER BY pesanan.id_pesanan DESC
");


if (!$pesanan) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#f5e6d3; }
.card{ background:#fff3e0; border-radius:15px; }
.table thead{ background:#6d4c41; color:white; }
.table-bordered > :not(caption) > * > *{ border-color:#d7ccc8; }
.form-select{ background:#efebe9; border-color:#a1887f; color:#4e342e; }
.form-select:focus{ border-color:#6d4c41; box-shadow:0 0 0 .2rem rgba(109,76,65,.25); }
.btn-cookie{ background:#a1887f; color:white; border:none; }
.btn-cookie:hover{ background:#6d4c41; color:white; }
.btn-cookie-outline{ background:#d7ccc8; color:#4e342e; border:none; }
.btn-cookie-outline:hover{ background:#bcaaa4; color:#3e2723; }
.badge-pending{background:#bcaaa4;}
.badge-proses{background:#8d6e63;}
.badge-selesai{background:#5d4037;}
</style>
</head>
<body>

<div class="container py-5">
<div class="card shadow p-4">

<h3 class="mb-4">📦 Data Pesanan</h3>

<table class="table table-bordered align-middle">
<thead>
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>No HP</th>
    <th>Alamat</th>
    <th>Pembayaran</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($pesanan) > 0): ?>
    <?php while ($p = mysqli_fetch_assoc($pesanan)): ?>
        <?php
        $badge='badge-pending';
        if($p['status']=='proses')$badge='badge-proses';
        if($p['status']=='selesai')$badge='badge-selesai';
        ?>
        <tr>
            <td><?= $p['id_pesanan']; ?></td>
            <td><?= htmlspecialchars($p['username'] ?? ''); ?></td>
            <td><?= htmlspecialchars($p['no_hp'] ?? ''); ?></td>
            <td><?= htmlspecialchars($p['alamat'] ?? ''); ?></td>
            <td><?= htmlspecialchars($p['pembayaran'] ?? ''); ?></td>
            <td>Rp <?= number_format($p['total'] ?? 0); ?></td>
            <td><span class="badge <?= $badge ?>"><?= ucfirst($p['status'] ?? ''); ?></span></td>
            <td>
                <form method="post" class="d-inline">
                    <input type="hidden" name="id_pesanan" value="<?= $p['id_pesanan']; ?>">
                    <select name="status" class="form-select form-select-sm d-inline w-auto">
                        <option value="pending" <?= ($p['status'] ?? '')=='pending'?'selected':''; ?>>Pending</option>
                        <option value="proses" <?= ($p['status'] ?? '')=='proses'?'selected':''; ?>>Proses</option>
                        <option value="selesai" <?= ($p['status'] ?? '')=='selesai'?'selected':''; ?>>Selesai</option>
                    </select>
                    <button type="submit" name="update_status" class="btn btn-sm btn-cookie ms-1">Update</button>
                </form>
                <a href="detail_pesanan.php?id=<?= $p['id_pesanan']; ?>" class="btn btn-sm btn-cookie-outline ms-1">Detail</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr><td colspan="8" class="text-center">Belum ada pesanan</td></tr>
<?php endif; ?>
</tbody>
</table>

</div>
</div>
</body>
</html>
