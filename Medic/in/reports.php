<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['id'])) {
        include "../include/db.php";

        $id = intval($_POST['id']);
        $deleteQuery = "DELETE FROM report WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                echo "success";
                exit;
            } else {
                echo "error";
                exit;
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../Pics/Logos/Lagro_High_School_logo.png">
    <title>Reports | LHS Clinic</title>

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

        .sidebar-container {
            position: relative;
            left: 0;
            margin-bottom: -10px;
        }

        main {
            display: flex;
        }

        .container {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            padding: 12px;
            gap: 15px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease-in-out;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-topic {
            font-size: 1.2em;
            margin-bottom: 12px;
            color: #333;
            font-weight: 600;
            text-transform: capitalize;
        }

        .card-body {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
            flex-grow: 1;
        }

        .card-body label {
            font-weight: 600;
            color: #333;
            display: block;
            margin-bottom: 4px;
        }

        .card-body p {
            margin: 0;
        }

        .card-footer {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: flex-end;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .no-reports {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>

<body>
    <main>
        <div class="sidebar-container">
            <?php include '../include/sidebar.php'; ?>
        </div>

        <div class="container">

            <?php
            include "../include/db.php";
            $sql = "SELECT * FROM report";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="card" data-id="<?php echo $row['id']; ?>">
                        <div class="card-topic"><?php echo htmlspecialchars($row['topic']); ?></div>
                        <div class="card-body">
                            <label>Message:</label>
                            <p><?php echo htmlspecialchars($row['message']); ?></p>
                        </div>
                        <div class="card-body">
                            <label>Contact:</label>
                            <p><?php echo htmlspecialchars($row['contact']); ?></p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-danger" onclick="deleteReport(<?php echo $row['id']; ?>)">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg></span> Delete
                            </button>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<div class='no-reports'>No reports found.</div>";
            }

            ?>
        </div>
    </main>
    <?php include "../include/footer.php" ?>

    <script>
        function deleteReport(reportId) {
            if (confirm('Are you sure you want to delete this report?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', reportId);

                fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    })
                    .then(() => {
                        location.reload();
                    })
                    .catch(error => {
                        alert('Failed to delete report.');
                    });
            }
        }
    </script>
</body>

</html>