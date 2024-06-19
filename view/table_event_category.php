<?php
include_once "../conn.php";
$sql = "SELECT * FROM event_category";
$result = mysqli_query($conn, $sql);
?>
<table class="table ">
    <thead>
        <tr>
            <th scope="col-auto">NO.</th>
            <th scope="col-auto">หมวดหมู่อีเว้นท์</th>
            <th scope="col-auto" class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result) {
            $counter = 1; // Initialize a counter for the row numbers
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($counter) ?></td>
                    <td><?= htmlspecialchars($row['event_category']) ?></td>
                    <td class="text-end">
                        <button class="btn btn-danger " onclick="if(confirm('Are you Sure!!')) { delete_event_category('<?= $row['id'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
        <?php
                $counter++;
            }
        }
        ?>
    </tbody>
</table>