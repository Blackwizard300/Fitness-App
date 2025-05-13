<?php
session_start();
$firstname = $_SESSION['user_name'] ?? null;
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inika:wght@400;700&family=Inter:wght@700&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background-color: #000;
    font-family: "Inika", serif;
  }

  .site-header {
    width: 100%;
    height: 88px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    background-color: rgba(0, 0, 0, 0.52);
  }

  .brand {
    display: flex;
    align-items: center;
  }

  .logo {
    width: 50px;
    height: 50px;
    margin-right: 8px;
  }

  .brand-name {
    font-size: 28px;
    color: #fff;
    font-weight: 700;
  }

  .main-nav {
    display: flex;
    align-items: center;
    gap: 30px;
    position: relative;
  }

  .nav-link {
    font-size: 20px;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    position: relative;
    letter-spacing: 0.8px;
    transition: color 0.3s ease;
    cursor: pointer;
  }

  .nav-link:hover,
  .nav-link:focus {
    color: #df583a;
  }

  .nav-link.active,
  .nav-link.highlight {
    color: #df583a;
    font-weight: 700;
  }

  .nav-link::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 2px;
    background: #df583a;
    left: 0;
    bottom: -5px;
    transition: width 0.3s ease;
  }

  .nav-link:hover::after,
  .nav-link:focus::after {
    width: 100%;
  }

  /* DROPDOWN */
  .dropdown {
    position: relative;
  }

  .dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .dropdown-toggle::after {
    content: "▼";
    font-size: 12px;
    color: #fff;
    margin-left: 4px;
  }

  .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #000;
    padding: 8px 0;
    display: none;
    flex-direction: column;
    min-width: 160px;
    border-radius: 5px;
    z-index: 1000;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
  }

  .dropdown:hover .dropdown-menu {
    display: flex;
  }

  .dropdown-menu a {
    padding: 10px 20px;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s ease;
    font-family: "Inika", serif;
  }

  .dropdown-menu a:hover {
    background-color: #df583a;
  }

  /* USER PROFILE */
  .profile-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
  }

  .user-profile {
    display: flex;
    align-items: center;
    cursor: pointer;
    position: relative;
  }

  .profile-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
  }

  .welcome-text {
    font-size: 18px;
    font-weight: 500;
    white-space: nowrap;
  }

  .dropdown-toggle::after {
  content: none;
}

  .user-profile .dropdown-menu {
    right: 0;
    left: auto;
  }

  /* Responsive */
  @media (max-width: 991px) {
    .main-nav {
      flex-wrap: wrap;
      justify-content: flex-end;
    }

    .dropdown-menu {
      position: static;
      display: none;
      margin-top: 10px;
    }

    .dropdown.open .dropdown-menu {
      display: flex;
    }
  }
  .search-bar {
  display: flex;
  align-items: end;
  justify-content: end;
  width: 200px;
}

.search-input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #fff;
  background-color: transparent;
  color: #fff;
  border-radius: 5px;
  outline: none;
}

.search-input::placeholder {
  color: #fff;
}
</style>

<header class="site-header">
  <div class="brand">
    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/7b6541ede10c1638f975eb8462cc5781a46fc7e2?placeholderIfAbsent=true" alt="Logo" class="logo" />
    <h1 class="brand-name">VASK FITNESS</h1>
  </div>

  <nav class="main-nav">
    <div class="search-bar">
              <input type="text" placeholder="Search..." class="search-input" />
            </div>
    <a href="homepage.html" class="nav-link active">Home</a>
    <a href="aboutus1.html" class="nav-link">About us</a>


    <div class="dropdown">
      <div class="nav-link dropdown-toggle">Meal</div>
      <div class="dropdown-menu">
        <a href="weight gain meal.html">Weight Gain</a>
        <a href="weight loss meal.html">Weight Loss</a>
      </div>
    </div>

    <div class="dropdown">
      <div class="nav-link dropdown-toggle">Workout</div>
      <div class="dropdown-menu">
        <a href="weight gain meal.html">Weight Gain</a>
        <a href="#">Weight Loss</a>
      </div>
    </div>

    <?php if ($firstname === null): ?>
      <a href="signup.html" class="nav-link highlight">Register now</a>
    <?php else: ?>
      <div class="dropdown user-profile">
        <div class="nav-link dropdown-toggle profile-toggle">
          <img
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/13ee4f60030d35b5687c38262d8a815b99cc42eb?placeholderIfAbsent=true&apiKey=beadebc2327f4b1080f7e8c568788d2b"
            alt="User Profile"
            class="profile-icon"
          />
          <span class="welcome-text">Welcome, <?= htmlspecialchars($firstname) ?></span>
        </div>
        <div class="dropdown-menu">
          <a href="logout.php">Logout</a>
        </div>
      </div>
    <?php endif; ?>
  </nav>
</header>

<!-- OPTIONAL: JavaScript to support mobile click toggle -->
<script>
  document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      const dropdown = toggle.closest('.dropdown');
      document.querySelectorAll('.dropdown').forEach(d => {
        if (d !== dropdown) d.classList.remove('open');
      });
      dropdown.classList.toggle('open');
      e.stopPropagation();
    });
  });

  // Close dropdowns on click outside
  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
  });
</script>
