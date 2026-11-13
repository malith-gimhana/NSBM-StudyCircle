<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

include "php/db.php";

$user_id = $_SESSION["user_id"];
$groups = mysqli_query($conn, "SELECT * FROM study_groups ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Groups - StudyCircle</title>
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
            <h1>Study Groups 👥</h1>
            <p>Find students who study the same subjects as you.</p>
        </section>

        <section class="form-box">
            <h2>Create a Group</h2>

            <form action="php/add_group.php" method="POST" onsubmit="return addGroup()">
                <label for="groupName">Group Name</label>
                <input type="text" id="groupName" name="group_name"
                       placeholder="Enter group name" required>

                <label for="groupSubject">Subject</label>
                <select id="groupSubject" name="subject" required>
                    <option value="" hidden>Choose a subject</option>
                    <option>Web and Mobile Development</option>
                    <option>Algorithms and Data Structures</option>
                    <option>Object Oriented Programming with Java</option>
                    <option>IT Solutions Architecture</option>
                    <option>Fundamentals of Data Communication and Security</option>
                    <option>Other</option>
                </select>

                <label for="groupDescription">Description</label>
                <textarea id="groupDescription" name="description"
                          rows="3" placeholder="About this group" required></textarea>

                <button type="submit" class="green-btn">Create Group</button>
                <p id="groupMessage" class="message"></p>
            </form>
        </section>

        <section class="list-section">
            <h2>Available Groups</h2>

            <div class="cards" id="groupList">
                <?php while ($group = mysqli_fetch_assoc($groups)) { ?>
                    <div class="group-card">
                        <h3><?php echo htmlspecialchars($group["group_name"]); ?></h3>

                        <p>
                            <strong>Subject:</strong>
                            <?php echo htmlspecialchars($group["subject"]); ?>
                        </p>

                        <p><?php echo htmlspecialchars($group["description"]); ?></p>

                        <?php
                        $group_id = (int) $group["id"];

                        $check = $conn->prepare(
                            "SELECT id FROM group_members WHERE group_id = ? AND user_id = ?"
                        );
                        $check->bind_param("ii", $group_id, $user_id);
                        $check->execute();
                        $joined = $check->get_result()->num_rows > 0;
                        $check->close();
                        ?>

                        <?php if ($joined) { ?>

                            <button class="green-btn" disabled>Joined</button>

                            <a href="group_chat.php?id=<?php echo $group_id; ?>" class="green-btn open-group-btn">
                                    Open Group
                            </a>

                        <?php } else { ?>
                            <form action="php/join_group.php" method="POST"
                                  onsubmit="return joinGroup(this)">
                                <input type="hidden" name="group_id"
                                       value="<?php echo $group_id; ?>">
                                <button type="submit" class="green-btn">
                                    Join Group
                                </button>
                            </form>
                        <?php } ?>
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
