<?php
include_once "../conn.php";
$sql = "SELECT * FROM vdo_category";
$result = mysqli_query($conn, $sql);
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">NO.</th>
            <th scope="col">Category</th>
            <th scope="col" class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result) {
            $counter = 1; // Initialize a counter for the row numbers
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($counter) ?></td>
                    <td><?= htmlspecialchars($row['vdo_category']) ?></td>
                    <td class="text-end">
                        <button class="btn btn-danger " onclick="if(confirm('Are you Sure!!')) { delete_vdo_category('<?= $row['id'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
        <?php
                $counter++;
            }
        }
        ?>
    </tbody>
</table>