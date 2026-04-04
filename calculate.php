<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course'])) {
    $courses = $_POST['course'];
    $credits = $_POST['credits'];
    $grades  = $_POST['grade'];

    $totalPoints = 0;
    $totalCredits = 0;

    echo "<html><head><link rel='stylesheet' href='style.css'></head><body>";
    echo "<h1>ملخص النتائج</h1>";
    echo "<table>
            <tr>
                <th>المادة</th>
                <th>الساعات المعتمدة</th>
                <th>نقاط الدرجة</th>
                <th>المجموع الفرعي</th>
            </tr>";

    for ($i = 0; $i < count($courses); $i++) {
        $name = htmlspecialchars($courses[$i]);
        $cr   = floatval($credits[$i]);
        $g    = floatval($grades[$i]);
        
        $subTotal = $cr * $g;
        $totalPoints += $subTotal;
        $totalCredits += $cr;

        echo "<tr>
                <td>$name</td>
                <td>$cr</td>
                <td>$g</td>
                <td>$subTotal</td>
              </tr>";
    }
    echo "</table>";

    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        
        // التصنيف حسب الجدول المطلوب
        if ($gpa >= 3.7) $status = "Distinction (امتياز)";
        elseif ($gpa >= 3.0) $status = "Merit (جيد جداً)";
        elseif ($gpa >= 2.0) $status = "Pass (مقبول)";
        else $status = "Fail (راسب)";

        echo "<div class='result-msg'>";
        echo "معدلك التراكمي هو: <span style='color:#007BFF'>" . number_format($gpa, 2) . "</span><br>";
        echo "التقدير: $status";
        echo "</div>";
    }

    echo "<br><center><a href='index.html'>العودة للحساب مرة أخرى</a></center>";
    echo "</body></html>";
} else {
    header("Location: index.html");
}
?>

