<?php
include_once "../conn.php";
// Use LIMIT 1 for MySQL
$sql = "SELECT tel_pic FROM tel ORDER BY create_date DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    // Now $row will have the data you fetched
?>
    <div class="text-center fs-2">เบอร์โทรภายในบริษัท SR&SK</div>
    <img src="img/tel/<?= htmlspecialchars($row['tel_pic']) ?>" style="width: 100%; object-fit: cover;" />
<?php
} else { ?>
    <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ - </div>
<?php }
?>