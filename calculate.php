<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gpa_db";

$conn = new mysqli($host, $user, $pass, $db);

if (isset($_POST['course'], $_POST['credits'], $_POST['grade'])) {
    $courses = $_POST['course'];
    $credits = $_POST['credits'];
    $grades  = $_POST['grade'];
    
    $totalPoints = 0;
    $totalCredits = 0;
    $tableRows = "";

    for ($i = 0; $i < count($courses); $i++) {
        $name = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $gr = floatval($grades[$i]);
        $pts = $cr * $gr;

        if ($cr <= 0) continue;

        $totalPoints += $pts;
        $totalCredits += $cr;
        $tableRows .= "<tr><td>$name</td><td>$cr</td><td>$gr</td><td>$pts</td></tr>";
    }

    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        
        if ($gpa >= 3.7) $status = "Distinction";
        elseif ($gpa >= 3.0) $status = "Merit";
        elseif ($gpa >= 2.0) $status = "Pass";
        else $status = "Fail";

        $stmt = $conn->prepare("INSERT INTO gpa_records (student_name, gpa) VALUES (?, ?)");
        $student = "Student_Trial";
        $stmt->bind_param("sd", $student, $gpa);
        $stmt->execute();

        $percent = ($gpa / 4) * 100;
        $color = ($gpa >= 3.0) ? "bg-success" : (($gpa >= 2.0) ? "bg-warning" : "bg-danger");
        
        $progressBar = '
        <div class="progress mb-3">
            <div class="progress-bar '.$color.'" role="progressbar" style="width: '.$percent.'%">
                '.number_format($gpa, 2).'
            </div>
        </div>';

        $tableHtml = '
        <table class="table table-bordered">
            <thead class="thead-dark"><tr><th>Course</th><th>Credits</th><th>Grade</th><th>Points</th></tr></thead>
            <tbody>'.$tableRows.'</tbody>
        </table>';

        echo json_encode([
            'success' => true,
            'gpa' => $gpa,
            'message' => "GPA: " . number_format($gpa, 2) . " ($status)",
            'progressBar' => $progressBar,
            'tableHtml' => $tableHtml
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No valid data.']);
    }
}
$conn->close();
?>
