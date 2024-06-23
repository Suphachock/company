<?php
include_once "../conn.php";
$sql = "SELECT * FROM notice ORDER BY create_date desc";
$result = mysqli_query($conn, $sql);
?>

<?php if ($result) : ?>
    <div class="accordion mb-3" id="accordionPanelsStayOpenExample">
        <?php foreach ($result as $index => $row) : ?>
            <div class="accordion-item">
                <div class="accordion-header" id="panelsStayOpen-heading<?= $index ?>">
                    <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $index ?>" aria-controls="panelsStayOpen-collapse<?= $index ?>">
                        [<?= $row['create_date'] ?>] <?= $row['title'] ?>
                    </button>
                </div>
                <div id="panelsStayOpen-collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading<?= $index ?>">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <div class="col-12 fs-5">
                                <?= $row['detail'] ?>
                            </div>
                        </div>
                        <?php if (!empty($row['img'])) : ?>
                            <div class="row">
                                <?php
                                $images = explode(',', $row['img']);
                                foreach ($images as $image) : ?>
                                    <div class="col-12 text-center mb-2">
                                        <img src="img/notice/<?= trim($image) ?>" alt="Image" style="width:90%;object-fit: cover;">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>No notices found.</p>
<?php endif; ?>
