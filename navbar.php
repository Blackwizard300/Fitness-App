<?php
session_start();
$firstname = $_SESSION['user_name'] ?? null;
?>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #111;
    }

    .main-nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 10px;
      background-color: #222;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .nav-link, .login {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-link:hover, .login:hover {
      color: #00d084;
    }

    .nav-links {
      display: flex;
      align-items: center;
    }

    .profile-container {
  position: relative;
  display: flex;
  align-items: center;
  margin-left: 20px;
  color: white;
  cursor: pointer;
}

.profile-container:hover .dropdown,
.profile-container:focus-within .dropdown {
  display: block;
}



    .profile-icon {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #00d084;
    }

    .welcome {
      font-size: 0.9rem;
      margin-left: 10px;
      color: #fff;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 45px;
      right: 0;
      background-color: #333;
      border: 1px solid #00d084;
      border-radius: 5px;
      min-width: 100px;
      z-index: 1001;
    }

    .dropdown a {
      display: block;
      padding: 10px;
      color: white;
      text-decoration: none;
    }

    .dropdown a:hover {
      background-color: #00d084;
      color: #111;
    }

    .show-dropdown {
      display: block;
    }

    @media (max-width: 768px) {
      .main-nav {
        flex-direction: column;
        align-items: flex-start;
      }

      .nav-links {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
      }

      .nav-link, .login {
        margin: 10px 0;
      }

      .profile-container {
        margin-top: 10px;
        align-self: center;
      }
    }
  </style>
<header class="nav-header">
  <div class="brand">
    <img
      src="https://cdn.builder.io/api/v1/image/assets/TEMP/1a2b279d63205da0f1533bc9da9c25df9ebca245?placeholderIfAbsent=true&apiKey=beadebc2327f4b1080f7e8c568788d2b"
      alt="Vask Fitness Logo"
      class="brand-logo"
    />
    <h1 class="brand-name">VASK FITNESS</h1>
  </div>  
    

<nav class="main-nav">
  <div class="nav-links">
    <a href="homepage.html" class="nav-link">Home</a>
    <a href="meal.html" class="nav-link">Meal</a>
    <a href="aboutus1.html" class="nav-link">About us</a>
    <a href="workout.html" class="nav-link">Workout</a>
    <!-- <a href="chest.html" class="nav-link">Chest</a> -->

    <?php if ($firstname === null): ?>
      <a href="login.html" class="login">Login</a>
    <?php else: ?>
      <div class="profile-container">
      <img
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/13ee4f60030d35b5687c38262d8a815b99cc42eb?placeholderIfAbsent=true&apiKey=beadebc2327f4b1080f7e8c568788d2b"
          alt="User Profile"
          class="profile-icon"
        />
        <span class="welcome">Welcome, <?= htmlspecialchars($firstname) ?></span>

        <div id="profileDropdown" class="dropdown">
          <a href="logout.php">Logout</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
  </nav>
</header>



