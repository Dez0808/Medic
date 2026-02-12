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
            bully: {
                keywords: ['bully', 'bullying', 'bullied', 'bully me', 'being bullied', 'mean kids', 'picking on me'],
                responses: [
                    "I'm sorry to hear that you're experiencing bullying. That's never okay, and you don't have to go through this alone.",
                    "Bullying can be really hurtful. I want you to know that what you're experiencing is not your fault.",
                    "Dealing with a bully can be tough. You deserve to feel safe and respected.",
                    "Being bullied is painful, but help is available. Would you like to report this and get support?"
                ]
            },
            hurt: {
                keywords: ['hurt', 'hurting', 'pain', 'painful', 'injured', 'injury', 'ache', 'sore', 'bleeding'],
                responses: [
                    "I'm concerned to hear that you're hurting. Your well-being is important to us.",
                    "It sounds like you're in pain. Please consider reaching out to a trusted adult or professional.",
                    "I'm here to help. If you're physically hurt, please seek medical attention immediately.",
                    "Your health matters. If you need immediate help, please contact a school nurse or call emergency services."
                ]
            },
            suicide: {
                keywords: ['suicide', 'suicidal', 'kill myself', 'end it', 'don\'t want to live', 'rather be dead', 'wish i was dead', 'no point living'],
                responses: [
                    "I'm really concerned about what you're sharing. Your life matters, and there are people who care about you.",
                    "Thoughts of suicide are serious and treatable. Please reach out to a crisis helpline or trusted adult immediately.",
                    "You're not alone in these feelings, and help is available. Please contact a counselor or crisis service right away.",
                    "Crisis support is available 24/7. Please reach out to the 988 Suicide & Crisis Lifeline - you don't have to face this alone."
                ]
            },
            abuse: {
                keywords: ['abuse', 'abused', 'abusive', 'hitting', 'assault', 'violence', 'beat', 'hit me', 'touched me'],
                responses: [
                    "I'm very concerned about your safety. Abuse is never acceptable, and you deserve protection.",
                    "What you're describing is serious. Please reach out to a trusted adult, counselor, or call the support helpline.",
                    "Your safety is our priority. Please don't hesitate to report this to school administration or authorities.",
                    "You're not alone, and this is not your fault. I'm here to help you get the support you need."
                ]
            },
            lonely: {
                keywords: ['lonely', 'alone', 'isolated', 'no friends', 'feel alone', 'nobody likes me', 'left out', 'excluded'],
                responses: [
                    "Feeling lonely can be really difficult. There are people here who care about you and want to help.",
                    "You're not alone in feeling this way. Many students experience loneliness, and support is available.",
                    "Let's work together to find ways to connect you with others and resources that can help.",
                    "Your feelings are valid. Building connections takes time, but there are people and resources ready to help."
                ]
            },
            harassment: {
                keywords: ['harass', 'harassment', 'harassed', 'sexual harassment', 'unwanted', 'uncomfortable'],
                responses: [
                    "I'm sorry you're experiencing harassment. This is unacceptable, and you don't deserve to be treated this way.",
                    "Harassment of any kind is serious. Your feelings are valid, and you have the right to feel safe.",
                    "This situation is important, and we want to help. Would you like to report what's happening?"
                ]
            },
            discrimination: {
                keywords: ['discrimination', 'discriminated', 'racist', 'homophobic', 'sexist', 'treated unfairly'],
                responses: [
                    "Discrimination is never acceptable. Your identity and who you are matters.",
                    "I'm sorry you're facing discrimination. You deserve to be respected and treated fairly.",
                    "What you're experiencing is wrong. Let's get you the support and help you deserve."
                ]
            },
            stress: {
                keywords: ['stressed', 'stress', 'anxiety', 'anxious', 'worried', 'panic', 'nervous', 'overwhelmed'],
                responses: [
                    "It's okay to feel stressed or anxious. Many people experience this, and there are ways to manage it.",
                    "Your feelings are valid. Talking to someone can really help when things feel overwhelming.",
                    "I'm here to listen. Would you like to share more about what's making you feel this way?"
                ]
            },
            depression: {
                keywords: ['depressed', 'depression', 'sad', 'unhappy', 'down', 'empty', 'hopeless', 'worthless'],
                responses: [
                    "I'm sorry you're feeling this way. Depression is real, but it's also treatable with proper support.",
                    "Your feelings matter, and you deserve help. Please reach out to a counselor or trusted adult.",
                    "What you're experiencing is important. Getting support is a sign of strength, not weakness."
                ]
            },
            selfharm: {
                keywords: ['self harm', 'cutting', 'hurt myself', 'scratch myself', 'harm', 'scars'],
                responses: [
                    "I'm concerned about your safety. Self-harm is a sign that you're struggling, and help is available.",
                    "You deserve support and healthier ways to cope with your pain. Please talk to a counselor.",
                    "What you're doing is a way of processing pain, but there are better options. Let's get you help."
                ]
            },
            substance: {
                keywords: ['drugs', 'alcohol', 'drinking', 'smoking', 'vaping', 'substance', 'high', 'weed'],
                responses: [
                    "I appreciate you sharing this. Substance use concerns are important, and support is available.",
                    "Whether you're struggling with use or worried about someone else, counselors can help.",
                    "Reaching out shows courage. Let's connect you with resources that can truly help."
                ]
            }
        };

        // Function to check if user message contains any trigger keywords
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
                    <button class="action-button" onclick="openModal()">📞 ${buttonLabel}</button>
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