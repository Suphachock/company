<?php
include_once "../conn.php";
$sql = "SELECT vdo.*,vc.vdo_category vdo_category_name FROM vdo JOIN vdo_category vc ON vdo.vdo_category = vc.id";
$result = mysqli_query($conn, $sql);
?>
<div class="row">
    <div class="col-lg-9 col-md-8 col-sm-7 col-7">
        <div class="text-center fs-2">จัดการ VDO คู่มือการใช้งานต่างๆ</div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-5 col-5">
        <div class="d-flex justify-content-end">
            <button class="btn btn-warning me-2" onclick="show_md_vdo_category()">
                <i class="fa-solid fa-plus"></i> เพิ่มหมวดหมู่
            </button>
            <button class="btn btn-primary" onclick="show_md_vdo_add()">
                <i class="fa-solid fa-plus"></i> เพิ่มข้อมูล
            </button>
        </div>
    </div>

</div>
<div class="row mx-3 mt-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">หัวข้อวิดิโอ</th>
                <th scope="col" class="text-center">หมวดหมู่</th>
                <th scope="col" class="text-center">แก้ไข / ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $counter = 1; // Initialize a counter for the row numbers
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($counter) ?></td>
                        <td><?= htmlspecialchars($row['vdo_title']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['vdo_category_name']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning " onclick="edit_vdo('<?= $row['id'] ?>')"><i class="fa-solid fa-pen-to-square"></i></i></button>
                            <button class="btn btn-danger " onclick="if(confirm('Are You Sure!')) { delete_vdo('<?= $row['id'] ?>','<?= $row['vdo_path'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
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