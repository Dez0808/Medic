<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Information & Records</title>
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

    main {
      margin-left: 100px;

    }

    .container {
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .info {
      width: 30rem;
      height: fit-content;
      min-height: 525px;
      background-color: white;
      border-radius: 8px;
      box-shadow: var(--shadow);
    }

    .info-label {
      text-align: center;
      font-weight: bolder;
      background: var(--gradient-color);
      height: 50px;
      color: white;
      padding-top: 10px;
      border-radius: 14px 14px 0px 0px;
    }

    .student-selector {
      padding: 10px;
      margin: 10px;
      border-radius: 8px;
      background-color: white;
      box-shadow: var(--shadow);


    }

    .student-search-container {
      position: relative;
      max-width: 100%;
    }

    .student-search-input {
      padding: 8px;
      background-color: var(--input-color);
      border: 1px solid #999;
      border-radius: 4px;
      font-size: 14px;
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
      border-radius: 0 0 4px 4px;
      max-height: 200px;
      overflow-y: auto;
      display: none;
      z-index: 100;
      text-transform: uppercase;

    }

    .search-result-item {
      padding: 8px 10px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    }

    .search-result-item:hover {
      background-color: #f0f0f0;
    }

    .search-result-item:last-child {
      border-bottom: none;
    }

    .container-grid {
      display: grid;
      grid-template-rows: repeat(4, 1fr);
      grid-template-columns: repeat(5, 1fr);
      gap: 0;
      width: 50%;
      height: 100%;
    }

    .info-container {
      padding: 10px;
    }

    .input-group {
      width: 100%;
      margin-bottom: 15px;
      padding: 5px 5px;
      border-radius: 8px;
      background-color: var(--input-color);
      box-shadow: var(--shadow);
      border: none;
    }

    #medical-history {
      field-sizing: content;
      width: 100%;
      overflow-y: auto;
      word-break: break-all;
      border-radius: 8px;
      word-wrap: break-word;
      padding: 3px 5px;
      background-color: var(--input-color);
      border: none;
      box-shadow: var(--shadow);
      height: 30px;
      scrollbar-width: none;
    }

    .content-label {
      margin-right: 10px;
      font-size: 14px;
    }

    #div1 {
      grid-area: 1 / 1 / 3 / 5;
      width: 600px;
      margin-left: 20px;
      margin-bottom: 20px;
      padding: 10px;
      text-align: justify;
      box-shadow: var(--shadow);
      border-radius: 8px;
    }

    #div2 {
      grid-area: 3 / 1 / 5 / 3;
      padding: 10px;
      margin-left: 20px;
      margin-right: 35px;
      width: 282px;
      height: 224px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: var(--shadow);
      border-radius: 8px;
    }

    #div3 {
      grid-area: 3 / 3 / 5 / 5;
      padding: 10px;
      width: 282px;
      height: 224px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: var(--shadow);
      border-radius: 8px;
    }

    .input-form {
      height: 150px;
      word-break: break-all;
      width: 100%;
      word-wrap: break-word;
      background-color: var(--input-color);
      border-radius: 8px;
      padding: 8px;
      box-shadow: var(--shadow);
      border: none;


    }

    .form-label {
      font-weight: bold;
      margin-bottom: 10px;
    }

    /* Todo List Styles */
    .todo-title {
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .todo-container {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .todo-input-group {
      display: flex;
      gap: 5px;
      margin-bottom: 8px;
    }

    .todo-input-group input {
      flex: 1;
      padding: 4px;
      border: 1px solid #999;
      border-radius: 4px;
      font-size: 12px;
      background-color: var(--input-color);
    }

    .todo-list {
      flex: 1;
      overflow-y: auto;
      list-style: none;
      padding: 5px;
      background-color: #fafafa;
      border-radius: 4px;
    }

    .todo-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px;
      background-color: white;
      margin-bottom: 4px;
      border-radius: 3px;
      font-size: 12px;
    }

    .todo-item:hover {
      background-color: #f0f0f0;
    }

    .todo-text {
      flex: 1;
      word-break: break-word;
    }

    .todo-item input[type="checkbox"] {
      margin-right: 6px;
      cursor: pointer;
    }

    .todo-item.completed .todo-text {
      text-decoration: line-through;
      color: #999;
    }

    .todo-delete {
      background-color: #f44336;
      color: white;
      border: none;
      padding: 2px 6px;
      border-radius: 3px;
      cursor: pointer;
      font-size: 11px;
      margin-left: 5px;
    }

    .todo-delete:hover {
      background-color: #da190b;
    }





    #anecdotal::after {
      width: 100%;
    }
  </style>
</head>

