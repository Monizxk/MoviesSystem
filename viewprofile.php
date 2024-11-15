<?php
include('connect.php'); // Підключення до бази даних

// Перевірка чи користувач залогінений, якщо ні — редирект на сторінку логіну
if(!isset($_SESSION['uid'])){
    echo "<script> window.location.href='login.php';  </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title> <!-- Назва сторінки -->
</head>
<body>

<?php include('header.php')  ?> <!-- Підключення заголовка сайту -->

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Таблиця з інформацією про користувачів -->
            <table class="table">
                <tr>
                    <th>#</th> <!-- Колонка для ID користувача -->
                    <th>Name</th> <!-- Колонка для імені користувача -->
                    <th>Email</th> <!-- Колонка для email користувача -->
                    <th>Password</th> <!-- Колонка для пароля (не рекомендовано виводити пароль в чистому вигляді) -->
                </tr>

                <?php
                // Отримуємо ID користувача із сесії
                $uid = $_SESSION['uid'];
                // Запит до бази даних для отримання інформації про користувача по його ID
                $sql = "SELECT * FROM `users` WHERE userid = '$uid'";
                $res  = mysqli_query($con, $sql);

                // Якщо користувач знайдений
                if(mysqli_num_rows($res) > 0){
                    // Виводимо дані користувача в таблицю
                    while($data = mysqli_fetch_array($res)){
                        ?>

                        <tr>
                            <td><?= $data['userid'] ?></td> <!-- Виведення ID користувача -->
                            <td><?= $data['name'] ?></td> <!-- Виведення імені користувача -->
                            <td><?= $data['email'] ?> </td> <!-- Виведення email користувача -->
                            <td><?= $data['password'] ?> </td> <!-- Виведення пароля користувача -->
                        </tr>

                        <?php
                    }
                } else {
                    // Якщо користувача не знайдено
                    echo 'no user found';
                }
                ?>

            </table>
        </div>
    </div>
</div>

<?php include('footer.php')  ?> <!-- Підключення футера сайту -->

</body>
</html>
