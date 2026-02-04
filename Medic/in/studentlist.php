<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        .active {
            display: block !important;
        }

        .container {
            margin: auto;
            padding: 10px;
            width: 70%;
            min-height: 400px;
        }

        /* Table */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid black;
            border-radius: 12px 12px 0px 0px;
            height: 60px;
            padding: 0 20px;
            gap: 20px;
        }

        .header-filters {
            display: flex;
            gap: 15px;
        }

        .header-filters select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .search-bar {
            border-radius: 8px;
            padding: 8px 12px;
            border: 1px solid #ccc;
            width: 250px;
            font-size: 14px;
        }

        .search-btn {
            position: relative;
            background-color: #ffffff00;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }

        .header-filters select:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            background-color: #f5f5f5;
        }

        .table-container {
            width: 100%;
            border: 2px solid black;
            border-top: none;
            border-radius: 0px 0px 12px 12px;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        thead tr {
            background-color: #f5f5f5;
            border-bottom: 2px solid #000;
        }

        #table-button {}

        td img {
            border-radius: 50%;
            object-fit: cover;
        }

        /* Modal Styles */
        .modal {
            z-index: 1000;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-items: center;
            align-content: center;
            position: fixed;
            top: 0;
            left: 0;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 700px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 15px;
        }

        .modal-title {
            font-weight: bold;
            font-size: 22px;
            color: #333;
        }

        .close-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .close-btn:hover {
            background-color: #da190b;
        }

        .student-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .student-info-row {
            display: flex;
            gap: 30px;
            margin-bottom: 8px;
        }

        .student-info-item {
            flex: 1;
        }

        .student-info-label {
            font-weight: bold;
            color: #555;
            font-size: 12px;
        }

        .student-info-value {
            color: #333;
            margin-top: 2px;
        }

        .records-section {
            margin-top: 20px;
        }

        .records-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-record {
            background-color: #f9f9f9;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 4px;
        }

        .modal-record-date {
            font-size: 11px;
            color: #888;
            margin-bottom: 8px;
        }

        .modal-record-text {
            color: #333;
            font-size: 13px;
            word-wrap: break-word;
            white-space: pre-wrap;
            line-height: 1.5;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #888;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .btn-action {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view {
            background-color: #4CAF50;
            color: white;
        }

        .btn-view:hover {
            background-color: #45a049;
        }

        .btn-edit {
            background-color: #2196F3;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0b7dda;
        }
    </style>
    <title>Student List</title>
</head>

<body>
    <?php include "../include/header.php" ?>
    <main class="container mt-5">

        <div class="table-header">
            <div class="header-filters">
                <select id="gradeFilter">
                    <option value="">All Grades</option>
                </select>
                <select id="sectionFilter">
                    <option value="">All Sections</option>
                </select>
                <select id="genderFilter">
                    <option value="">All Genders</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="search">
                <input type="text" class="search-bar" id="searchInput" placeholder="Search by name...">
                <button class="search-btn" type="button"><i class="ri-search-line"></i></button>
            </div>
        </div>

        <div class="table-container">
            <table cellpadding="10" cellspacing="0" class="table" border="0">
                <thead>
                    <tr>
                        <th style="width: 5%;">Photo</th>
                        <th style="text-align: center; width: 30%;">Name</th>
                        <th style="text-align: center; width: 12%;">Grade</th>
                        <th style="text-align: center; width: 15%;">Section</th>
                        <th style="text-align: center; width: 8%;">Age</th>
                        <th style="text-align: center; width: 12%;">Gender</th>
                        <th style="text-align: center; width: 18%;">Actions</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    <?php include "../include/db.php";

                    if (!isset($_SESSION['account_id'])) {
                        echo "<tr><td colspan='7'><strong>Please log in to view students.</strong></td></tr>";
                    } else {
                        $account_id = $_SESSION['account_id'];
                        $sql = "SELECT * FROM user_info WHERE account_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $account_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gradeSection = $row['grade_section'];
                                $parts = explode(' - ', $gradeSection);
                                $grade = trim($parts[0] ?? '');
                                $section = trim($parts[1] ?? $gradeSection);
                    ?>

                                <tr>
                                    <td><img src="../uploads/<?php echo htmlspecialchars($row['picture']); ?>" alt="Student" width="50" height="50" style="border-radius:50%;"></td>
                                    <td style="text-transform: uppercase;"><?php echo htmlspecialchars($row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($grade); ?></td>
                                    <td style="text-transform: uppercase;"><?php echo htmlspecialchars($section); ?></td>
                                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                                    <td style="text-transform: uppercase;"><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td id="table-button">
                                        <button type="button" class="btn-action btn-view" onclick="anecdote(<?php echo $row['user_id']; ?>)">View</button>
                                        <button type="button" class="btn-action btn-edit" onclick="openEditModal(<?php echo $row['user_id']; ?>)">Edit</button>
                                    </td>
                                </tr>

                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='no-results'>No records found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Edit Student Modal -->
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Edit Student Information</div>
                <button class="close-btn" onclick="closeEditModal()">Close</button>
            </div>

            <form id="editForm" style="display: none;">
                <div class="student-info">
                    <div class="student-info-row">
                        <div class="student-info-item">
                            <label class="student-info-label">First Name</label>
                            <input type="text" id="editFirstName" class="form-control" required>
                        </div>
                        <div class="student-info-item">
                            <label class="student-info-label">Middle Name</label>
                            <input type="text" id="editMiddleName" class="form-control">
                        </div>
                        <div class="student-info-item">
                            <label class="student-info-label">Last Name</label>
                            <input type="text" id="editLastName" class="form-control" required>
                        </div>
                    </div>

                    <div class="student-info-row">
                        <div class="student-info-item">
                            <label class="student-info-label">Email</label>
                            <input type="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="student-info-item">
                            <label class="student-info-label">Age</label>
                            <input type="number" id="editAge" class="form-control">
                        </div>
                        <div class="student-info-item">
                            <label class="student-info-label">Gender</label>
                            <select id="editGender" class="form-control">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="student-info-row">
                        <div class="student-info-item">
                            <label class="student-info-label">Grade</label>
                            <input type="text" id="editGrade" class="form-control" required>
                        </div>
                        <div class="student-info-item">
                            <label class="student-info-label">Section</label>
                            <input type="text" id="editSection" class="form-control" required>
                        </div>
                    </div>

                    <div class="student-info-row">
                        <div class="student-info-item">
                            <label class="student-info-label">Contact Number</label>
                            <input type="text" id="editContactNumber" class="form-control">
                        </div>
                        <div class="student-info-item">
                            <label class="student-info-label">Address</label>
                            <input type="text" id="editAddress" class="form-control">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn-action" style="background-color: #f44336; color: white;" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-action" style="background-color: #4CAF50; color: white;">Save Changes</button>
                </div>
            </form>

            <div class="loading" id="editLoading">Loading student information...</div>
        </div>
    </div>

    <!-- Anecdotal Modal -->
    <div id="anecdotalModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Anecdotal Records</div>
                <button class="close-btn" onclick="closeAnecdotalModal()">Close</button>
            </div>

            <div class="student-info" id="studentInfo" style="display:none;">
                <div class="student-info-row">
                    <div class="student-info-item">
                        <div class="student-info-label">Name</div>
                        <div class="student-info-value" id="modalStudentName">-</div>
                    </div>
                    <div class="student-info-item">
                        <div class="student-info-label">Section</div>
                        <div class="student-info-value" id="modalStudentGrade">-</div>
                        <div class="student-info-value" id="modalStudentSection">-</div>
                    </div>
                </div>
                <div class="student-info-row">
                    <div class="student-info-item">
                        <div class="student-info-label">Age</div>
                        <div class="student-info-value" id="modalStudentAge">-</div>
                    </div>
                    <div class="student-info-item">
                        <div class="student-info-label">Gender</div>
                        <div class="student-info-value" id="modalStudentGender">-</div>
                    </div>
                </div>
            </div>

            <div class="records-section">
                <div class="records-title">Records</div>
                <div id="modalRecordsList" class="loading">Loading records...</div>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php" ?>

    <script>
        let currentAnecdotalUserId = null;
        let currentEditUserId = null;

        window.addEventListener('DOMContentLoaded', function() {
            loadGradesAndSections();
            setupEditFormListener();
        });

        function loadGradesAndSections() {
            fetch('../process/api.php?action=get_grades_sections')
                .then(response => response.json())
                .then(data => {
                    if (data.grades) {
                        const gradeSelect = document.getElementById('gradeFilter');
                        data.grades.forEach(grade => {
                            const option = document.createElement('option');
                            option.value = grade;
                            option.textContent = grade;
                            gradeSelect.appendChild(option);
                        });
                    }

                    if (data.sections) {
                        const sectionSelect = document.getElementById('sectionFilter');
                        data.sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section;
                            option.textContent = section;
                            sectionSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error loading grades/sections:', error));
        }

        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchQuery = this.value.trim();
            const grade = document.getElementById('gradeFilter').value;
            const section = document.getElementById('sectionFilter').value;
            const gender = document.getElementById('genderFilter').value;

            if (!searchQuery && !grade && !section && !gender) {
                location.reload();
            } else if (searchQuery.length >= 1 || grade || section || gender) {
                performSearch(searchQuery, grade, section, gender);
            }
        });

        document.getElementById('gradeFilter').addEventListener('change', function() {
            const searchQuery = document.getElementById('searchInput').value.trim();
            const grade = this.value;
            const section = document.getElementById('sectionFilter').value;
            const gender = document.getElementById('genderFilter').value;

            performSearch(searchQuery, grade, section, gender);
        });

        document.getElementById('sectionFilter').addEventListener('change', function() {
            const searchQuery = document.getElementById('searchInput').value.trim();
            const grade = document.getElementById('gradeFilter').value;
            const section = this.value;
            const gender = document.getElementById('genderFilter').value;

            performSearch(searchQuery, grade, section, gender);
        });

        document.getElementById('genderFilter').addEventListener('change', function() {
            const searchQuery = document.getElementById('searchInput').value.trim();
            const grade = document.getElementById('gradeFilter').value;
            const section = document.getElementById('sectionFilter').value;
            const gender = this.value;

            performSearch(searchQuery, grade, section, gender);
        });

        function performSearch(query, grade, section, gender) {
            const params = new URLSearchParams({
                action: 'search_students',
                search: query,
                grade: grade,
                section: section,
                gender: gender
            });

            fetch(`../process/api.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('studentTableBody');
                    tbody.innerHTML = '';

                    if (data.students && data.students.length > 0) {
                        data.students.forEach(student => {
                            const gradeSection = student.grade_section;
                            const parts = gradeSection.split(' - ');
                            const studentGrade = parts[0] ? parts[0].trim() : '';
                            const studentSection = parts[1] ? parts[1].trim() : gradeSection;

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td><img src="../uploads/${student.picture}" alt="Student" width="50" height="50" style="border-radius:50%;"></td>
                                <td style="text-transform: uppercase;">${student.first_name} ${student.middle_name} ${student.last_name}</td>
                                <td>${studentGrade}</td>
                                <td style="text-transform: uppercase;">${studentSection}</td>
                                <td>${student.age}</td>
                                <td style="text-transform: uppercase;">${student.gender}</td>
                                <td id="table-button">
                                    <button type="button" class="btn-action btn-view" onclick="anecdote(${student.user_id})">View</button>
                                    <button type="button" class="btn-action btn-edit" onclick="openEditModal(${student.user_id})">Edit</button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('Error performing search:', error);
                });
        }

        function anecdote(userId) {
            currentAnecdotalUserId = userId;
            loadStudentInfoModal(userId);
            loadAnecdotalRecordsModal(userId);
            document.getElementById('anecdotalModal').style.display = 'flex';
        }

        function closeAnecdotalModal() {
            document.getElementById('anecdotalModal').style.display = 'none';
        }

        function openEditModal(userId) {
            currentEditUserId = userId;
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('editLoading').style.display = 'block';

            // Fetch student data
            fetch(`../process/api.php?action=get_student_info&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.student) {
                        const student = data.student;
                        const gradeSection = student.grade_section;
                        const parts = gradeSection.split(' - ');
                        const grade = parts[0] ? parts[0].trim() : '';
                        const section = parts[1] ? parts[1].trim() : '';

                        document.getElementById('editFirstName').value = student.first_name || '';
                        document.getElementById('editMiddleName').value = student.middle_name || '';
                        document.getElementById('editLastName').value = student.last_name || '';
                        document.getElementById('editEmail').value = student.email || '';
                        document.getElementById('editAge').value = student.age || '';
                        document.getElementById('editGender').value = student.gender || '';
                        document.getElementById('editGrade').value = grade || '';
                        document.getElementById('editSection').value = section || '';
                        document.getElementById('editContactNumber').value = student.contact || '';
                        document.getElementById('editAddress').value = student.address || '';

                        document.getElementById('editForm').style.display = 'block';
                        document.getElementById('editLoading').style.display = 'none';
                    } else {
                        alert('Error loading student information');
                        closeEditModal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading student information');
                    closeEditModal();
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.getElementById('editForm').reset();
            currentEditUserId = null;
        }

        function setupEditFormListener() {
            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData();
                formData.append('action', 'update_student');
                formData.append('user_id', currentEditUserId);
                formData.append('first_name', document.getElementById('editFirstName').value);
                formData.append('middle_name', document.getElementById('editMiddleName').value);
                formData.append('last_name', document.getElementById('editLastName').value);
                formData.append('email', document.getElementById('editEmail').value);
                formData.append('age', document.getElementById('editAge').value);
                formData.append('gender', document.getElementById('editGender').value);
                formData.append('grade', document.getElementById('editGrade').value);
                formData.append('section', document.getElementById('editSection').value);
                formData.append('contact_number', document.getElementById('editContactNumber').value);
                formData.append('address', document.getElementById('editAddress').value);

                fetch('../process/api.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Student updated successfully!');
                            closeEditModal();
                            location.reload();
                        } else {
                            alert('Error: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating student');
                    });
            });
        }

        function loadStudentInfoModal(userId) {
            fetch(`../process/api.php?action=get_student_info&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.student) {
                        const student = data.student;
                        const gradeSection = student.grade_section;
                        const parts = gradeSection.split(' - ');
                        const grade = parts[0] ? parts[0].trim() : '';
                        const section = parts[1] ? parts[1].trim() : gradeSection;

                        document.getElementById('modalStudentName').textContent = `${student.first_name} ${student.middle_name} ${student.last_name}`;
                        document.getElementById('modalStudentGrade').textContent = grade;
                        document.getElementById('modalStudentSection').textContent = section;
                        document.getElementById('modalStudentAge').textContent = student.age;
                        document.getElementById('modalStudentGender').textContent = student.gender;
                        document.getElementById('studentInfo').style.display = 'block';
                    }
                })
                .catch(error => console.error('Error loading student info:', error));
        }

        function loadAnecdotalRecordsModal(userId) {
            fetch(`../process/api.php?action=get_records&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    const recordsList = document.getElementById('modalRecordsList');
                    recordsList.innerHTML = '';

                    if (data.records && data.records.length > 0) {
                        data.records.forEach(record => {
                            const div = document.createElement('div');
                            div.className = 'modal-record';

                            const dateDiv = document.createElement('div');
                            dateDiv.className = 'modal-record-date';
                            const recordDate = new Date(record.created_at);
                            const staffName = record.first_name && record.last_name ? `${record.first_name} ${record.last_name}` : 'Unknown';
                            dateDiv.textContent = `Recorded on ${recordDate.toLocaleDateString()} at ${recordDate.toLocaleTimeString()} by ${staffName}`;

                            const textDiv = document.createElement('div');
                            textDiv.className = 'modal-record-text';
                            textDiv.textContent = record.record_text;

                            div.appendChild(dateDiv);
                            div.appendChild(textDiv);
                            recordsList.appendChild(div);
                        });
                    } else {
                        recordsList.innerHTML = '<div style="text-align: center; color: #888; padding: 20px;">No anecdotal records found for this student</div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading records:', error);
                    document.getElementById('modalRecordsList').innerHTML = '<div style="text-align: center; color: #888; padding: 20px;">Error loading records</div>';
                });
        }

        window.onclick = function(event) {
            const modal = document.getElementById('anecdotalModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>