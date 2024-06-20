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
                <th scope="col">ลำดับ</th>
                <th scope="col">รูปภาพ</th>
                <th scope="col">วันที่สร้าง</th>
                <th scope="col">ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $counter = 1; // Initialize a counter for the row numbers
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($counter) ?></td>
                        <td>
                            <img data-enlargable src="../img/tel/<?= htmlspecialchars($row['tel_pic']) ?>" class="img-fluid" style="max-width:100px; height:auto;" alt="...">
                        </td>
                        <td><?= htmlspecialchars($row['create_date']) ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="if(confirm('คุณต้องการลบหมายเลขโทรศัพท์นี้หรือไม่?')) { delete_tel('<?= $row['id'] ?>', '<?= $row['tel_pic'] ?>'); } return false;"><i class="fa-solid fa-trash"></i></button>
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
<script>
    $(document).ready(function() {
        $('img[data-enlargable]').addClass('img-enlargable').click(function() {
            var src = $(this).attr('src');
            $('<div>').css({
                background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%',
                height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0',
                left: '0',
                cursor: 'zoom-out'
            }).click(function() {
                $(this).remove();
            }).appendTo('body');
        });
    });
</script>