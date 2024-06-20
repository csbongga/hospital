<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

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
        echo "File uploaded and data inserted successfully.";
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html>

<body>

    <form action="01_upload_text.php" method="post" enctype="multipart/form-data">
        Select text file to upload:
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload File" name="submit">
    </form>

</body>

</html>