<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เว็บภายในบริษัท SR&SK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            background-image: url('bg/002.png');
            background-size: cover;
        }

        .card.card_web {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .card.card_web:hover {
            box-shadow: 5px 6px 6px 2px #e9ecef;
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid mx-3">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i> หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="https://www.sr-advanced.com/" target="_blank">SR-Advanced</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="https://showerking.co.th/" target="_blank">Showerking</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-2 col-sm-3">
                <div class="list-group">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getWebsite()"><i class="fa-solid fa-globe"></i> All Website</a>
                        <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getVDO()"><i class="fa-solid fa-film"></i> Video Guide</a>
                        <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getEvent()"><i class="fa-solid fa-flag"></i> Events</a>
                        <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getTel()"><i class="fa-solid fa-phone"></i> Telephone</a>
                        <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getCalendar()"><i class="fa-regular fa-calendar"></i> วันหยุดบริษัท</a>
                        <a href="http://10.10.10.237:41002/" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-calendar-check"></i> จองห้องประชุม</a>
                        <a href="https://www.google.com/" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-brands fa-google"></i> GOOGLE</a>
                        <a href="https://mail.google.com/mail/u/0/#inbox" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-envelope"></i> GMAIL</a>
                        <a href="https://drive.google.com/drive/home" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-brands fa-google-drive"></i> GOOGLE DRIVE</a>
                        <a href="https://www.google.com/maps" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-map-location-dot"></i> GOOGLE MAPS</a>
                        <a href="https://translate.google.co.th/" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-language fa-xs"></i> GOOGLE TRANSLATE</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-sm-9">
                <div class="card">
                    <div class="card-header fs-4 fw-bold">
                        <marquee>***คำขวัญบริษัท*** :: ลดต้นทุน ลดค่าใช้จ่าย เป็นกำไรของบริษัท เป็นโบนัสของพนักงาน</marquee>
                    </div>
                    <div class="card-body body_content" style="overflow: auto; height: 80vh;">
                        <div class="text-center fs-3">ประกาศจากทางแผนก....</div>
                        <!-- Image commented out -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="controller/main.js"></script>
    <script>
        $(document).ready(function() {
            $(".list-group-item").click(function() {
                $(".list-group-item").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
</body>

</html>