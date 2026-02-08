<?php
session_start();

// Database configuration
$host = 'localhost';
$db = 'lhs_clinic';
$user = 'root';
$password = '';

try {
    $conn = new mysqli($host, $user, $password, $db);
    if ($conn->connect_error) {
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }
} catch (Exception $e) {
    die(json_encode(['error' => $e->getMessage()]));
}

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['account_id'])) {
    die(json_encode(['error' => 'Unauthorized: Please log in']));
}

$account_id = $_SESSION['account_id'];
$action = $_GET['action'] ?? $_POST['action'] ?? null;
$user_id = $_GET['user_id'] ?? $_POST['user_id'] ?? null;
$source = $_GET['source'] ?? $_POST['source'] ?? 'studentlist'; // Default to 'studentlist', can be 'anecdotal'

if (!$action) {
    die(json_encode(['error' => 'No action specified']));
}

// Check user role
if ($action === 'check_role') {
    $roleCheck = $conn->query("SELECT role FROM registered_accounts WHERE account_id = $account_id");
    if ($roleCheck->num_rows === 0) {
        echo json_encode(['role' => 'teacher']);
        exit;
    }
    $roleRow = $roleCheck->fetch_assoc();
    echo json_encode(['role' => $roleRow['role'] ?? 'teacher']);
    exit;
}

// Get all students (for anecdotal page search - no account restriction)
if ($action === 'get_all_students') {
    $result = $conn->query("SELECT user_id, first_name, middle_name, last_name FROM user_info ORDER BY first_name ASC");
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    echo json_encode(['students' => $students]);
    exit;
}

// Get single student info (for anecdotal page - allows viewing any student)
if ($action === 'get_student_info' && $user_id) {
    $user_id = intval($user_id);
    // In anecdotal page, allow viewing any student's basic info
    $result = $conn->query("SELECT * FROM user_info WHERE user_id = $user_id");
    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Student not found']);
        exit;
    }
    $student = $result->fetch_assoc();
    echo json_encode(['student' => $student]);
    exit;
}

// Get Anecdotal Records (allow viewing all records for any student)
if ($action === 'get_records' && $user_id) {
    $user_id = intval($user_id);
    // Allow viewing all anecdotal records for any student (no account restriction)
    $result = $conn->query("SELECT ar.record_id, ar.record_text, ar.created_at, ra.first_name, ra.last_name FROM anecdotal_records ar LEFT JOIN registered_accounts ra ON ar.account_id = ra.account_id WHERE ar.user_id = $user_id ORDER BY ar.created_at DESC");
    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    echo json_encode(['records' => $records]);
    exit;
}

// Save Anecdotal Record
elseif ($action === 'save_record' && $user_id) {
    $user_id = intval($user_id);
    
    // If from studentlist page, verify student belongs to logged-in account
    if ($source === 'studentlist') {
        $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
        if ($verify->num_rows === 0) {
            echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
            exit;
        }
    }
    // If from anecdotal page, allow any student (source === 'anecdotal')
    
    // Check user role - only teachers and admins can add anecdotal records
    $roleCheck = $conn->query("SELECT role FROM registered_accounts WHERE account_id = $account_id");
    if ($roleCheck->num_rows === 0) {
        echo json_encode(['error' => 'User role not found']);
        exit;
    }
    
    $roleRow = $roleCheck->fetch_assoc();
    $userRole = $roleRow['role'];
    
    if ($userRole === 'doctor') {
        echo json_encode(['error' => 'Doctors do not have permission to add anecdotal records']);
        exit;
    }
    
    $record_text = $conn->real_escape_string($_POST['record_text'] ?? '');
    
    if (empty($record_text)) {
        echo json_encode(['error' => 'Record text cannot be empty']);
        exit;
    }
    
    $sql = "INSERT INTO anecdotal_records (user_id, record_text, account_id) VALUES ($user_id, '$record_text', $account_id)";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Record saved']);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
    exit;
}

// Get Behavioral Notes (allow viewing for any student)
elseif ($action === 'get_behavioral_notes' && $user_id) {
    $user_id = intval($user_id);
    // Allow viewing behavioral notes for any student (no account restriction)
    $result = $conn->query("SELECT note_id, note_text, is_completed FROM behavioral_notes WHERE user_id = $user_id ORDER BY created_at DESC");
    $notes = [];
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    echo json_encode(['notes' => $notes]);
}

