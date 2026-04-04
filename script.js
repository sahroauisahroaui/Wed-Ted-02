function addCourse() {
    var container = document.getElementById('courses');
    var row = document.createElement('div');
    row.className = 'course-row';
    
    row.innerHTML = `
        <label>المادة:</label>
        <input type="text" name="course[]" required>
        <label>الساعات:</label>
        <input type="number" name="credits[]" min="1" required>
        <label>الدرجة:</label>
        <select name="grade[]">
            <option value="4.0">A / A+ (4.0)</option>
            <option value="3.0">B (3.0)</option>
            <option value="2.0">C (2.0)</option>
            <option value="1.0">D (1.0)</option>
            <option value="0.0">F (0.0)</option>
        </select>
        <button type="button" onclick="this.parentNode.remove()" style="color:red">حذف</button>
    `;
    container.appendChild(row);
}

function validateForm() {
    var credits = document.querySelectorAll('input[name="credits[]"]');
    for (var i = 0; i < credits.length; i++) {
        if (credits[i].value <= 0) {
            alert("عدد الساعات يجب أن يكون أكبر من صفر!");
            return false;
        }
    }
    return true;
}
