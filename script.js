$(document).ready(function() {
    $('#bmiForm').submit(function(e) {
        e.preventDefault(); // منع تحديث الصفحة

        $.ajax({
            url: 'calculate.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var alertClass = 'alert-info';
                    if (response.bmi < 18.5) alertClass = 'alert-warning';
                    else if (response.bmi < 25) alertClass = 'alert-success';
                    else if (response.bmi < 30) alertClass = 'alert-info';
                    else alertClass = 'alert-danger';

                    // عرض الرسالة
                    $('#result').html('<div class="alert ' + alertClass + '">' + response.message + '</div>');
                    
                    // تحديث الجدول فوراً
                    $('#historyTable').prepend('<tr><td>' + $('#name').val() + '</td><td>' + response.bmi + '</td><td>' + response.status + '</td></tr>');
                    $('#bmiForm')[0].reset();
                } else {
                    $('#result').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            }
        });
    });
});

