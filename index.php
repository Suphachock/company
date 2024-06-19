<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เว็บภายในบริษัท SR&SK</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
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

<body class="bg-light" style="background-image: url('bg/002.png'); background-size: cover;">
    <nav class="navbar navbar-expand-lg navbar-white bg-secondary">
        <img src="https://sr-advanced.com/img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-3" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fs-5 fw-bold" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5 fw-bold" href="https://www.sr-advanced.com/" target="_blank">SR-Advanced</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5 fw-bold" href="https://showerking.co.th/" target="_blank">Showerking</a>
                </li>

            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-2 col-sm-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getWebsite()"><i class="fa-solid fa-globe"></i> All Website</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getVDO()"><i class="fa-solid fa-film"></i> Video Guide</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getEvent()"><i class="fa-solid fa-flag"></i> Events</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getTel()"><i class="fa-solid fa-phone"></i> Telephone</a>
                    <a href="http://10.10.10.237:41002/" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-calendar-check"></i> จองห้องประชุม</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="getCalendar()"><i class="fa-regular fa-calendar"></i> วันหยุดบริษัท</a>
                    <a href="https://www.google.com/" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-brands fa-google"></i> GOOGLE</a>
                    <a href="https://mail.google.com/mail/u/0/#inbox" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-envelope"></i> GMAIL</a>
                    <a href="https://drive.google.com/drive/home" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-brands fa-google-drive"></i> GOOGLE DRIVE</a>
                    <a href="https://www.google.com/maps" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-map-location-dot"></i> GOOGLE MAPS</a>
                    <a href="https://translate.google.co.th/" target="_blank" class="list-group-item list-group-item-action fs-4"><i class="fa-solid fa-language fa-xs"></i> GOOGLE TRANSLATE</a>

                </div>
            </div>
            <div class="col-md-10 col-sm-9">
                <div class="card">
                    <div class="card-header fs-4 fw-bold">
                        <marquee>
                            ***คำขวัญบริษัท*** :: ลดต้นทุน ลดค่าใช้จ่าย เป็นกำไรของบริษัท เป็นโบนัสของพนักงาน
                        </marquee>
                    </div>
                    <div class="card-body body_content" style="overflow: auto; height: 80vh;">
                        <div class="text-center fs-3">ประกาศจากทางแผนก....</div>
                        <!-- <img src="img/Telephone-46.png" style="width: 100%; object-fit: cover;" /> -->
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->

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