// Add Behavioral Note
elseif ($action === 'add_behavioral_note' && $user_id) {
    $user_id = intval($user_id);
    
    // If from studentlist page, verify student belongs to logged-in account
    if ($source === 'studentlist') {
        $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
        if ($verify->num_rows === 0) {
            echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
            exit;
        }
    }
    // If from anecdotal page, allow any student (source === 'anecdotal')
    
    $note_text = $conn->real_escape_string($_POST['note_text'] ?? '');
    
    if (empty($note_text)) {
        echo json_encode(['error' => 'Note cannot be empty']);
        exit;
    }
    
    $sql = "INSERT INTO behavioral_notes (user_id, note_text) VALUES ($user_id, '$note_text')";
    if ($conn->query($sql)) {
        $note_id = $conn->insert_id;
        echo json_encode(['success' => true, 'note_id' => $note_id, 'note_text' => $note_text]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Toggle Behavioral Note
elseif ($action === 'toggle_behavioral_note') {
    $note_id = intval($_POST['note_id'] ?? 0);
    $is_completed = intval($_POST['is_completed'] ?? 0);
    
    $sql = "UPDATE behavioral_notes SET is_completed = $is_completed WHERE note_id = $note_id";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Delete Behavioral Note
elseif ($action === 'delete_behavioral_note') {
    $note_id = intval($_POST['note_id'] ?? 0);
    
    $sql = "DELETE FROM behavioral_notes WHERE note_id = $note_id";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Get Medications (allow viewing for any student)
elseif ($action === 'get_medications' && $user_id) {
    $user_id = intval($user_id);
    // Allow viewing medications for any student (no account restriction)
    $result = $conn->query("SELECT medication_id, medication_name, is_completed FROM medications WHERE user_id = $user_id ORDER BY created_at DESC");
    $medications = [];
    while ($row = $result->fetch_assoc()) {
        $medications[] = $row;
    }
    echo json_encode(['medications' => $medications]);
}

// Add Medication
elseif ($action === 'add_medication' && $user_id) {
    $user_id = intval($user_id);
    
    // If from studentlist page, verify student belongs to logged-in account
    if ($source === 'studentlist') {
        $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
        if ($verify->num_rows === 0) {
            echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
            exit;
        }
    }
    // If from anecdotal page, allow any student (source === 'anecdotal')
    
    $medication_name = $conn->real_escape_string($_POST['medication_name'] ?? '');
    
    if (empty($medication_name)) {
        echo json_encode(['error' => 'Medication cannot be empty']);
        exit;
    }
    
    $sql = "INSERT INTO medications (user_id, medication_name) VALUES ($user_id, '$medication_name')";
    if ($conn->query($sql)) {
        $medication_id = $conn->insert_id;
        echo json_encode(['success' => true, 'medication_id' => $medication_id, 'medication_name' => $medication_name]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Toggle Medication
elseif ($action === 'toggle_medication') {
    $medication_id = intval($_POST['medication_id'] ?? 0);
    $is_completed = intval($_POST['is_completed'] ?? 0);
    
    $sql = "UPDATE medications SET is_completed = $is_completed WHERE medication_id = $medication_id";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Delete Medication
elseif ($action === 'delete_medication') {
    $medication_id = intval($_POST['medication_id'] ?? 0);
    
    $sql = "DELETE FROM medications WHERE medication_id = $medication_id";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Search Students
elseif ($action === 'search_students') {
    $search = $conn->real_escape_string($_GET['search'] ?? '');
    $grade = $conn->real_escape_string($_GET['grade'] ?? '');
    $section = $conn->real_escape_string($_GET['section'] ?? '');
    $gender = $conn->real_escape_string($_GET['gender'] ?? '');
    
    $where = "WHERE account_id = $account_id";
    
    if (!empty($search)) {
        $where .= " AND (first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%')";
    }
    
    if (!empty($grade)) {
        $where .= " AND grade_section LIKE '$grade%'";
    }
    
    if (!empty($section)) {
        $where .= " AND grade_section LIKE '%$section'";
    }
    
    if (!empty($gender)) {
        $where .= " AND gender = '$gender'";
    }
    
    $result = $conn->query("SELECT user_id, first_name, middle_name, last_name, grade_section, age, gender, picture FROM user_info $where ORDER BY first_name ASC");
    $students = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    
    echo json_encode(['students' => $students]);
    exit;
}

// Get Grades and Sections
elseif ($action === 'get_grades_sections') {
    $result = $conn->query("SELECT DISTINCT grade_section FROM user_info WHERE account_id = $account_id ORDER BY grade_section ASC");
    $grades = [];
    $sections = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $gradeSection = $row['grade_section'];
            $parts = explode(' - ', $gradeSection);
            $grade = trim($parts[0] ?? '');
            $section = trim($parts[1] ?? '');
            
            if (!empty($grade) && !in_array($grade, $grades)) {
                $grades[] = $grade;
            }
            
            if (!empty($section) && !in_array($section, $sections)) {
                $sections[] = $section;
            }
        }
    }
    
    echo json_encode(['grades' => $grades, 'sections' => $sections]);
    exit;
}

// Update Student
elseif ($action === 'update_student' && $user_id) {
    $user_id = intval($user_id);
    
    // Verify student belongs to logged-in account
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This student does not belong to your account']);
        exit;
    }
    
    // Get POST data
    $first_name = $conn->real_escape_string($_POST['first_name'] ?? '');
    $middle_name = $conn->real_escape_string($_POST['middle_name'] ?? '');
    $last_name = $conn->real_escape_string($_POST['last_name'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = $conn->real_escape_string($_POST['gender'] ?? '');
    $grade = $conn->real_escape_string($_POST['grade'] ?? '');
    $section = $conn->real_escape_string($_POST['section'] ?? '');
    $contact_number = $conn->real_escape_string($_POST['contact_number'] ?? '');
    $address = $conn->real_escape_string($_POST['address'] ?? '');
    
    // Combine grade and section
    $grade_section = "$grade - $section";
    
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email)) {
        echo json_encode(['error' => 'First name, last name, and email are required']);
        exit;
    }
    
    // Update query
    $sql = "UPDATE user_info SET 
            first_name = '$first_name',
            middle_name = '$middle_name',
            last_name = '$last_name',
            email = '$email',
            age = $age,
            gender = '$gender',
            grade_section = '$grade_section',
            contact = '$contact_number',
            address = '$address'
            WHERE user_id = $user_id AND account_id = $account_id";
    
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Student updated successfully']);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
    exit;
}

$conn->close();
?>
