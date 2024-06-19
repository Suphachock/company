<?php
include_once "../conn.php";
$sql = "SELECT * FROM website ORDER BY id";
$result = mysqli_query($conn, $sql);

?>
<div class="row align-items-center text-center">
<div class="col-lg-10 col-md-10 col-sm-9 col-9">
        <div class="text-center fs-2">จัดการเว็บทั้งหมด</div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-3 col-3 ">
        <button class="btn btn-primary" onclick="show_md_website_add()"><i class="fa-solid fa-plus"></i> เพิ่มเว็บไซต์</button>
    </div>
</div>
<div class="row mt-3">
    <?php
    if ($result) {
        foreach ($result as $row) { ?>
            <div class="col-12 col-md-6 col-lg-3 mb-4"> <!-- Updated grid classes for responsiveness -->
                <div class="card card_web">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7 text-start"> <!-- Adjusted for better responsiveness -->
                                <h5 class="card-title fs-3"><?= $row['web_name'] ?></h5>
                            </div>
                            <div class="col-5 text-end">
                                <button class="btn btn-warning" onclick="md_edit_web('<?= $row['id'] ?>')"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="btn btn-danger" onclick="delete_web('<?= $row['id'] ?>','<?= $row['web_img']?>')"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <a href="<?= $row['web_url'] ?>" class="text-decoration-none" target="_blank">
                                <img src="../img/web_pic/<?= $row['web_img'] ?>" class="card-img-top w-100" style="width: 250px; height:100px" alt="...">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

    <?php  }
    } ?>
</div>