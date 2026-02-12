<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../js\bootstrap.bundle.min.js" />
    <link rel="icon" type="image/x-icon" href="../Pics/Logos/Lagro_High_School_logo.png">

    <title>Confinement Form</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        main {
            display: flex;
        }

        .container {
            display: grid;
            grid-template-columns: minmax(250px, 2fr);
            gap: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
            border-radius: 16px;
            width: 70%;
            margin: auto;
            padding: 10px;
            background-color: white;
            margin-top: 20px;

        }

        .sidebar-container {
            position: relative;
            left: 0;

        }

        .confinement-form {}

        .table-container {
            margin: auto;
            padding: 10px;
            width: 100%;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 7px 10px 7px 10px;
            font-weight: bold;
        }

        .label {
            position: relative;
            background: var(--gradient-color);
            color: var(--font-color);
            font-weight: bold;
            padding: 10px;
            height: 60px;
            line-height: 40px;
            margin: -30px;
            margin-bottom: 15px;
            box-shadow: 0px 5px 3px 0px rgba(0, 0, 0, 0.2);
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        input[type="date"],
        select {
            width: 100%;
            height: 35px;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 8px;
            border: none;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        .btn {
            float: right;
            margin: 5px 6px 15px 6px;
            width: 10rem;
        }

        /* LRN Search Dropdown Styles */
        .lrn-search-container {
            position: relative;
        }

        .lrn-search-container input[type="text"] {
            width: 100%;
        }

        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #999;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 100;
        }

        .search-result-item {
            padding: 8px 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            font-weight: normal;
            font-size: 13px;
        }

        .search-result-item:hover {
            background-color: #f0f0f0;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item .lrn-text {
            font-weight: bold;
        }

        .search-result-item .name-text {
            color: #666;
            margin-left: 8px;
        }
    </style>
</head>

<body>
    <main>
        <div class="sidebar-container">
            <?php include "../include/sidebar.php" ?>
        </div>
        <div class="container mb-5">
            <form id="confinementForm" class="confinement-form">

                <div class="table-container">
                    <table class="student" border="0" style="table-layout: fixed;">
                        <tr>
                            <th colspan="3">
                                <h4 class="label">STUDENT INFO</h4>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label for="lrn" class="info-label">LRN: </label>
                                <div class="lrn-search-container">
                                    <input type="text" name="lrn" id="lrn" placeholder="Type LRN to search..." autocomplete="off">
                                    <div class="search-results-dropdown" id="searchResults"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="first_name" class="info-label">First Name: </label>
                                <input type="text" name="first_name" id="first_name" readonly>
                            </td>
                            <td>
                                <label for="middle_name" class="info-label">Middle Name: </label>
                                <input type="text" name="middle_name" id="middle_name" readonly>
                            </td>
                            <td>
                                <label for="last_name" class="info-label">Last Name: </label>
                                <input type="text" name="last_name" id="last_name" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label for="grade_section" class="info-label">Grade & Section: </label>
                                <input type="text" name="grade_section" id="grade_section" readonly>
                            </td>
                            <td>
                                <label for="age" class="info-label">Age: </label>
                                <input type="text" name="age" id="age" readonly>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="table-container">
                    <table class="contact" border="0" style="table-layout: fixed;">
                        <tr>
                            <th colspan="2">
                                <h4 class="label">CONTACT INFO</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <label for="student_contact" class="info-label">Student Contact No: </label>
                                <input type="text" name="student_contact" id="student_contact" readonly>
                            </td>
                            <td>
                                <label for="parent_contact" class="info-label">Parent/Guardian Contact:</label>
                                <input type="text" name="parent_contact" id="parent_contact" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-container">

                    <table class="sickness">
                        <tr>
                            <td>
                                <h4 class="label">MEDICAL CONDITION</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="sickness" id="sickness">
                                    <option value="">Select Medical Condition</option>
                                    <option value="flu">Flu</option>
                                    <option value="cold">Cold</option>
                                    <option value="fever">Fever</option>
                                    <option value="cough">Cough</option>
                                    <option value="headache">Headache</option>
                                    <option value="stomachache">Stomachache</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-light" onclick="clearAllFields()">Reset</button>
            </form>
        </div>
    </main>

    <?php include "../include/footer.php" ?>

    <script>
        let currentStudentLrn = null;
        let allStudents = [];

        // Load students on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadStudents();
            setupLrnSearch();
        });

        // Load all students for LRN search
        function loadStudents() {
            fetch('../process/api.php?action=get_all_students')
                .then(response => response.json())
                .then(data => {
                    if (data.students) {
                        allStudents = data.students;
                    }
                })
                .catch(error => console.error('Error loading students:', error));
        }

        // Setup LRN search input listener
        function setupLrnSearch() {
            const lrnInput = document.getElementById('lrn');
            lrnInput.addEventListener('input', (e) => {
                filterByLrn(e.target.value);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.lrn-search-container')) {
                    document.getElementById('searchResults').style.display = 'none';
                }
            });
        }

        // Filter students by LRN
        function filterByLrn(searchText) {
            const dropdown = document.getElementById('searchResults');
            dropdown.innerHTML = '';

            if (!searchText.trim()) {
                dropdown.style.display = 'none';
                return;
            }

            if (searchText.trim().length < 3) {
                dropdown.style.display = 'none';
                return;
            }

            const filtered = allStudents.filter(student => {
                const lrn = (student.lrn || '').toLowerCase();
                return lrn.includes(searchText.toLowerCase());
            });

            if (filtered.length === 0) {
                dropdown.style.display = 'none';
                return;
            }

            filtered.forEach(student => {
                const div = document.createElement('div');
                div.className = 'search-result-item';
                div.innerHTML = '<span class="lrn-text">' + (student.lrn || 'N/A') + '</span>' +
                    '<span class="name-text">- ' + student.first_name + ' ' + student.middle_name + ' ' + student.last_name + '</span>';
                div.onclick = () => selectStudent(student);
                dropdown.appendChild(div);
            });

            dropdown.style.display = 'block';
        }

        // Select a student from the dropdown and populate fields
        function selectStudent(student) {
            currentStudentLrn = student.lrn;
            document.getElementById('lrn').value = student.lrn || '';
            document.getElementById('searchResults').style.display = 'none';

            // Fetch full student info using user_id
            fetch('../process/api.php?action=get_student_info&user_id=' + student.user_id)
                .then(response => response.json())
                .then(data => {
                    if (data.student) {
                        const s = data.student;
                        document.getElementById('first_name').value = s.first_name || '';
                        document.getElementById('middle_name').value = s.middle_name || '';
                        document.getElementById('last_name').value = s.last_name || '';
                        document.getElementById('grade_section').value = s.grade_section || '';
                        document.getElementById('age').value = s.age || '';
                        document.getElementById('student_contact').value = s.contact || '';
                        document.getElementById('parent_contact').value = s.guardian_no || '';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Clear all fields
        function clearAllFields() {
            document.getElementById('lrn').value = '';
            document.getElementById('first_name').value = '';
            document.getElementById('middle_name').value = '';
            document.getElementById('last_name').value = '';
            document.getElementById('grade_section').value = '';
            document.getElementById('age').value = '';
            document.getElementById('student_contact').value = '';
            document.getElementById('parent_contact').value = '';
            document.getElementById('sickness').value = '';
            currentStudentLrn = null;
        }

        // Handle form submission
        document.getElementById('confinementForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!currentStudentLrn) {
                alert('Please search and select a student by LRN first.');
                return;
            }

            const sickness = document.getElementById('sickness').value;
            if (!sickness) {
                alert('Please select a medical condition.');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'save_confinement');
            formData.append('lrn', document.getElementById('lrn').value);
            formData.append('first_name', document.getElementById('first_name').value);
            formData.append('middle_name', document.getElementById('middle_name').value);
            formData.append('last_name', document.getElementById('last_name').value);
            formData.append('grade_section', document.getElementById('grade_section').value);
            formData.append('age', document.getElementById('age').value);
            formData.append('student_contact', document.getElementById('student_contact').value);
            formData.append('parent_contact', document.getElementById('parent_contact').value);
            formData.append('illness', sickness);

            fetch('../process/api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Confinement record saved successfully!');
                        clearAllFields();
                    } else {
                        alert('Error: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the record.');
                });
        });
    </script>
</body>

</html>