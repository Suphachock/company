<?php
include_once '../conn.php'
?>
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
            transform: scale(1.02);
        }

        .close-btn {
            position: absolute;
            top: 0px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 28px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .close-btn:hover {
            background-color: rgba(255, 0, 0, 0.8);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body class="bg-light" style="background-image: url('bg/002.png'); background-size: cover;">
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <img src="https://sr-advanced.com/img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mx-3" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fs-5 fw-bold" aria-current="page" href="index.php">Home</a>
                </li>
            </ul>
        </div>
    </nav> -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid mx-3">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active fs-5 fw-bold" aria-current="page" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active fs-4" onclick="manageWeb()"><i class="fa-solid fa-globe"></i> All Website</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="manageVdo()"><i class="fa-solid fa-film"></i> Video Guide</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="manageEvent()"><i class="fa-solid fa-flag"></i> Events</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="manageTel()"><i class="fa-solid fa-phone"></i> Telephone</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="manageHoliday()"><i class="fa-regular fa-calendar"></i> วันหยุดบริษัท</a>
                    <a href="#" class="list-group-item list-group-item-action fs-4" onclick="manageUser()"><i class="fa-regular fa-user"></i> ระบบสมาชิก</a>
                </div>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-8">
                <div class="card">
                    <!-- <div class="card-header fs-4 fw-bold">
                        <marquee>
                            ***คำขวัญบริษัท*** :: ลดต้นทุน ลดค่าใช้จ่าย เป็นกำไรของบริษัท เป็นโบนัสของพนักงาน
                        </marquee>
                    </div> -->
                    <div class="card-body body_content" style="overflow: auto; height: 80vh;">
                    </div>
                    <div class="modal_show"></div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../controller/admin.js"></script>
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