<?php
include_once "../conn.php";
$sql = "SELECT u.id,u.fullname,u.username,u.password,d.department FROM user u JOIN department d ON u.department = d.id";
$result = mysqli_query($conn, $sql);
?>
<div class="row align-items-center text-center">
    <div class="col-lg-9 col-sm-8 col-7">
        <div class="text-center fs-2">จัดการสมาชิก</div>
    </div>
    <div class="col-lg-3 col-sm-4 col-5">
        <div class="d-flex justify-content-end">
            <button class="btn btn-warning me-2" onclick="show_md_department()">
                <i class="fa-solid fa-building"></i> เพิ่มแผนก
            </button>
            <button class="btn btn-primary" onclick="show_md_user_add()">
                <i class="fa-solid fa-user-plus"></i> เพิ่มสมาชิก
            </button>
        </div>
    </div>
</div>
<div class="row mx-3 mt-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">ชื่อ-นามสกุล</th>
                <th scope="col">ชื่อผู้ใช้</th>
                <th scope="col">รหัสผ่าน</th>
                <th scope="col">แผนก</th>
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
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['password']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning " onclick="edit_user('<?= $row['id'] ?>')"><i class="fa-solid fa-edit"></i></button>
                            <button class="btn btn-danger " onclick="if(confirm('Are you sure!')) { delete_user('<?= $row['id'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
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