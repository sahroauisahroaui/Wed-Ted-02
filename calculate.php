<?php
$result = "";
$tableHtml = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course'])) {
    $courses = $_POST['course'];
    $credits = $_POST['credits'];
    $grades = $_POST['grade'];
    $totalPoints = 0;
    $totalCredits = 0;

    $tableHtml = "<table class='summary-table'>
                    <thead>
                        <tr><th>Course</th><th>Credits</th><th>Grade Points</th></tr>
                    </thead>
                    <tbody>";

    for ($i = 0; $i < count($courses); $i++) {
        $name = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $g = floatval($grades[$i]);
        $points = $cr * $g;
        $totalPoints += $points;
        $totalCredits += $cr;
        $tableHtml .= "<tr><td>$name</td><td>$cr</td><td>$points</td></tr>";
    }
    $tableHtml .= "</tbody></table>";

    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        $status = ($gpa >= 3.7) ? "Distinction" : (($gpa >= 3.0) ? "Merit" : (($gpa >= 2.0) ? "Pass" : "Fail"));
        $result = "Your GPA is: <strong>" . number_format($gpa, 2) . "</strong> ($status)";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPA Calculator - Sahraoui Chaima</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>GPA Calculator</h1>
        
        <?php if ($result != ""): ?>
            <div class="result-container">
                <p><?php echo $result; ?></p>
                <?php echo $tableHtml; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" id="gpaForm">
            <div id="course-list">
                <div class="course-row">
                    <input type="text" name="course[]" placeholder="Course Name" required>
                    <input type="number" name="credits[]" placeholder="Credits" min="1" required>
                    <select name="grade[]">
                        <option value="4.0">A (4.0)</option>
                        <option value="3.0">B (3.0)</option>
                        <option value="2.0">C (2.0)</option>
                        <option value="1.0">D (1.0)</option>
                        <option value="0.0">F (0.0)</option>
                    </select>
                </div>
            </div>
            <div class="buttons">
                <button type="button" onclick="addNewRow()">+ Add Course</button>
                <button type="submit">Calculate GPA</button>
            </div>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
