<?php include('connect.php')  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>


<section id="team" class="team section-bg">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-title">
            <h2>Register for Booking Ticket</h2>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <form action="register.php" method="post" role="form" class="php-email-form">
                    <div class="row">

                        <div class="col form-group mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required="">
                        </div>
                    </div>
                    <div class="col form-group mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Your Password" required="">
                    </div>

                    <div class="text-center"><button type="submit" class="btn btn-primary" name="register">Register</button></div>
                </form>
            </div>

        </div>

    </div>
</section>

</body>
</html>

<?php

if(isset($_POST['register'])){

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Перевірка, чи існує користувач з таким email
    $check_email = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script> alert('Користувач з таким email вже існує!'); </script>";
        return;
    }

    // Хешування пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Запит на додавання користувача
    $sql = "INSERT INTO `users`(`name`, `email`, `password`, `role_type`) VALUES ('$name', '$email', '$hashed_password', '2')";

    if(mysqli_query($con, $sql)){
        echo "<script> alert('Користувач успішно зареєстрований!'); </script>";
        echo "<script> window.location.href='login.php'; </script>";

    } else {
        echo "<script> alert('Сталася помилка, користувача не зареєстровано!'); </script>";
    }

}

?>
