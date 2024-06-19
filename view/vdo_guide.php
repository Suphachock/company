<?php
include_once "../conn.php";
// Query to fetch all categories
$sql = "SELECT * FROM vdo_category";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
?>
    <div class="text-center fs-2">VDO คู่มือการใช้งานต่างๆ</div>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-6">
                <div class="row">
                    <div class="text-center fs-4"><?= htmlspecialchars($row['vdo_category']) ?></div>
                </div>
                <!-- Assuming you want to display multiple videos under each category, you'll need a nested query here -->
                <?php
                $category = $row['vdo_category'];
                $sql_vdo = "SELECT * FROM vdo WHERE vdo_category = '$category'";
                $result_vdo = mysqli_query($conn, $sql_vdo);
                while ($vdo = mysqli_fetch_assoc($result_vdo)) {
                ?>
                    <div class="row mb-2">
                        <div class="text-start fs-5"><?= htmlspecialchars($vdo['vdo_title']) ?></div>
                        <video class="w-100" controls>
                            <source src="vdo/<?= htmlspecialchars($vdo['vdo_path']) ?>" type="video/mp4" />
                        </video>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php
} else { ?>
    <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ - </div>
<?php }
?>