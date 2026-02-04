<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
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
            border-left: 4px solid #4CAF50;
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

        .record-item {
            background-color: #f9f9f9;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 4px;
            border-left: 3px solid #4CAF50;
        }

        .record-date {
            font-size: 11px;
            color: #888;
            margin-bottom: 8px;
        }

        .record-text {
            color: #333;
            font-size: 13px;
            word-wrap: break-word;
            white-space: pre-wrap;
            line-height: 1.5;
        }

        .no-records {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            color: #888;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="modal" id="anecdotalModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Anecdotal Records</div>
                <button class="close-btn" onclick="window.close()">Close</button>
            </div>

            <div class="student-info" id="studentInfo" style="display:none;">
                <div class="student-info-row">
                    <div class="student-info-item">
                        <div class="student-info-label">Name</div>
                        <div class="student-info-value" id="studentName">-</div>
                    </div>
                    <div class="student-info-item">
                        <div class="student-info-label">Grade & Section</div>
                        <div class="student-info-value" id="studentGrade">-</div>
                    </div>
                </div>
                <div class="student-info-row">
                    <div class="student-info-item">
                        <div class="student-info-label">Age</div>
                        <div class="student-info-value" id="studentAge">-</div>
                    </div>
                    <div class="student-info-item">
                        <div class="student-info-label">Gender</div>
                        <div class="student-info-value" id="studentGender">-</div>
                    </div>
                </div>
            </div>

            <div class="records-section">
                <div class="records-title">Records</div>
                <div id="recordsList" class="loading">Loading records...</div>
            </div>
        </div>
    </div>

    <script>
        let userId = null;

        // Get user_id from URL parameter
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            userId = urlParams.get('user_id');
            
            if (userId) {
                loadStudentInfo();
                loadAnecdotalRecords();
            } else {
                document.getElementById('recordsList').innerHTML = '<div class="no-records">No user ID provided</div>';
            }
        });

        // Load student information
        function loadStudentInfo() {
            fetch(`../process/api.php?action=get_student_info&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.student) {
                        const student = data.student;
                        document.getElementById('studentName').textContent = `${student.first_name} ${student.middle_name} ${student.last_name}`;
                        document.getElementById('studentGrade').textContent = student.grade_section;
                        document.getElementById('studentAge').textContent = student.age;
                        document.getElementById('studentGender').textContent = student.gender;
                        document.getElementById('studentInfo').style.display = 'block';
                    }
                })
                .catch(error => console.error('Error loading student info:', error));
        }

        // Load anecdotal records
        function loadAnecdotalRecords() {
            fetch(`../process/api.php?action=get_records&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    const recordsList = document.getElementById('recordsList');
                    recordsList.innerHTML = '';
                    
                    if (data.records && data.records.length > 0) {
                        data.records.forEach(record => {
                            const div = document.createElement('div');
                            div.className = 'record-item';
                            
                            const dateDiv = document.createElement('div');
                            dateDiv.className = 'record-date';
                            const recordDate = new Date(record.created_at);
                            const staffName = record.first_name && record.last_name ? `${record.first_name} ${record.last_name}` : 'Unknown';
                            dateDiv.textContent = `Recorded on ${recordDate.toLocaleDateString()} at ${recordDate.toLocaleTimeString()} by ${staffName}`;
                            
                            const textDiv = document.createElement('div');
                            textDiv.className = 'record-text';
                            textDiv.textContent = record.record_text;
                            
                            div.appendChild(dateDiv);
                            div.appendChild(textDiv);
                            recordsList.appendChild(div);
                        });
                    } else {
                        recordsList.innerHTML = '<div class="no-records">No anecdotal records found for this student</div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading records:', error);
                    document.getElementById('recordsList').innerHTML = '<div class="no-records">Error loading records</div>';
                });
        }
    </script>
</body>
</html>
