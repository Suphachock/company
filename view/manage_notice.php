<?php
include_once "../conn.php";
$sql = "SELECT * from notice";
$result = mysqli_query($conn, $sql);
?>
<div class="row align-items-center text-center">
    <div class="col-lg-10 col-sm-8 col-7">
        <div class="text-center fs-2">จัดการข่าวสารประชาสัมพันธ์</div>
    </div>
    <div class="col-lg-2 col-sm-4 col-5">
        <button class="btn btn-primary" onclick="show_md_notice_add()">
            <i class="fa-solid fa-newspaper"></i> เพิ่มข้อมูล
        </button>
    </div>
</div>
<div class="row mx-3 mt-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">หัวข้อ</th>
                <th scope="col">รายละเอียด</th>
                <th scope="col">สร้างเมื่อ</th>
                <th scope="col" class="text-center">แก้ไข/ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $counter = 1; // Initialize a counter for the row numbers
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($counter) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['detail']) ?></td>
                        <td><?= htmlspecialchars($row['create_date']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning " onclick="edit_notice('<?= $row['id'] ?>')"><i class="fa-solid fa-edit"></i></button>
                            <button class="btn btn-danger " onclick="if(confirm('Are you sure!')) { delete_notice('<?= $row['id'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>