$(document).ready(function () {
    $('#addCourse').click(function (e) {
        e.preventDefault();
        var row = $('.course-row').first().clone();
        row.find('input').val('');
        row.find('.remove-btn').remove();
        row.append('<button type="button" class="remove-btn" style="background:#dc3545; color:white; border:none; padding:5px 10px; cursor:pointer; border-radius:4px;">حذف</button>');
        $('#courses').append(row);
    });

    $(document).on('click', '.remove-btn', function () {
        $(this).closest('.course-row').remove();
    });

    $('#gpaForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'calculate.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#result').html('<div style="text-align:center; color:#007bff;">جاري الحساب...</div>');
            },
            success: function (response) {
                if (response.success) {
                    $('#result').html(
                        '<div style="padding:15px; border-radius:4px; background:#e9ecef;">' + 
                        '<h3>' + response.message + '</h3>' + 
                        (response.progressBar || '') + 
                        (response.tableHtml || '') + 
                        '</div>'
                    );
                } else {
                    $('#result').html('<div style="color:red; padding:10px; border:1px solid red;">' + response.message + '</div>');
                }
            },
            error: function () {
                $('#result').html('<div style="color:red; padding:10px; border:1px solid red;">خطأ: لم يتم العثور على ملف calculate.php أو يوجد خطأ في السيرفر.</div>');
            }
        });
    });
});
