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

if (!$action) {
    die(json_encode(['error' => 'No action specified']));
}

// Get all students
if ($action === 'get_all_students') {
    $result = $conn->query("SELECT user_id, first_name, middle_name, last_name FROM user_info ORDER BY first_name ASC");
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    echo json_encode(['students' => $students]);
    exit;
}

// Get single student info
if ($action === 'get_student_info' && $user_id) {
    $user_id = intval($user_id);
    // Verify student belongs to logged-in account
    $result = $conn->query("SELECT * FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
    $student = $result->fetch_assoc();
    echo json_encode(['student' => $student]);
    exit;
}

// Get Anecdotal Records
if ($action === 'get_records' && $user_id) {
    $user_id = intval($user_id);
    // Verify student belongs to logged-in account before returning records
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
    $result = $conn->query("SELECT record_id, record_text, created_at FROM anecdotal_records WHERE user_id = $user_id ORDER BY created_at DESC");
    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    echo json_encode(['records' => $records]);
}

// Save Anecdotal Record
elseif ($action === 'save_record' && $user_id) {
    $user_id = intval($user_id);
    // Verify student belongs to logged-in account
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
    
    $record_text = $conn->real_escape_string($_POST['record_text'] ?? '');
    
    if (empty($record_text)) {
        echo json_encode(['error' => 'Record text cannot be empty']);
        exit;
    }
    
    $sql = "INSERT INTO anecdotal_records (user_id, record_text) VALUES ($user_id, '$record_text')";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Record saved']);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Get Behavioral Notes
elseif ($action === 'get_behavioral_notes' && $user_id) {
    $user_id = intval($user_id);
    // Verify student belongs to logged-in account
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
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
    // Verify student belongs to logged-in account
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
    
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

// Get Medications
elseif ($action === 'get_medications' && $user_id) {
    $user_id = intval($user_id);
    // Verify student belongs to logged-in account
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
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
    // Verify student belongs to logged-in account
    $verify = $conn->query("SELECT user_id FROM user_info WHERE user_id = $user_id AND account_id = $account_id");
    if ($verify->num_rows === 0) {
        echo json_encode(['error' => 'Unauthorized: This patient does not belong to your account']);
        exit;
    }
    
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

$conn->close();
?>