<body>
  <?php include "../include/header.php" ?>


  <main>

    <div class="container">
      <div class="info">
        <div class="student-selector">
          <label for="student-search"><strong>Search Student:</strong></label>
          <div class="student-search-container">
            <input type="text" id="student-search" class="student-search-input" placeholder="Type student name...">
            <div class="search-results-dropdown" id="searchResults"></div>
          </div>
        </div>
        <div class="info-container">
          <p class="info-label">STUDENT INFORMATION</p>
          <div class="form-group">
            <label for="name" class="content-label">Name:</label>
            <input type="text" name="name" id="name" class="input-group" readonly>
          </div>
          <div class="form-group">
            <label for="grade" class="content-label">Grade & Section:</label>
            <input type="text" name="grade" id="grade" class="input-group" readonly>
          </div>
          <div class="form-group">
            <label for="age" class="content-label">Age:</label>
            <input type="text" name="age" id="age" class="input-group" readonly>
          </div>
          <div class="form-group">
            <label for="gender" class="content-label">Gender:</label>
            <input type="text" name="gender" id="gender" class="input-group" readonly>
          </div>
          <div class="info-container">
            <p class="info-label">MEDICAL HISTORY</p>
            <textarea name="medical-history" id="medical-history" class="" readonly></textarea>
          </div>
        </div>
      </div>

      <div class="container-grid" id="">

        <div id="div1">
          <form id="anecdotalForm">
            <p class="form-label">Anecdotal Records</p>
            <textarea name="anecdotal-text" id="anecdotal-text" class="input-form" placeholder="Enter anecdotal record..."></textarea>
            <div class="btn">
              <button type="button" class="btn btn-success" onclick="saveAnecdotalRecord()">Save</button>
              <button type="reset" class="btn btn-danger">Clear</button>
            </div>
          </form>
        </div>

        <!-- Behavioral Notes Todo List -->
        <div id="div2">
          <div class="todo-container">
            <p class="todo-title">Behavioral Notes</p>
            <div class="todo-input-group">
              <input type="text" id="behavioralInput" placeholder="Add note...">
              <button type="button" onclick="addBehavioralNote()" class="btn btn-success">Add</button>
            </div>
            <ul class="todo-list" id="behavioralList"></ul>
          </div>
        </div>

        <!-- Medications Todo List -->
        <div id="div3">
          <div class="todo-container">
            <p class="todo-title">Medications</p>
            <div class="todo-input-group">
              <input type="text" id="medicationInput" placeholder="Add medication...">
              <button type="button" onclick="addMedication()" class="btn btn-success">Add</button>
            </div>
            <ul class="todo-list" id="medicationList"></ul>
          </div>
        </div>

      </div>

    </div>
  </main>

  <?php include "../include/footer.php" ?>


  <script>
    let currentUserId = null;
    let allStudents = [];

    // Load students on page load
    document.addEventListener('DOMContentLoaded', () => {
      loadStudents();
      setupSearchListener();
    });

    // Load all students for search
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

    // Setup search listener
    function setupSearchListener() {
      const searchInput = document.getElementById('student-search');
      searchInput.addEventListener('input', (e) => {
        filterStudents(e.target.value);
      });
    }

    // Filter and display students based on search input
    function filterStudents(searchText) {
      const dropdown = document.getElementById('searchResults');
      dropdown.innerHTML = '';

      if (!searchText.trim()) {
        dropdown.style.display = 'none';
        return;
      }

      // Only show dropdown when last name letter is typed (minimum 3 characters)
      if (searchText.trim().length < 3) {
        dropdown.style.display = 'none';
        return;
      }

      const filtered = allStudents.filter(student => {
        const fullName = `${student.first_name} ${student.middle_name} ${student.last_name}`.toLowerCase();
        return fullName.includes(searchText.toLowerCase());
      });

      if (filtered.length === 0) {
        dropdown.style.display = 'none';
        return;
      }

      filtered.forEach(student => {
        const div = document.createElement('div');
        div.className = 'search-result-item';
        div.textContent = `${student.first_name} ${student.middle_name} ${student.last_name}`;
        div.onclick = () => selectStudent(student);
        dropdown.appendChild(div);
      });

      dropdown.style.display = 'block';
    }

    // Select a student from search results
    function selectStudent(student) {
      currentUserId = student.user_id;
      document.getElementById('student-search').value = `${student.first_name} ${student.middle_name} ${student.last_name}`;
      document.getElementById('searchResults').style.display = 'none';
      loadStudentData();
    }

    // Load student data
    function loadStudentData() {
      if (!currentUserId) {
        clearAllFields();
        return;
      }

      // Fetch student info
      fetch(`../process/api.php?action=get_student_info&user_id=${currentUserId}`)
        .then(response => response.json())
        .then(data => {
          if (data.student) {
            const student = data.student;
            document.getElementById('name').value = `${student.first_name} ${student.middle_name} ${student.last_name}`;
            document.getElementById('grade').value = student.grade_section;
            document.getElementById('age').value = student.age;
            document.getElementById('gender').value = student.gender;
            document.getElementById('medical-history').value = student.med_condition;
          }
        })
        .catch(error => console.error('Error:', error));

      // Load behavioral notes
      loadBehavioralNotes();
      // Load medications
      loadMedications();
    }

    // Save anecdotal record
    function saveAnecdotalRecord() {
      const text = document.getElementById('anecdotal-text').value.trim();
      if (!text) {
        alert('Please enter an anecdotal record');
        return;
      }
      if (!currentUserId) {
        alert('Please select a student first');
        return;
      }

      const formData = new FormData();
      formData.append('action', 'save_record');
      formData.append('user_id', currentUserId);
      formData.append('record_text', text);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Record saved successfully');
            document.getElementById('anecdotal-text').value = '';
          } else {
            alert('Error: ' + (data.error || 'Unknown error'));
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Load behavioral notes from database
    function loadBehavioralNotes() {
      if (!currentUserId) return;

      fetch(`../process/api.php?action=get_behavioral_notes&user_id=${currentUserId}`)
        .then(response => response.json())
        .then(data => {
          const list = document.getElementById('behavioralList');
          list.innerHTML = '';
          if (data.notes) {
            data.notes.forEach(note => {
              const li = createTodoItem(note.note_text, 'behavioral', note.note_id, note.is_completed);
              list.appendChild(li);
            });
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Add behavioral note
    function addBehavioralNote() {
      const input = document.getElementById('behavioralInput');
      const text = input.value.trim();

      if (!text) {
        alert('Please enter a behavioral note');
        return;
      }
      if (!currentUserId) {
        alert('Please select a student first');
        return;
      }

      const formData = new FormData();
      formData.append('action', 'add_behavioral_note');
      formData.append('user_id', currentUserId);
      formData.append('note_text', text);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadBehavioralNotes();
            input.value = '';
            input.focus();
          } else {
            alert('Error: ' + (data.error || 'Unknown error'));
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete behavioral note
    function deleteBehavioralNote(noteId) {
      if (!confirm('Are you sure you want to delete this note?')) return;

      const formData = new FormData();
      formData.append('action', 'delete_behavioral_note');
      formData.append('note_id', noteId);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadBehavioralNotes();
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Toggle behavioral note
    function toggleBehavioralNote(checkbox, noteId) {
      const formData = new FormData();
      formData.append('action', 'toggle_behavioral_note');
      formData.append('note_id', noteId);
      formData.append('is_completed', checkbox.checked ? 1 : 0);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            checkbox.closest('.todo-item').classList.toggle('completed');
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Load medications from database
    function loadMedications() {
      if (!currentUserId) return;

      fetch(`../process/api.php?action=get_medications&user_id=${currentUserId}`)
        .then(response => response.json())
        .then(data => {
          const list = document.getElementById('medicationList');
          list.innerHTML = '';
          if (data.medications) {
            data.medications.forEach(med => {
              const li = createTodoItem(med.medication_name, 'medication', med.medication_id, med.is_completed);
              list.appendChild(li);
            });
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Add medication
    function addMedication() {
      const input = document.getElementById('medicationInput');
      const text = input.value.trim();

      if (!text) {
        alert('Please enter a medication');
        return;
      }
      if (!currentUserId) {
        alert('Please select a student first');
        return;
      }

      const formData = new FormData();
      formData.append('action', 'add_medication');
      formData.append('user_id', currentUserId);
      formData.append('medication_name', text);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadMedications();
            input.value = '';
            input.focus();
          } else {
            alert('Error: ' + (data.error || 'Unknown error'));
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete medication
    function deleteMedication(medicationId) {
      if (!confirm('Are you sure you want to delete this medication?')) return;

      const formData = new FormData();
      formData.append('action', 'delete_medication');
      formData.append('medication_id', medicationId);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadMedications();
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Toggle medication
    function toggleMedication(checkbox, medicationId) {
      const formData = new FormData();
      formData.append('action', 'toggle_medication');
      formData.append('medication_id', medicationId);
      formData.append('is_completed', checkbox.checked ? 1 : 0);

      fetch('../process/api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            checkbox.closest('.todo-item').classList.toggle('completed');
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Create todo item (without checkbox)
    function createTodoItem(text, type, id, isCompleted) {
      const li = document.createElement('li');
      li.className = 'todo-item';

      const span = document.createElement('span');
      span.className = 'todo-text';
      span.textContent = text;

      const deleteBtn = document.createElement('button');
      deleteBtn.type = 'button';
      deleteBtn.className = 'todo-delete';
      deleteBtn.textContent = 'Delete';

      li.appendChild(span);
      li.appendChild(deleteBtn);

      if (type === 'behavioral') {
        deleteBtn.onclick = () => deleteBehavioralNote(id);
      } else if (type === 'medication') {
        deleteBtn.onclick = () => deleteMedication(id);
      }

      return li;
    }

    // Modal functions


    // Allow Enter key to add items
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('behavioralInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') addBehavioralNote();
      });

      document.getElementById('medicationInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') addMedication();
      });
    });

    // Clear all fields
    function clearAllFields() {
      document.getElementById('name').value = '';
      document.getElementById('grade').value = '';
      document.getElementById('age').value = '';
      document.getElementById('gender').value = '';
      document.getElementById('medical-history').value = '';
      document.getElementById('anecdotal-text').value = '';
      document.getElementById('behavioralList').innerHTML = '';
      document.getElementById('medicationList').innerHTML = '';
      currentUserId = null;
    }
  </script>
</body>

</html>