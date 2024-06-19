<?php
include_once "../conn.php";
$sql = "SELECT * FROM website ORDER BY id";
$result = mysqli_query($conn, $sql);

?>
<div class="row mt-3">
    <?php
    if ($result) {
        foreach ($result as $row) { ?>
            <div class="col-12 col-md-6 col-lg-3 mb-4"> <!-- Updated grid classes for responsiveness -->
                <a href="<?= $row['web_url'] ?>" class="text-decoration-none" target="_blank">
                    <div class="card card_web">
                        <div class="card-body">
                            <div class="row">
                                <div class="col text-center"> <!-- Adjusted for better responsiveness -->
                                    <h5 class="card-title fs-3"><?= $row['web_name'] ?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <img src="img/web_pic/<?= $row['web_img'] ?>" class="card-img-top w-100" style="height:100px" alt="...">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php  }
    } else { ?>
        <div class="text-center fs-1">- ไม่มีข้อมูลในระบบ - </div>
    <?php } ?>
</div>