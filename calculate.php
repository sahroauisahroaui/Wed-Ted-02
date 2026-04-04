<?php
if (isset($_POST['course'], $_POST['credits'], $_POST['grade'])) {
    $courses = $_POST['course'];
    $credits = $_POST['credits'];
    $grades = $_POST['grade'];
    $totalPoints = 0;
    $totalCredits = 0;

    echo "<table><tr><th>Course</th><th>Credits</th><th>Grade Points</th></tr>";
    
    for ($i = 0; $i < count($courses); $i++) {
        $cr = floatval($credits[$i]);
        $g = floatval($grades[$i]);
        $pts = $cr * $g;
        $totalPoints += $pts;
        $totalCredits += $cr;
        
        echo "<tr><td>{$courses[$i]}</td><td>{$cr}</td><td>{$pts}</td></tr>";
    }
    echo "</table>";

    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        $interp = ($gpa >= 3.7) ? "Distinction" : (($gpa >= 3.0) ? "Merit" : (($gpa >= 2.0) ? "Pass" : "Fail"));
        echo "<p>Your GPA is <strong>" . number_format($gpa, 2) . "</strong> ($interp)</p>";
    }
}
?>
