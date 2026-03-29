<?php
header('Content-Type: application/json');

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "health_db");

if (isset($_POST['name'], $_POST['weight'], $_POST['height'])) {
    $name = htmlspecialchars($_POST['name']);
    $weight = floatval($_POST['weight']);
    $height = floatval($_POST['height']);

    if ($height > 0) {
        $bmi = $weight / ($height * $height);
        $bmi_rounded = round($bmi, 2);

        // التصنيف
        if ($bmi < 18.5) $status = "Underweight";
        elseif ($bmi < 25) $status = "Normal";
        elseif ($bmi < 30) $status = "Overweight";
        else $status = "Obesity";

        $message = "Hello $name, your BMI is $bmi_rounded ($status).";

        // حفظ في قاعدة البيانات (Step 4)
        $stmt = $conn->prepare("INSERT INTO bmi_history (user_name, weight, height, bmi_value, interpretation) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sddds", $name, $weight, $height, $bmi_rounded, $status);
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'bmi' => $bmi_rounded,
            'status' => $status,
            'message' => $message
        ]);
    }
}
?>

