<?php
include_once "../conn.php";
$sql = "SELECT ec.event_category, 
               GROUP_CONCAT(DISTINCT event.id ORDER BY event.id SEPARATOR ',') as event_ids, 
               GROUP_CONCAT(DISTINCT event.event_title ORDER BY event.id SEPARATOR ',') as event_titles
        FROM `event`
        JOIN event_category ec ON event.event_category = ec.id
        GROUP BY event_category";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
?>
    <div class="text-center fs-2">กิจกรรมภายในและภายนอกบริษัท</div>
    <div class="row">
        <?php foreach ($result as $row) { ?>
            <div class="col-6 text-center mt-3"><?= htmlspecialchars($row['event_category']); ?></div>
        <?php } ?>
    </div>
    <div class="row">
        <?php mysqli_data_seek($result, 0); // Reset result pointer to start
        while ($row = mysqli_fetch_assoc($result)) {
            $event_titles = explode(',', $row['event_titles']);
            $event_ids = explode(',', $row['event_ids']);
            ?>
            <div class="col-6 mt-3">
                <ul class="list-group">
                    <?php foreach ($event_titles as $index => $title) { ?>
                        <a href="#" class="list-group-item list-group-item-action" onclick="getEventdetail('<?= $event_ids[$index] ?>')">
                            <?= htmlspecialchars($title); ?>
                        </a>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ -</div>
<?php } ?>
