// Load navbar
document.addEventListener('DOMContentLoaded', function() {
    fetch('navbar.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('site-header').innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading navbar:', error);
        });
});

// Logout function
function logout() {
    fetch('logout.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'login.html';
            }
        })
        .catch(error => {
            console.error('Error during logout:', error);
        });
}

// Function to create the navbar HTML
function createNavbar(isLoggedIn) {
    const navbar = `
        <nav class="navbar">
            <div class="nav-brand">
                <a href="index.html">VASK FITNESS</a>
            </div>
            <div class="nav-links">
                ${isLoggedIn ? `
                    <a href="dashboard.html">Dashboard</a>
                    <a href="workouts.html">Workouts</a>
                    <a href="nutrition.html">Nutrition</a>
                    <div class="profile-container">
                        <img src="uploads/default-profile.png" class="nav-profile-img" alt="Profile" onclick="window.location.href='profile.html'">
                    </div>
                    <a href="#" onclick="logout()">Logout</a>
                ` : `
                    <a href="login.html">Login</a>
                    <a href="register.html">Register</a>
                `}
            </div>
        </nav>
    `;
    document.getElementById('site-header').innerHTML = navbar;

    // If logged in, fetch and update profile image
    if (isLoggedIn) {
        fetch('get_profile_data.php')
            .then(response => response.json())
            .then(result => {
                if (!result.error && result.data.profile_image) {
                    document.querySelector('.nav-profile-img').src = result.data.profile_image;
                }
            })
            .catch(error => console.error('Error fetching profile image:', error));
    }
}

// Add styles for the profile image in navbar
const style = document.createElement('style');
style.textContent = `
    .profile-container {
        display: inline-block;
        margin: 0 15px;
    }
    .nav-profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        object-fit: cover;
        border: 2px solid #ff6b00;
        transition: transform 0.2s;
    }
    .nav-profile-img:hover {
        transform: scale(1.1);
    }
`;
document.head.appendChild(style);