<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_report'])) {
    include 'include/db.php';

    $topic = isset($_POST['topic']) ? $_POST['topic'] : 'unknown';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';

    $sql = "INSERT INTO `report` (topic, message, contact, added) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sss", $topic, $message, $contact);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/bootstrap.bundle.min.js" />
    <link rel="icon" type="image/x-icon" href="Pics/Logos/Lagro_High_School_logo.png">
    <title>Help Page | LHS AI Chat Bot</title>
</head>
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

    .container-fluid {
        padding: 0;
        width: 100%;
        max-width: 700px;
        margin: 50px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .chat-container {
        display: flex;
        flex-direction: column;
        height: 600px;
    }

    .chat-header {
        background: rgb(10, 89, 52);
        color: #fff;
        padding: 15px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .chat-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message {
        display: flex;
        margin-bottom: 10px;
    }

    .user-message {
        justify-content: flex-end;
    }

    .user-message-text {
        background-color: rgb(25, 135, 84);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .bot-message {
        justify-content: flex-start;
    }

    .bot-message-text {
        background-color: #e9ecef;
        color: #333;
        padding: 10px 15px;
        border-radius: 5px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .bot-message-text p {
        margin: 0;
    }

    .action-button {
        display: inline-block;
        background-color: #ff6b6b;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        margin-top: 10px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }

    .action-button:hover {
        background-color: #ff5252;
    }

    .chat-input-area {
        padding: 15px;
        border-top: 1px solid #ddd;
        display: flex;
        gap: 10px;
    }

    .chat-input-area input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .modal-title {
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .modal-body {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .alert {
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="chat-container">
            <div class="chat-header">
                <h4>LHS AI Chat Bot</h4>
            </div>
            <div class="chat-body" id="chatMessages">
                <div class="message bot-message">
                    <div class="bot-message-text">
                        <p>Welcome to the LHS AI Chat Bot! I'm here to help you with any concerns. How can I assist you today?</p>
                    </div>
                </div>
            </div>
            <div class="chat-input-area">
                <input type="text" id="userMessageInput" placeholder="Type your message here..." />
                <button onclick="sendMessage()" class="btn btn-success">Send</button>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="modal" id="supportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit a Report</h5>
                <button type="button" class="btn-close" onclick="closeModal()"></button>
            </div>
            <form id="reportForm" onsubmit="submitReport(event)">
                <div class="modal-body">
                    <div>
                        <label class="form-label">Topic of Problem</label>
                        <select class="form-control" id="problemTopic" required>
                            <option value="">-- Select a topic --</option>
                            <option value="bullying">Bullying</option>
                            <option value="harassment">Harassment</option>
                            <option value="physical_harm">Physical Harm</option>
                            <option value="emotional_distress">Emotional Distress</option>
                            <option value="abuse">Abuse</option>
                            <option value="discrimination">Discrimination</option>
                            <option value="loneliness">Loneliness/Isolation</option>
                            <option value="academic stress">Academic Stress</option>
                            <option value="family issues">Family Issues</option>
                            <option value="mental health">Mental Health Concerns</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div style="margin-top: 15px;">
                        <label class="form-label">Describe Your Problem</label>
                        <textarea class="form-control" id="problemMessage" rows="5" placeholder="Please provide details about your concern..." required></textarea>
                    </div>
                    <div style="margin-top: 15px;">
                        <label class="form-label">Contact Information (Optional)</label>
                        <input type="text" class="form-control" id="contactInfo" placeholder="Email or phone number for follow-up" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit Report</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const keywordTriggers = {
    homework: {
        keywords: ['homework', 'assignment', 'project', 'due date', 'submit', 'late work'],
        responses: [
            "Need help with homework? I can guide you through it step by step.",
            "If you're unsure about an assignment, try checking your class portal or asking your teacher for clarification.",
            "Managing homework can be easier with a schedule. Would you like help organizing your tasks?"
        ]
    },

    exams: {
        keywords: ['exam', 'test', 'quiz', 'midterm', 'final', 'study'],
        responses: [
            "Preparing for an exam? I can help you create a study plan.",
            "Reviewing notes and practicing sample questions can boost your confidence.",
            "Would you like tips on how to study more effectively?"
        ]
    },

    grades: {
        keywords: ['grade', 'grades', 'report card', 'marks', 'gpa', 'score'],
        responses: [
            "If you're concerned about your grades, talking to your teacher is a great first step.",
            "Improving grades takes time and effort. I can help you make a plan.",
            "Would you like tips on how to raise your GPA?"
        ]
    },

    attendance: {
        keywords: ['absent', 'attendance', 'missed class', 'sick day', 'late to school'],
        responses: [
            "If you missed a class, check with your teacher about make-up work.",
            "Good attendance helps you stay on track. Let me know if you need help catching up.",
            "Would you like guidance on writing an absence excuse note?"
        ]
    },

    schedule: {
        keywords: ['schedule', 'timetable', 'class time', 'period', 'room number'],
        responses: [
            "You can find your class schedule in the student portal.",
            "Need help organizing your timetable? I can help you plan your day.",
            "If you're unsure about a room number or class time, check with the front office."
        ]
    },

    clubs: {
        keywords: ['club', 'sports', 'activity', 'extracurricular', 'team'],
        responses: [
            "Joining a club is a great way to meet new people and build skills.",
            "You can check the school website for a list of extracurricular activities.",
            "Would you like help choosing a club that matches your interests?"
        ]
    },

    cafeteria: {
        keywords: ['lunch', 'cafeteria', 'menu', 'food', 'meal'],
        responses: [
            "You can check the weekly lunch menu on the school website.",
            "If you have dietary concerns, the cafeteria staff can assist you.",
            "Would you like information about lunch schedules?"
        ]
    },

    library: {
        keywords: ['library', 'book', 'borrow', 'return', 'study hall'],
        responses: [
            "The library is a great place to study or find research materials.",
            "Make sure to return borrowed books by the due date to avoid fines.",
            "Need help finding a book or research source?"
        ]
    },

    transportation: {
        keywords: ['bus', 'transport', 'ride', 'pickup', 'drop off'],
        responses: [
            "Bus schedules are available through the school transportation office.",
            "If your bus is late, contact the school office for updates.",
            "Would you like help finding transportation information?"
        ]
    },

    counseling: {
        keywords: ['counselor', 'guidance', 'career advice', 'college', 'scholarship'],
        responses: [
            "School counselors can help with academic and career planning.",
            "If you're thinking about college or scholarships, I can provide guidance.",
            "Would you like information about booking a counseling appointment?"
        ]
    }
}

        ;

        function checkForKeywords(message) {
            const lowerMessage = message.toLowerCase();

            for (const category in keywordTriggers) {
                const trigger = keywordTriggers[category];
                for (const keyword of trigger.keywords) {
                    if (lowerMessage.includes(keyword)) {
                        return {
                            category,
                            trigger
                        };
                    }
                }
            }
            return null;
        }

        function getRandomResponse(responses) {
            return responses[Math.floor(Math.random() * responses.length)];
        }

        function displayMessage(text, isUser = false) {
            const chatMessages = document.getElementById('chatMessages');
            const message = document.createElement('div');
            message.className = `message ${isUser ? 'user-message' : 'bot-message'}`;

            if (isUser) {
                message.innerHTML = `<div class="user-message-text">${escapeHtml(text)}</div>`;
            } else {
                message.innerHTML = `<div class="bot-message-text"><p>${escapeHtml(text)}</p></div>`;
            }

            chatMessages.appendChild(message);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function displayMessageWithButton(text, buttonLabel = 'Get Support') {
            const chatMessages = document.getElementById('chatMessages');
            const message = document.createElement('div');
            message.className = 'message bot-message';
            message.innerHTML = `
                <div class="bot-message-text">
                    <p>${escapeHtml(text)}</p>
                </div>
            `;

            chatMessages.appendChild(message);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        // Main function to send user message
        function sendMessage() {
            const input = document.getElementById('userMessageInput');
            const message = input.value.trim();

            if (message === '') return;

            // Display user message
            displayMessage(message, true);
            input.value = '';

            // Check for keywords
            const triggerResult = checkForKeywords(message);

            if (triggerResult) {
                // Keyword detected - send special response with button
                const response = getRandomResponse(triggerResult.trigger.responses);
                displayMessageWithButton(response, 'Get Support');
            } else {
                // No keywords - send general response
                const generalResponses = [
                    "Thank you for sharing that with me. How else can I help you today?",
                    "I understand. Is there anything specific you'd like to discuss?",
                    "Thank you for reaching out. What else is on your mind?",
                    "I'm here to listen. Tell me more about what you need.",
                    "That's good to know. How are you feeling overall?",
                    "I appreciate you talking to me. Feel free to share anything on your mind.",
                    "Thanks for letting me know. Is there anything else I can help with?",
                    "I'm glad you're here. What would you like to talk about next?",
                    "That's helpful to know. Keep sharing - I'm here to support you.",
                    "Thank you for your trust. What else can I help you with today?"
                ];
                const response = getRandomResponse(generalResponses);
                displayMessage(response);
            }
        }

        // Function to open modal
        function openModal() {
            document.getElementById('supportModal').classList.add('active');
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('supportModal').classList.remove('active');
        }

        // Function to submit report form
        function submitReport(event) {
            event.preventDefault();

            const topic = document.getElementById('problemTopic').value;
            const message = document.getElementById('problemMessage').value;
            const contact = document.getElementById('contactInfo').value;


            if (topic === '' || message.trim() === '') {
                alert('Please fill in all fields');
                return;
            }

            const formData = new FormData();
            formData.append('topic', topic);
            formData.append('message', message);
            formData.append('contact', contact);
            formData.append('save_report', true);

            fetch('help-page.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Your report has been submitted successfully. A counselor will reach out to you soon.');
                        document.getElementById('reportForm').reset();
                        closeModal();
                    } else {
                        alert('Error submitting report: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error submitting report. Please try again.');
                });
        }

        // Allow sending message with Enter key
        document.getElementById('userMessageInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('supportModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>