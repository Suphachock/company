<?php
include_once "../conn.php";
$sql = "SELECT * FROM tel ORDER BY create_date DESC";
$result = mysqli_query($conn, $sql);
?>
<div class="row align-items-center text-center">
    <div class="col-lg-10 col-md-10 col-sm-9 col-9">
        <div class="text-center fs-2">จัดการเบอร์โทรภายในบริษัท SR&SK</div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-3 col-3">
        <button class="btn btn-primary" onclick="show_md_tel_add()">
            <i class="fa-regular fa-image"></i> เพิ่มรูปภาพ
        </button>
    </div>
</div>
<div class="row mx-3 mt-3">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">NO.</th>
                <th scope="col">Image Name</th>
                <th scope="col">Create Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $counter = 1; // Initialize a counter for the row numbers
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($counter) ?></td>
                        <td><?= htmlspecialchars($row['tel_pic']) ?></td>
                        <td><?= htmlspecialchars($row['create_date']) ?></td>
                        <td>
                            <button class="btn btn-danger " onclick="if(confirm('Do you want to delete book!!')) { delete_tel('<?= $row['id'] ?>','<?= $row['tel_pic'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
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

