<?php
session_start();
include "php/db.php";

if (!isset($_SESSION["user_id"]) ||
    ($_SESSION["role"] ?? "") != "admin") {

    header("Location: login.html");
    exit();
}

$students = mysqli_query($conn,
    "SELECT id, name, email FROM users
     WHERE role = 'student' ORDER BY id DESC");

$notes = mysqli_query($conn,
    "SELECT id, title, subject FROM notes ORDER BY id DESC");

$questions = mysqli_query($conn,
    "SELECT id, question, subject FROM questions ORDER BY id DESC");

$groups = mysqli_query($conn,
    "SELECT id, group_name, subject FROM study_groups ORDER BY id DESC");

$studentCount = mysqli_num_rows($students);
$noteCount = mysqli_num_rows($notes);
$questionCount = mysqli_num_rows($questions);
$groupCount = mysqli_num_rows($groups);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - StudyCircle</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="images/favicon.png">
</head>
<body>

<header class="admin-header">
    <div class="admin-container admin-nav">
        <a href="index.html" class="admin-logo">📚 StudyCircle</a>

        <nav>
            <a href="index.html">Home</a>
            <a href="dashboard.html">Student Dashboard</a>
            <a href="admin.php">Admin</a>
            <a href="php/logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="admin-container">

    <section class="admin-welcome">
        <h1>Admin Dashboard 🛡</h1>
        <p>Manage students and shared study materials.</p>
    </section>

    <section class="admin-cards">

        <div class="admin-card">
            <h3>Students</h3>
            <p id="studentCount">
                <?php echo $studentCount; ?>
            </p>
        </div>

        <div class="admin-card">
            <h3>Notes</h3>
            <p id="noteCount">
                <?php echo $noteCount; ?>
            </p>
        </div>

        <div class="admin-card">
            <h3>Questions</h3>
            <p id="questionCount">
                <?php echo $questionCount; ?>
            </p>
        </div>

        <div class="admin-card">
            <h3>Study Groups</h3>
            <p id="groupCount">
                <?php echo $groupCount; ?>
            </p>
        </div>

    </section>

    <section class="admin-section">
        <h2>Manage Students</h2>

        <div class="table-scroll">
            <table id="studentTable">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>

                <?php while ($student = mysqli_fetch_assoc($students)) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($student["name"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($student["email"]); ?>
                    </td>
                    <td>
                        <form action="php/delete_student.php" method="POST" onsubmit="return removeRow()">
                            <input type="hidden" name="id" value="<?php echo (int)$student["id"]; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>

    <section class="admin-section">
        <h2>Manage Notes</h2>

        <div class="table-scroll">
            <table id="noteTable">
                <tr>
                    <th>Note Title</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>

    <?php while ($note = mysqli_fetch_assoc($notes)) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($note["title"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($note["subject"]); ?>
                    </td>
                    <td>
                        <form action="php/delete_note.php" method="POST" onsubmit="return removeRow()">
                            <input type="hidden" name="id" value="<?php echo (int)$note["id"]; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>

    <section class="admin-section">
        <h2>Manage Questions</h2>

        <div class="table-scroll">
            <table id="questionTable">
                <tr>
                    <th>Question</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>

                <?php while ($question = mysqli_fetch_assoc($questions)) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($question["question"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($question["subject"]); ?>
                    </td>
                    <td>
                        <form action="php/delete_question.php" method="POST" onsubmit="return removeRow()">
                            <input type="hidden" name="id" value="<?php echo (int)$question["id"]; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>

    <section class="admin-section">
        <h2>Manage Study Groups</h2>

        <div class="table-scroll">
            <table id="groupTable">
                <tr>
                    <th>Group Name</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>

                <?php while ($group = mysqli_fetch_assoc($groups)) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($group["group_name"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($group["subject"]); ?>
                    </td>
                    <td>
                        <form action="php/delete_group.php" method="POST" onsubmit="return removeRow()">
                            <input type="hidden" name="id" value="<?php echo (int)$group["id"]; ?>">
                            <button type="submit">Remove</button>
                        </form> 
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>

    <p id="adminMessage" class="admin-message" aria-live="polite"></p>

</main>

<footer class="admin-footer">
    StudyCircle • Student Learning Community
</footer>

<script src="js/admin.js"></script>

</body>
</html>