<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

require_once 'db.php';

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Close the database connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>VASK FITNESS - Profile</title>
  <link rel="stylesheet" href="profile.css" />
</head>
<body>
  <header class="nav-header">
    <nav class="nav-container">
      <div class="nav-brand">
        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/7b6541ede10c1638f975eb8462cc5781a46fc7e2" alt="Vask Fitness Logo" class="brand-logo" />
        <h1 class="brand-name">VASK FITNESS</h1>
      </div>

      <div class="nav-menu">
        <a href="homepage1.html" class="nav-link">Home</a>
        <a href="aboutus2.html" class="nav-link">About us</a>

        <div class="nav-link dropdown">
          <a href="#" class="dropdown-toggle">Meal</a>
          <div class="dropdown-menu">
            <a href="weight gain meal.html" class="dropdown-item">Weight Gain</a>
            <a href="#" class="dropdown-item">Weight Loss</a>
          </div>
        </div>

        <div class="nav-link dropdown">
          <a href="#" class="dropdown-toggle">Workout</a>
          <div class="dropdown-menu">
            <a href="#" class="dropdown-item">Weight Gain</a>
            <a href="#" class="dropdown-item">Weight Loss</a>
          </div>
        </div>

        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/70dabb4641fdacdc5e401a2306246c2dd71813c0" class="user-icon" alt="User Icon" />
      </div>
    </nav>
  </header>

  <main class="profile-page">
    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/04dca3f3539d4f4b238610897fe19e1e0e6b74a9" class="background-image" alt="Profile Background" />

    <h2 class="profile-title">Profile</h2>

    <div class="profile-section">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/15bd93239546b06f33ca3cec6c1b6fc5ae2dba60" class="profile-pic" alt="User Picture" />

      <form action="update_profile.php" method="POST" class="profile-details">
        <div class="column">
          <div class="detail-group">
            <label class="detail-label">First Name:</label>
            <input type="text" name="firstname" class="detail-input" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
          </div>
          <div class="detail-group">
            <label class="detail-label">Last Name:</label>
            <input type="text" name="lastname" class="detail-input" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
          </div>
          <div class="detail-group">
            <label class="detail-label">Display Name:</label>
            <input type="text" name="display_name" class="detail-input" value="<?php echo htmlspecialchars($user['display_name']); ?>">
          </div>
          <div class="detail-group">
            <label class="detail-label">Email:</label>
            <input type="email" name="email" class="detail-input" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
          </div>
        </div>
        <div class="column">
          <div class="detail-group">
            <label class="detail-label">Age:</label>
            <input type="number" name="age" class="detail-input" value="<?php echo htmlspecialchars($user['age']); ?>" min="1" max="120">
          </div>
          <div class="detail-group">
            <label class="detail-label">Gender:</label>
            <select name="gender" class="detail-input">
              <option value="">Select Gender</option>
              <option value="male" <?php echo $user['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
              <option value="female" <?php echo $user['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
              <option value="other" <?php echo $user['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
          </div>
          <div class="detail-group">
            <label class="detail-label">Weight (kg):</label>
            <input type="number" name="weight" class="detail-input" value="<?php echo htmlspecialchars($user['weight']); ?>" step="0.1">
          </div>
          <div class="detail-group">
            <label class="detail-label">Height (cm):</label>
            <input type="number" name="height" class="detail-input" value="<?php echo htmlspecialchars($user['height']); ?>" step="0.1">
          </div>
        </div>
        <button type="submit" class="update-button">Update Profile</button>
      </form>

      <?php if (isset($_SESSION['success_message'])): ?>
        <div class="message success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
      <?php endif; ?>

      <?php if (isset($_SESSION['error_message'])): ?>
        <div class="message error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
      <?php endif; ?>
    </div>
  </main>
</body>
</html> 