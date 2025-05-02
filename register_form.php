<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - EventHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Register to EventHive</h2>
    <form action="php/register.php" method="post" enctype="multipart/form-data"> <!-- Added enctype attribute for file upload -->
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="prn" placeholder="PRN" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <!-- Profile Image Upload -->
        <label for="profile_image">Profile Picture:</label>
        <input type="file" name="profile_image" id="profile_image" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login_form.php">Login here</a></p>
</div>
</body>
</html>
