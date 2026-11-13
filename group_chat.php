
<?php
session_start();
include "php/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$userId = (int)$_SESSION["user_id"];
$groupId = (int)($_GET["id"] ?? 0);

if ($groupId <= 0) {
    die("Invalid group.");
}

// Check if student joined the group
$stmt = $conn->prepare(
    "SELECT id FROM group_members
     WHERE group_id = ? AND user_id = ?"
);
$stmt->bind_param("ii", $groupId, $userId);
$stmt->execute();

if ($stmt->get_result()->num_rows == 0) {
    die("You must join this group first.");
}

// Get group details
$stmt = $conn->prepare(
    "SELECT group_name, subject
     FROM study_groups WHERE id = ?"
);
$stmt->bind_param("i", $groupId);
$stmt->execute();
$group = $stmt->get_result()->fetch_assoc();

if (!$group) {
    die("Group not found.");
}

// Get group members
$stmt = $conn->prepare(
    "SELECT users.name
     FROM group_members
     JOIN users ON group_members.user_id = users.id
     WHERE group_members.group_id = ?
     ORDER BY users.name"
);
$stmt->bind_param("i", $groupId);
$stmt->execute();
$members = $stmt->get_result();

// Get messages
$stmt = $conn->prepare(
    "SELECT users.name, group_messages.message,
            group_messages.created_at
     FROM group_messages
     JOIN users ON group_messages.user_id = users.id
     WHERE group_messages.group_id = ?
     ORDER BY group_messages.id ASC
     LIMIT 100"
);
$stmt->bind_param("i", $groupId);
$stmt->execute();
$messages = $stmt->get_result();

if (empty($_SESSION["chat_token"])) {
    $_SESSION["chat_token"] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat - StudyCircle</title>
    <link rel="stylesheet" href="css/group_chat.css">
</head>
<body>

<header>
    <h2>📚 StudyCircle</h2>
    <a href="groups.php">Back to Groups</a>
</header>

<div class="container">

    <h1>
        <?php echo htmlspecialchars($group["group_name"]); ?>
    </h1>

    <p>
        Subject:
        <?php echo htmlspecialchars($group["subject"]); ?>
    </p>

    <div class="layout">

        <div class="chat-box">
            <h2>Group Chat</h2>

            <div class="messages">
                <?php while ($row = $messages->fetch_assoc()) { ?>
                    <div class="message">
                        <strong>
                            <?php echo htmlspecialchars($row["name"]); ?>
                        </strong>

                        <p>
                            <?php echo nl2br(htmlspecialchars($row["message"])); ?>
                        </p>

                        <small>
                            <?php echo htmlspecialchars($row["created_at"]); ?>
                        </small>
                    </div>
                <?php } ?>
            </div>

            <form action="php/send_group_message.php"
                  method="POST">

                <input type="hidden" name="group_id"
                       value="<?php echo $groupId; ?>">

                <input type="hidden" name="chat_token"
                       value="<?php echo htmlspecialchars($_SESSION["chat_token"]); ?>">

                <textarea name="message"
                          maxlength="1000"
                          placeholder="Type your message..."
                          required></textarea>

                <button type="submit">Send Message</button>
            </form>

            <a class="refresh"
               href="group_chat.php?id=<?php echo $groupId; ?>">
                Refresh Messages
            </a>
        </div>

        <div class="members-box">
            <h2>Group Members</h2>

            <?php while ($member = $members->fetch_assoc()) { ?>
                <p>
                    👤 <?php echo htmlspecialchars($member["name"]); ?>
                </p>
            <?php } ?>
        </div>

    </div>
</div>

</body>
</html>
