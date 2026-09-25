<?php
session_start();
if (!isset($_SESSION['auth'])) { header("Location: login.php"); exit; }
include '../db.php';

$result = $conn->query("SELECT * FROM form_submissions ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .table-container {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .logout-btn { float: right; }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-4">
        <h3>📋 Form Submissions</h3>

<div>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a class="btn btn-success btn-sm" href="export.php">⬇ Export CSV</a>
    <?php endif; ?>

    <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
</div>


        <a class="btn btn-danger btn-sm logout-btn" href="logout.php">Logout</a>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Contact</th>
                    <th>Gender</th><th>Message</th><th>18+</th><th>Agreed</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()){ ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['contact_number']) ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['ex'] ?></td>
                    <td>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="delete.php?id=<?= $row['id'] ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this record permanently?');">🗑 Delete</a>
    <?php else: ?>
        <span class="text-secondary">No Access</span>
    <?php endif; ?>
</td>

                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($result->num_rows === 0) { ?>
            <p class="text-center text-muted mt-3">No records found.</p>
        <?php } ?>
    </div>
</div>

</body>
</html>