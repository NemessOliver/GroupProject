<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/ouiii.png">
    <link rel="stylesheet" href="WReviews.css">
    <title>Write a Review!</title>
</head>
<body>
    <div class="BContainer">
        <div class="Header" id="header">
            <nav>
                <ul class="NavBar">
                    <li><a href="home.html">Home</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href=""><img src="images/ouiii.png" alt="OUI"></a></li>
                    <li class="Contact"><a href="contact.html">Contact</a></li>
                    <li><a href="Aboutus.html">About Us</a></li>
                </ul>
            </nav>
        </div>

        <div class="Container">            
            <?php
            // Variables to store the form data and error messages
            $firstName = $lastName = $email = $age = $gender = $review = $rating = "";
            $firstNameErr = $lastNameErr = $emailErr = $ageErr = $reviewErr = "";
            $successMessage = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validate first name (at least 2 characters)
                if (empty($_POST["firstName"]) || strlen($_POST["firstName"]) < 2) {
                    $firstNameErr = "First name must be at least 2 characters long.";
                } else {
                    $firstName = htmlspecialchars($_POST["firstName"]);
                }

                // Validate last name (at least 2 characters)
                if (empty($_POST["lastName"]) || strlen($_POST["lastName"]) < 2) {
                    $lastNameErr = "Last name must be at least 2 characters long.";
                } else {
                    $lastName = htmlspecialchars($_POST["lastName"]);
                }

                // Validate email format
                if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format.";
                } else {
                    $email = htmlspecialchars($_POST["email"]);
                }

                // Validate age (must be a number)
                if (empty($_POST["age"]) || !is_numeric($_POST["age"])) {
                    $ageErr = "Age must be a number.";
                } else {
                    $age = (int)htmlspecialchars($_POST["age"]);
                }

                // Validate review (max 300 characters)
                if (empty($_POST["review"]) || strlen($_POST["review"]) > 300) {
                    $reviewErr = "Review must be no longer than 300 characters.";
                } else {
                    $review = htmlspecialchars($_POST["review"]);
                }

                // Only proceed if no errors
                if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($ageErr) && empty($reviewErr)) {
                    $gender = htmlspecialchars($_POST["gender"]);
                    $rating = htmlspecialchars($_POST["rating"]);

                    // Store data in a file or a database
                    $file = fopen("reviews.txt", "a");
                    fwrite($file, "Name: $firstName $lastName\nEmail: $email\nAge: $age\nGender: $gender\nRating: $rating\nReview: $review\n\n");
                    fclose($file);

                    // Display success message
                    $successMessage = "Submission complete! Thank you, $firstName!";
                }
            }
            ?>

            <?php if (!empty($successMessage)) : ?>
                <div id="confirmationMessage"><h2><?php echo $successMessage; ?></h2></div>
            <?php else : ?>

            <div class="form-container">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="reviewForm">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
                    <span class="error"><?php echo $firstNameErr; ?></span>

                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
                    <span class="error"><?php echo $lastNameErr; ?></span>

                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                    <span class="error"><?php echo $emailErr; ?></span>

                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
                    <span class="error"><?php echo $ageErr; ?></span>

                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
                        <option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
                        <option value="Other" <?php if ($gender == "Other") echo "selected"; ?>>Other</option>
                    </select>
                    <label for="review">Write your review</label>
                    <textarea id="review" name="review" required><?php echo $review; ?></textarea>
                    <span class="error"><?php echo $reviewErr; ?></span>

                    <div class="star-rating">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                        <input type="hidden" id="rating" name="rating" value="0">
                    </div>

                    <button type="submit" id="submitBtn">Submit</button>
                </form>
            </div>

            <?php endif; ?>
        </div>

        <script src="WReviews.js"></script>
    </div>
</body>
</html>