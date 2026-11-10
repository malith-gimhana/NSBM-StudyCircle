<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

include "php/db.php";

$sessions = mysqli_query(
    $conn,
    "SELECT * FROM sessions ORDER BY session_date ASC, session_time ASC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Sessions - StudyCircle</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/groups.css">
    <link rel="icon" href="images/favicon.png">
</head>
<body>
    <header class="topbar">
        <div class="page-width top-row">
            <a href="index.html" class="brand">📚 StudyCircle</a>
            <nav>
                <a href="dashboard.html">Dashboard</a>
                <a href="groups.php">Groups</a>
                <a href="sessions.php">Sessions</a>
                <a href="index.html">Home</a>
            </nav>
        </div>
    </header>

    <main class="page-width">
        <section class="welcome">
            <h1>Study Sessions 📅</h1>
            <p>Plan a study session with your classmates.</p>
        </section>

        <section class="form-box">
            <h2>Schedule a Session</h2>

            <form action="php/add_session.php" method="POST"
                  onsubmit="return addSession()">

                <label for="sessionTitle">Session Title</label>
                <input type="text" id="sessionTitle" name="title"
                       placeholder="Enter session title" required>

                <label for="sessionDate">Date</label>
                <input type="date" id="sessionDate" name="session_date" required>

                <label for="sessionTime">Time</label>
                <input type="time" id="sessionTime" name="session_time" required>

                <label for="sessionPlace">Location or Meeting Link</label>
                <input type="text" id="sessionPlace" name="location"
                       placeholder="Location or online meeting link" required>

                <button type="submit" class="green-btn">Add Session</button>
                <p id="sessionMessage" class="message"></p>
            </form>
        </section>

        <section class="list-section">
            <h2>Study Sessions</h2>

            <div class="cards" id="sessionList">
                <?php while ($session = mysqli_fetch_assoc($sessions)) { ?>
                    <div class="group-card">
                        <h3><?php echo htmlspecialchars($session["title"]); ?></h3>

                        <p>
                            <strong>Date:</strong>
                            <?php echo htmlspecialchars($session["session_date"]); ?>
                        </p>

                        <p>
                            <strong>Time:</strong>
                            <?php echo htmlspecialchars($session["session_time"]); ?>
                        </p>

                        <p>
                            <strong>Location:</strong>
                            <?php echo htmlspecialchars($session["location"]); ?>
                        </p>

                        <button type="button" class="green-btn"
                                onclick="joinSession(this)">
                            View Session
                        </button>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

    <footer class="page-width">
        StudyCircle • Student Learning Community
    </footer>

    <script src="js/groups.js"></script>
</body>
</html>