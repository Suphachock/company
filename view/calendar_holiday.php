<?php
include_once "../conn.php";
$sql = "SELECT * FROM holiday where status = 'active' ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<?php
if ($result && mysqli_num_rows($result) > 0) { ?>

    <div class="text-center fs-2">ปฏิทินวันหยุดบริษัทปี 2567</div>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <img src="img/holiday/<?= htmlspecialchars($row['holiday_img']) ?>" style="width: 100%; object-fit: cover;" alt="Holiday Image" />
    <?php
    }
} else { ?>
    <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ -</div>
<?php } ?>