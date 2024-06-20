<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";
$check = 0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $file_name = $_FILES["file"]["name"];
        $file_tmp = $_FILES["file"]["tmp_name"];

        // Read file contents
        $file_contents = file_get_contents($file_tmp);
        $lines = explode("\n", $file_contents);

        $firstLine = true;

        foreach ($lines as $line) {
            // Skip the first line
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            $line = trim($line);
            if (empty($line)) continue;

            // Split the line by tab or other delimiters
            $data = explode("\t", $line);

            $dateString = $data[3];

            // Split the date string to extract the day, month, and year
            list($day, $month, $year) = explode('/', $dateString);

            // Convert Buddhist year to Gregorian year
            $year = $year - 543;

            // Combine the date parts into a new string
            $newDateString = "$year-$month-$day";

            // Convert the date string to a timestamp
            $timestamp = strtotime($newDateString);

            // Format the timestamp to Y-m-d
            $formattedDate = date('Y-m-d', $timestamp);

            // Insert data into the database
            $sql = "INSERT INTO employee_data (
                        code, employee_name, department, date, status, work_time, 
                        break_time, ot_before, ot_after, in_out, in_time, out_time, 
                        late, leave_early, remark
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssssisisssssss",
                $data[0],
                $data[1],
                $data[2],
                $formattedDate,
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $data[13],
                $data[14]
            );
            $stmt->execute();
        }
        //echo "File uploaded and data inserted successfully.";
        $check = 1;
    } else {
        $check = 2;
        //echo "Error uploading file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Bootstrap Forms | CORK - Multipurpose Bootstrap Dashboard Template </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link href="../layouts/horizontal-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/horizontal-light-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/horizontal-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="../src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="../src/assets/css/light/elements/alert.css">
    <link rel="stylesheet" type="text/css" href="../src/assets/css/dark/elements/alert.css">
    <!--  END CUSTOM STYLE FILE  -->
</head>

<body class="layout-boxed" data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <?php include 'navbar.php' ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php include 'menu.php'; ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->




        <div id="content" class="main-content">
            <div class="container">

                <div class="container ">


                    <div class="row layout-top-spacing">



                        <div class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>อัพโหลดไฟล์เข้างาน</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <?php
                                    if ($check == 1) {
                                    ?>
                                        <div class="alert alert-light-success alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg></button> <strong>Success!</strong> อัพโหลดไฟล์เข้างาน สำเร็จ</div>
                                    <?php }
                                    if ($check == 2) {
                                    ?>
                                        <div class="alert alert-light-danger alert-dismissible fade show border-0 mb-4" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg></button> <strong>Error!</strong> อัพโหลดไฟล์เข้างาน ไม่สำเร็จ</div>
                                    <?php }
                                    ?>

                                    <form action="h_form_upload.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group mb-4 mt-3">
                                            <input type="file" class="form-control-file" id="file" name="file">
                                        </div>
                                        <input type="submit" value="ส่ง" class="mt-4 mb-4 btn btn-primary" name="submit">
                                    </form>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <!--  BEGIN FOOTER  -->
            <?php include 'footer.php' ?>
            <!--  END FOOTER  -->

        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/horizontal-light-menu/app.js"></script>
    <script src="../src/plugins/src/highlight/highlight.pack.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/assets/js/scrollspyNav.js"></script>
</body>

</html>