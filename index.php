<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator - Lab 2</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; padding-top: 50px; }
        .container { max-width: 900px; }
        .card { border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card p-4">
                <h2 class="text-center text-primary mb-4">BMI Calculator</h2>
                <div id="result"></div> <form id="bmiForm">
                    <div class="form-group">
                        <label>Full Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Weight (kg):</label>
                        <input type="number" step="0.1" id="weight" name="weight" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Height (m):</label>
                        <input type="number" step="0.01" id="height" name="height" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Calculate & Save</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card p-4">
                <h4 class="mb-3">Calculation History</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>BMI</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="historyTable">
                        <?php
                        // عرض البيانات المخزنة سابقاً
                        $conn = new mysqli("localhost", "root", "", "health_db");
                        if (!$conn->connect_error) {
                            $res = $conn->query("SELECT * FROM bmi_history ORDER BY id DESC LIMIT 5");
                            while($row = $res->fetch_assoc()) {
                                echo "<tr><td>{$row['user_name']}</td><td>{$row['bmi_value']}</td><td>{$row['interpretation']}</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
</body>
</html>
