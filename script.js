function addNewRow() {
    const container = document.getElementById('course-list');
    const row = document.createElement('div');
    row.className = 'course-row';
    row.innerHTML = `
        <input type="text" name="course[]" placeholder="Course Name" required>
        <input type="number" name="credits[]" placeholder="Credits" min="1" required>
        <select name="grade[]">
            <option value="4.0">A</option>
            <option value="3.0">B</option>
            <option value="2.0">C</option>
            <option value="1.0">D</option>
            <option value="0.0">F</option>
        </select>
        <button type="button" style="background:#dc3545; flex:0.2" onclick="this.parentNode.remove()">X</button>
    `;
    container.appendChild(row);
}
