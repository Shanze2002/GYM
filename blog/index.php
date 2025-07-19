<?php
$conn = new mysqli("localhost", "root", "", "fitgym");

// Create uploads folder if it doesn't exist
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle new blog post submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id      = intval($_POST['id']);
    $title   = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $imageName = basename($_FILES["image"]["name"]);
        $imagePath = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            $image = $imagePath;
        } else {
            echo "<p style='color:red;'>❌ Failed to upload image.</p>";
        }
    }

    // If ID is manually set (optional)
    if ($id > 0) {
        $conn->query("INSERT INTO blog (id, title, content, image) VALUES ($id, '$title', '$content', '$image')");
    } else {
        $conn->query("INSERT INTO blog (title, content, image) VALUES ('$title', '$content', '$image')");
    }
}

// View single post
$singlePost = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM blog WHERE id = $id");
    if ($result->num_rows == 1) {
        $singlePost = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FitZone Blog</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
      background-size: cover;
      color: #e0e0e0;
      min-height: 100vh;
    }

    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      z-index: 0;
    }

    .container {
      position: relative;
      z-index: 1;
      max-width: 900px;
      margin: 60px auto;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 40px 50px;
      backdrop-filter: blur(12px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.6);
    }

    h1, h2 {
      color: #ff6f61;
      text-shadow: 0 0 5px rgba(255,111,97,0.8);
      text-align: center;
    }

    .post {
      margin-bottom: 40px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      padding-bottom: 25px;
    }

    .post img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.4);
    }

    form {
      margin-bottom: 60px;
    }

    label {
      color: #ffd6cc;
      display: block;
      margin-top: 20px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-size: 1rem;
      margin-top: 8px;
    }

    input:focus, textarea:focus {
      background: rgba(255,255,255,0.3);
      outline: none;
    }

    textarea {
      min-height: 120px;
    }

    button {
      margin-top: 30px;
      background: linear-gradient(45deg, #ff6f61, #ff9472);
      border: none;
      padding: 14px 30px;
      border-radius: 30px;
      color: white;
      font-weight: bold;
      font-size: 1.1rem;
      cursor: pointer;
    }

    .read-more {
      color: #ff9a8b;
      text-decoration: none;
    }

    .read-more:hover {
      text-decoration: underline;
    }

    .back-button {
      display: inline-block;
      margin-top: 30px;
      background: #ff6f61;
      padding: 12px 25px;
      border-radius: 30px;
      color: white;
      font-weight: 700;
      text-decoration: none;
    }

    .back-button:hover {
      background: #ff9472;
    }

    @media (max-width: 600px) {
      .container {
        padding: 20px;
        margin: 30px 15px;
      }

      button, .back-button {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>
<body>

<div class="container">

  <?php if ($singlePost): ?>
    <h1><?php echo htmlspecialchars($singlePost['title']); ?></h1>
    <?php if ($singlePost['image']): ?>
      <img src="<?php echo htmlspecialchars($singlePost['image']); ?>" alt="Blog Image" />
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($singlePost['content'])); ?></p>

    <a class="back-button" href="http://localhost/GYM/main/index.html">← Back to Home</a>

  <?php else: ?>
    <h1>FitZone Stylish Blog</h1>

    <form method="POST" action="index.php" enctype="multipart/form-data">
      <label for="id">Blog ID (optional)</label>
      <input type="text" name="id" id="id" />

      <label for="title">Title</label>
      <input type="text" name="title" id="title" required />

      <label for="content">Content</label>
      <textarea name="content" id="content" required></textarea>

      <label for="image">Image (optional)</label>
      <input type="file" name="image" id="image" accept="image/*" />

      <button type="submit">Post Blog</button>
    </form>

    <?php
    $posts = $conn->query("SELECT * FROM blog ORDER BY id DESC");
    while ($row = $posts->fetch_assoc()):
    ?>
      <div class="post">
        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
        <?php if (!empty($row['image']) && file_exists($row['image'])): ?>
          <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" />
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 200))); ?>...</p>
        <a class="read-more" href="index.php?id=<?php echo $row['id']; ?>">Read More →</a>
      </div>
    <?php endwhile; ?>

  <?php endif; ?>

</div>

</body>
</html>




