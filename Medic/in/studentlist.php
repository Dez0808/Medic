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
            height: 400px;
        }

        /* Table */
        .table-header {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid black;
            border-radius: 12px 12px 0px 0px;
            height: 50px;
            gap: 800px;
        }

        .header-filters {
            display: flex;
            gap: 15px;
        }

        .header-filters select {
            padding: 5px;
            border-radius: 5px;
            border: none;
        }

        .search-bar {
            border-radius: 8px;
        }

        .search-btn {
            position: relative;
            right: 30px;
            background-color: #ffffff00;
            border: none;
        }

        .header-filters select:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            background-color: var(--hover-bg-color);
        }

        input {
            justify-content: space-around;
        }

        .input-field {
            border: none;
        }

        .table-container {
            width: 100%;
            border: 2px solid black;
            border-top: none;
            border-radius: 0px 0px 12px 12px;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            text-align: center;
            vertical-align: middle;
        }

        #table-button {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 18px;
        }

        td img {
            margin-left: 40px;
        }

        /* Header */
        #student::after {
            width: 100%;
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
    </style>
    <title>Document</title>
</head>

<body>
    <?php include "../include/header.php" ?>
    <main class="container mt-5">

        <div class="table-header">
            <div class="header-filters">
                <select name="" id="">
                    <option value="">Section</option>
                </select>
                <select name="" id="">
                    <option value="">Grade</option>
                </select>
                <select name="" id="">
                    <option value="">Gender</option>
                </select>
            </div>
            <div class="search">
                <input type="text" class="search-bar">
                <button class="search-btn" type="submit"><i class="ri-search-line"></i></button>
            </div>
        </div>

        <div class="table-container">
            <table cellpadding="10" cellspacing="5" class="table" border="0">
                <thead>
                    <tr>
                        <th style="width: 1px;"></th>
                        <th style="text-align: center; width: 40%;">Name</th>
                        <th style="text-align: center;">Section</th>
                        <th style="text-align: center;">Age</th>
                        <th style="text-align: center;">Gender</th>
                        <th style="text-align: center;">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php include "../include/db.php";

                    // Check if user is logged in
                    if (!isset($_SESSION['account_id'])) {
                        echo "<tr><td colspan='6'><strong>Please log in to view patients.</strong></td></tr>";
                    } else {
                        $account_id = $_SESSION['account_id'];
                        $sql = "SELECT * FROM user_info WHERE account_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $account_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>

                            <tr>
                                <td style="width: 100px;"><img src="../uploads/<?php echo $row['picture']; ?>" alt="" width="50px" height="50px" style="border-radius:100%;"></td>
                                <td style="text-transform: uppercase;"><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']; ?></td>
                                <td style="text-transform: uppercase;"><?php echo $row['grade_section']; ?></td>
                                <td><?php echo $row['age']; ?></td>
                                <td style="text-transform: uppercase;"><?php echo $row['gender']; ?></td>
                                <td id="table-button"><button type="button" class="btn btn-success" onclick="anecdote(<?php echo $row['user_id']; ?>)">Anecdote</button><button type="button" class="btn btn-secondary">Edit</button></td>
                            </tr>

                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No records found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

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
                        <div class="student-info-label">Grade & Section</div>
                        <div class="student-info-value" id="modalStudentGrade">-</div>
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

    <div id="content-modal">

    </div>

    <?php include "../include/footer.php" ?>

    <script>
        let currentAnecdotalUserId = null;

        function anecdote(userId) {
            currentAnecdotalUserId = userId;
            loadStudentInfoModal(userId);
            loadAnecdotalRecordsModal(userId);
            document.getElementById('anecdotalModal').style.display = 'block';
        }

        function closeAnecdotalModal() {
            document.getElementById('anecdotalModal').style.display = 'none';
        }

        function loadStudentInfoModal(userId) {
            fetch(`../process/api.php?action=get_student_info&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.student) {
                        const student = data.student;
                        document.getElementById('modalStudentName').textContent = `${student.first_name} ${student.middle_name} ${student.last_name}`;
                        document.getElementById('modalStudentGrade').textContent = student.grade_section;
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
                            dateDiv.textContent = `Recorded on ${recordDate.toLocaleDateString()} at ${recordDate.toLocaleTimeString()}`;

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

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('anecdotalModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <script src="../js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>

</body>

</html>
