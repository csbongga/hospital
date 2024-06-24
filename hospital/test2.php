<?php
include 'conDB.php';
?>
<?php


// Query for number of employees in each department
$dept_sql = "SELECT department, COUNT(*) as employee_count FROM employee_data GROUP BY department";
$dept_result = $conn->query($dept_sql);

$departments = [];
$employee_counts = [];

if ($dept_result->num_rows > 0) {
    while ($row = $dept_result->fetch_assoc()) {
        $departments[] = $row["department"];
        $employee_counts[] = $row["employee_count"];
    }
}

// Query for the count of unique departments
$unique_dept_sql = "SELECT COUNT(DISTINCT department) as num_departments FROM employee_data";
$unique_dept_result = $conn->query($unique_dept_sql);
$unique_dept_row = $unique_dept_result->fetch_assoc();
$num_departments = $unique_dept_row['num_departments'];

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Director's Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Director's Dashboard</h1>
    <h2>Total Number of Departments: <?php echo $num_departments; ?></h2>

    <h3>Number of Employees in Each Department</h3>
    <canvas id="employeeChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('employeeChart').getContext('2d');
        var employeeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($departments); ?>,
                datasets: [{
                    label: 'Number of Employees',
                    data: <?php echo json_encode($employee_counts); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>