<?php
include_once "../conn.php";
$sql = "SELECT * FROM department";
$result = mysqli_query($conn, $sql);
?>
<table class="table ">
    <thead>
        <tr>
            <th scope="col-auto">ลำดับ</th>
            <th scope="col-auto">แผนก</th>
            <th scope="col-auto" class="text-end">แก้ไข / ลบ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result) {
            $counter = 1; // Initialize a counter for the row numbers
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($counter) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td class="text-end">
                        <button class="btn btn-warning " onclick="edit_department('<?= $row['id'] ?>')"><i class="fa-solid fa-edit"></i></button>
                        <button class="btn btn-danger " onclick="if(confirm('Are you Sure!!')) { delete_department('<?= $row['id'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
        <?php
                $counter++;
            }
        }
        ?>
    </tbody>
</table>