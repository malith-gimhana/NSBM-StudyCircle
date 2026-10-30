
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

include "php/get_notes.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes - StudyCircle</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <header class="topbar">
        <div class="page-width top-row">
            <a href="index.html" class="brand">📚 StudyCircle</a>

            <nav>
                <a href="dashboard.html">Dashboard</a>
                <a href="notes.php">Notes</a>
                <a href="upload.html">Upload</a>
                <a href="index.html">Home</a>
                <a href="php/logout.php" class="logout-btn">Logout</a>
            </nav>
        </div>
    </header>

    <main class="page-width">

        <section class="welcome">
            <h1>Lecture Notes 📖</h1>
            <p>Search notes shared by students.</p>
        </section>

        <div class="search-area">
            <input type="text" id="searchNotes"
                   onkeyup="searchNotes()"
                   placeholder="Search notes">

            <button class="green-btn" onclick="searchNotes()">
                Search
            </button>
        </div>

        <section class="card-row" id="notesList">

            <?php while ($note = $result->fetch_assoc()) { ?>

                <div class="info-card note-card">

                    <h2>
                        <?php echo htmlspecialchars($note["title"]); ?>
                    </h2>

                    <p>
                        <?php echo htmlspecialchars($note["subject"]); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($note["description"]); ?>
                    </p>

                    <span class="small-label">PDF Note</span>

                    <p>
                        <a class="green-btn"
                           href="uploads/notes/<?php echo rawurlencode($note["file_name"]); ?>"
                           target="_blank"
                           rel="noopener">
                            View PDF
                        </a>
                    </p>

                </div>

            <?php } ?>

        </section>

        <p id="noResults" class="message"
           <?php if ($result->num_rows > 0) { echo "hidden"; } ?>>
            No notes found.
        </p>

    </main>

    <footer class="page-width">
        StudyCircle • Student Learning Community
    </footer>

    <script src="js/dashboard.js"></script>

</body>
</html>
