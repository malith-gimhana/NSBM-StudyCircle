<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

include "php/db.php";

$questions = mysqli_query($conn, "SELECT * FROM questions ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions - StudyCircle</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/questions.css">
    <link rel="icon" href="images/favicon.png">
</head>
<body>

    <header class="question-header">
        <div class="question-container question-nav">
            <a href="index.html" class="question-logo">📚 StudyCircle</a>

            <nav>
                <a href="dashboard.html">Dashboard</a>
                <a href="notes.php">Notes</a>
                <a href="questions.php">Questions</a>
                <a href="index.html">Home</a>
            </nav>
        </div>
    </header>

    <main class="question-container">

        <section class="question-intro">
            <h1>Questions & Answers 💬</h1>
            <p>Ask questions and help other students learn.</p>
        </section>

        <section class="question-form-box">
            <h2>Ask a Question</h2>

            <form action="php/add_question.php" method="POST"
                  onsubmit="return addQuestion()">

                <label for="questionTitle">Question Title</label>
                <input type="text" id="questionTitle" name="title"
                       maxlength="200" placeholder="Enter your question" required>

                <label for="questionSubject">Subject</label>
                <select id="questionSubject" name="subject" required>
                    <option value="" hidden>Choose a subject</option>
                    <option>Web and Mobile Development</option>
                    <option>Algorithms and Data Structures</option>
                    <option>Object Oriented Programming with Java</option>
                    <option>IT Solutions Architecture</option>
                    <option>Fundamentals of Data Communication and Security</option>
                    <option>Other</option>
                </select>

                <label for="questionDetails">Details</label>
                <textarea id="questionDetails" name="question" rows="4"
                          placeholder="Explain your question" required></textarea>

                <button type="submit" class="question-btn">
                    Post Question
                </button>

                <p id="questionMessage" aria-live="polite"></p>
            </form>
        </section>

        <section class="question-list-section">
            <h2>Recent Questions</h2>

            <div id="questionList">

                <?php if (mysqli_num_rows($questions) == 0) { ?>
                    <p>No questions posted yet.</p>
                <?php } ?>

                <?php while ($row = mysqli_fetch_assoc($questions)) { ?>

                    <div class="question-card">

                        <span class="question-subject">
                            <?php echo htmlspecialchars($row["subject"]); ?>
                        </span>

                        <h3>
                            <?php echo htmlspecialchars($row["title"]); ?>
                        </h3>

                        <p>
                            <?php echo nl2br(htmlspecialchars($row["question"])); ?>
                        </p>

                        <div class="answer-area">
                            <h4>Answers</h4>

                            <div class="answer-list">

                                <?php
                                $question_id = (int) $row["id"];

                                $answers = mysqli_query($conn,
                                    "SELECT * FROM answers
                                     WHERE question_id = $question_id
                                     ORDER BY id ASC"
                                );
                                ?>

                                <?php while ($answer = mysqli_fetch_assoc($answers)) { ?>

                                    <p>
                                        <?php echo nl2br(htmlspecialchars($answer["answer"])); ?>
                                    </p>

                                <?php } ?>

                            </div>

                            <form action="php/add_answer.php" method="POST"
                                  onsubmit="return addAnswer(this)">

                                <input type="hidden" name="question_id"
                                       value="<?php echo $row["id"]; ?>">

                                <input type="text" name="answer"
                                       placeholder="Write an answer"
                                       class="answer-input" required>

                                <button type="submit" class="answer-btn">
                                    Reply
                                </button>

                            </form>

                        </div>
                    </div>

                <?php } ?>

            </div>
        </section>

    </main>

    <footer class="question-footer">
        StudyCircle • Student Learning Community
    </footer>

    <script src="js/questions.js"></script>

</body>
</html>