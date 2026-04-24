<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gpa_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(['success' => false]));
}

if (isset($_POST['student_name'], $_POST['course'], $_POST['credits'], $_POST['grade'])) {
    
    $studentName = htmlspecialchars($_POST['student_name']);
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
        $stmt->bind_param("sd", $studentName, $gpa);
        $stmt->execute();
        $stmt->close();

        $percent = ($gpa / 4) * 100; 
        $color = ($gpa >= 3.0) ? "bg-success" : (($gpa >= 2.0) ? "bg-warning" : "bg-danger");
        
        $progressBar = '
        <div class="progress mb-3" style="height: 25px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated '.$color.'" 
                 role="progressbar" style="width: '.$percent.'%">
                '.number_format($gpa, 2).'
            </div>
        </div>';

        $tableHtml = '
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr><th>Course</th><th>Credits</th><th>Grade</th><th>Points</th></tr>
            </thead>
            <tbody>'.$tableRows.'</tbody>
        </table>';

        echo json_encode([
            'success' => true,
            'student' => $studentName,
            'gpa' => number_format($gpa, 2),
            'status' => $status,
            'progressBar' => $progressBar,
            'tableHtml' => $tableHtml
        ]);

    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
