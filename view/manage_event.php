<?php
include_once "../conn.php";
$sql = "SELECT e.id,e.event_title,ec.event_category,e.event_img from event e JOIN event_category ec ON e.event_category = ec.id;";
$result = mysqli_query($conn, $sql);
?>
<div class="row">
    <div class="col-lg-9 col-md-8 col-sm-7 col-7">
        <div class="text-center fs-2">จัดการกิจกรรมภายในและภายนอกบริษัท</div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-5 col-5">
        <div class="d-flex justify-content-end">
            <button class="btn btn-warning me-2" onclick="show_md_event_category()">
                <i class="fa-solid fa-plus"></i> เพิ่มหมวดหมู่
            </button>
            <button class="btn btn-primary" onclick="show_md_event_add()">
                <i class="fa-solid fa-plus"></i> เพิ่มข้อมูล
            </button>
        </div>
    </div>
</div>
<div class="row mx-3 mt-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">NO.</th>
                <th scope="col">หัวข้ออีเว้นท์</th>
                <th scope="col" class="text-center">หมวดหมู่</th>
                <th scope="col" class="text-center">รูปทั้งหมด</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $counter = 1; // Initialize a counter for the row numbers
                while ($row = mysqli_fetch_assoc($result)) {
                    $img_count = count(explode(',', $row['event_img'])); // Count images
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($counter) ?></td>
                        <td><?= htmlspecialchars($row['event_title']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['event_category']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($img_count) ?> รูป</td>
                        <td class="text-center">
                            <button class="btn btn-warning" onclick="edit_event('<?= $row['id'] ?>')"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn btn-danger" onclick="if(confirm('Are You Sure!')) { delete_event('<?= $row['id'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
            <?php
                    $counter++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
