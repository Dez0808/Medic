<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Entrance Monitoring System</title>
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f5f5;
      color: #333;
      line-height: 1.6;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .logo img {
      width: 70px;
      height: 70px;
      justify-content: center;
      align-items: center;
      margin-right: 15px;
      color: white;
    }

    /* Main container */
    .container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      overflow-x: hidden;
      height: 78vh;
      width: 40vw;
      position: relative;
    }

    /* Header with toggle */
    .header {
      background: #1b5e20;
      /* Dark green */
      color: white;
      padding: 20px;
      text-align: center;
      position: relative;
    }

    .header h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .toggle-buttons {
      display: flex;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 25px;
      overflow: hidden;
      margin: 0 20px;
    }

    .toggle-btn {
      flex: 1;
      padding: 10px 20px;
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .toggle-btn a {
      text-decoration: none;
      color: white;
      padding: 50px;

    }

    .toggle-btn.active {
      background: rgba(255, 255, 255, 0.2);
    }

    .toggle-btn:hover {
      background: rgba(255, 255, 255, 0.15);
    }

    /* Forms */
    .form-container {
      padding: 30px 20px 5px 20px;
    }

    .form-container.active {
      display: block;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #1b5e20;
      /* Dark green */
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s ease;
    }

    input:focus {
      outline: none;
      border-color: #1b5e20;
      /* Dark green */
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background: #1b5e20;
      /* Dark green */
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      margin-top: 10px;
    }

    .submit-btn:hover {
      background: #145a32;
      /* Slightly lighter dark green */
    }

    .submit-btn:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    /* Error messages */
    .error {
      color: #d32f2f;
      font-size: 14px;
      margin-top: 5px;
      display: none;
    }

    /* Link to toggle form */
    .toggle-link {
      text-align: center;
      margin-top: 20px;
      color: #1b5e20;
    }

    .toggle-link a {
      color: #1b5e20;
      text-decoration: none;
      font-weight: 600;
    }

    .toggle-link a:hover {
      text-decoration: underline;
    }

    .toggle {
      text-decoration: none;
      color: white;
      padding: 10px 110px;
    }

    #employee-login {
      display: none;
    }

    .reg {
      margin-top: 20px;
    }

    #reg-msg {
      text-align: center;

    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="logo">
        <img src="Logos/Lagro_High_School_logo.png" alt="" />
      </div>
      <h1>Lagro High School</h1>
      <div class="toggle-buttons">
        <button class="toggle-btn active" id="btn1" onclick="switch1()">Student</button>
        <button class="toggle-btn" id="btn2" onclick="switch2()">Employee</button>
      </div>
    </div>


    <div id="login-form" class="form-container">
      <!-- Student Login Form -->
      <form id="loginForm">
        <div id="student-login">
          <div class="form-group">
            <label for="studentLoginLRN">Learner's Reference Number (LRN)</label>
            <input type="text" id="studentLoginLRN" required />
            <div class="error" id="studentLoginLRN-Error"></div>
          </div>
          <div class="form-group">
            <label for="studentLoginPword">Password</label>
            <input type="password" id="studentLoginPword" required />
            <div class="error" id="studentLoginPword-Error"></div>
          </div>
          <button type="submit" class="submit-btn" id="studentLogin-submit">Login</button>
          <div class="reg">
            <p id="reg-msg">Don't have an account? <a href="register.php">Register</a></p>
          </div>
        </div>

        <!-- Employee Login Form -->
        <div id="employee-login">
          <div class="form-group">
            <label for="employeeLoginID">Employee ID</label>
            <input type="text" id="employeeLoginID" required />
            <div class="error" id="employeeLoginID-Error"></div>
          </div>
          <div class="form-group">
            <label for="employeeLoginPword">Password</label>
            <input type="password" id="employeeLoginPword" required />
            <div class="error" id="employeeLoginPword-Error"></div>
          </div>
          <button type="submit" class="submit-btn" id="employeeLogin-submit">Login</button>
          <div class="reg">
            <p id="reg-msg">Don't have an account? <a href="register.php">Register</a></p>
          </div>
        </div>
      </form>
      <div class="toggle-link">
      </div>
    </div>

    <script>
      function switch1() {
        document.getElementById("student-login").style.display = "block";
        document.getElementById("btn1").classList.add("active");
        document.getElementById("employee-login").style.display = "none";
        document.getElementById("btn2").classList.remove("active");

      }

      function switch2() {
        document.getElementById("student-login").style.display = "none";
        document.getElementById("btn1").classList.remove("active");
        document.getElementById("employee-login").style.display = "block";
        document.getElementById("btn2").classList.add("active");
      }
    </script>
</body>

</html>