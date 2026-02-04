<?php

include "../include/db.php";

$sql = "SELECT * FROM registered_accounts WHERE account_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["account_id"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />

  <style>
    /* Sidebar container */
    .sidebar {
      position: relative;
      top: 0px;
      height: 100%;
      width: 240px;
      background: rgb(10, 89, 52);
      padding: 16px;
      padding-bottom: 200px;
      color: #e5e7eb;
      transition: width 0.35s ease;
      margin-top: -10px;
    }

    .sidebar.collapsed {
      width: 85px;
    }

    /* Header */
    .sidebar-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 18px;
      margin-left: 2.5px;
    }

    .logo img {
      width: 50px;
    }

    .toggle-btn {
      background: #020617;
      border: none;
      color: white;
      padding: 6px 8px;
      border-radius: 8px;
      cursor: pointer;
    }

    /* Menu */
    .menu {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .menu.bottom {
      position: absolute;
      bottom: 20px;
      left: 16px;
      right: 16px;
    }

    .menu li {
      position: relative;
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 14px;
      border-radius: 12px;
      cursor: pointer;
      transition: background 0.25s;
    }

    .menu li:hover {
      background: rgba(255, 255, 255, .06);
    }

    /* Icon */
    .menu i {
      min-width: 24px;
      text-align: center;
      font-style: normal;
      font-size: 18px;
      transition: transform .2s ease;
    }

    .menu li:hover i {
      transform: scale(1.1);
    }

    /* Text */
    .menu span {
      white-space: nowrap;
      transition: opacity 0.25s ease;
    }

    /* Collapse behavior */
    .sidebar.collapsed span {
      opacity: 0;
      pointer-events: none;
    }

    /* Tooltip (collapsed hover) */
    .sidebar.collapsed li::after {
      content: attr(data-label);
      position: absolute;
      left: 78px;
      top: 50%;
      transform: translateY(-50%) translateX(-6px);
      background: #ffffff;
      color: #0f172a;
      padding: 6px 12px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      white-space: nowrap;
      opacity: 0;
      pointer-events: none;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
      transition: all 0.25s ease;
      z-index: 100;
    }

    /* Tooltip arrow */
    .sidebar.collapsed li::before {
      content: "";
      position: absolute;
      left: 70px;
      top: 50%;
      transform: translateY(-50%) translateX(-6px);
      border-width: 6px;
      border-style: solid;
      border-color: transparent #ffffff transparent transparent;
      opacity: 0;
      transition: all 0.25s ease;
    }

    /* Show tooltip */
    .sidebar.collapsed li:hover::after,
    .sidebar.collapsed li:hover::before {
      opacity: 1;
      transform: translateY(-50%) translateX(0);
    }

    a {
      text-decoration: none;
      color: white;
    }
  </style>
</head>

<body>

  <div class="sidebar collapsed" id="sidebar">

    <div class="sidebar-header">
      <div class="logo"><img src="../include/Lagro_High_School_logo.png" alt=""></div>
    </div>

    <ul class="menu">
      <button class="toggle-btn" id="arrow" onclick="toggleSidebar()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
        </svg></button>
      <a href="index.php">
        <li data-label="Home"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
              <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
            </svg></i><span>Home</span></li>
      </a>
      <a href="studentlist.php">
        <li data-label="Student Record"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
              <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
            </svg></i><span>Student Record</span></li>
      </a>
      <a href="anecdotal.php">
        <li data-label="Anecdotal Record"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
            </svg></i><span>Anecdotal Record</span></li>
      </a>

    </ul>
    <ul class="menu middle" style="margin-top: 20px; border-top: 1px solid rgba(255, 255, 255, .1); padding-top: 12px;">
      <li data-label="<?php echo $user["last_name"]; ?>"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
          </svg></i><span><?php echo $user["last_name"]; ?></span></li>
      <li data-label="<?php echo $user["employee_id"]; ?>"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hash" viewBox="0 0 16 16">
            <path d="M8.39 12.648a1 1 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1 1 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.51.51 0 0 0-.523-.516.54.54 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532s.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531s.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z" />
          </svg></i><span><?php echo $user["employee_id"]; ?></span></li>
    </ul>

    <ul class="menu bottom" style="border-top: 1px solid rgba(255, 255, 255, .1);">
      <a href="../process/logout.php">
        <li data-label="Logout"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
              <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
            </svg></i><span>Logout</span></li>

      </a>
      <li data-label="Location"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg></i><span>Location</span></li>
    </ul>

  </div>

  <script>
    let open = false;

    function toggleSidebar() {
      if (open === false) {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("arrow").style.transform = "rotate(180deg)";
        open = true
      } else {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("arrow").style.transform = "rotate(0deg)";
        open = false;
      }
    }
  </script>

</body>

</html>