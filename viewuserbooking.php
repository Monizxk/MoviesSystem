<?php
include('connect.php'); // Підключення до бази даних

// Перевірка чи користувач авторизований (чи є у сесії ID користувача)
if(!isset($_SESSION['uid'])){
    echo "<script> window.location.href='login.php';  </script>"; // Якщо ні — редирект на сторінку логіну
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Booking</title> <!-- Заголовок сторінки -->
</head>
<body>

<?php include('header.php')  ?> <!-- Підключення заголовка сайту -->

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Таблиця для відображення бронювань користувача -->
            <table class="table">
                <tr>
                    <th>#</th> <!-- Ідентифікатор бронювання -->
                    <th>Name</th> <!-- Назва кінотеатру -->
                    <th>Category</th> <!-- Назва фільму та категорії -->
                    <th>Date</th> <!-- Дата та час сеансу -->
                    <th>Days/Time</th> <!-- Дні та час -->
                    <th>Ticket</th> <!-- Ціна квитка -->
                    <th>Location</th> <!-- Місце проведення -->
                    <th>User</th> <!-- Користувач -->
                    <th>Status</th> <!-- Статус бронювання -->
                </tr>

                <?php

                // Отримання ID користувача із сесії
                $uid = $_SESSION['uid'];

                // SQL запит для отримання даних про бронювання користувача
                $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name AS 'username',
                booking.status
                FROM booking
                INNER JOIN theater ON theater.theaterid = booking.theaterid
                INNER JOIN users ON users.userid = booking.userid
                INNER JOIN movies ON movies.movieid = theater.movieid
                INNER JOIN categories ON categories.catid = movies.catid 
                WHERE booking.userid = '$uid'"; // Вибірка лише для конкретного користувача

                // Виконання SQL запиту
                $res  = mysqli_query($con, $sql);

                // Перевірка наявності результатів
                if(mysqli_num_rows($res) > 0){
                    // Виведення кожного бронювання
                    while($data = mysqli_fetch_array($res)){
                        ?>

                        <tr>
                            <td><?= $data['bookingid'] ?></td> <!-- Виведення ID бронювання -->
                            <td><?= $data['theater_name'] ?></td> <!-- Виведення назви кінотеатру -->
                            <td><?= $data['title'] ?> - <?= $data['catname'] ?></td> <!-- Виведення назви фільму та категорії -->
                            <td><?= $data['days'] ?> - <?= $data['timing'] ?></td> <!-- Виведення днів та часу сеансу -->
                            <td><?= $data['price'] ?></td> <!-- Виведення ціни квитка -->
                            <td><?= $data['bookingdate'] ?></td> <!-- Виведення дати бронювання -->
                            <td><?= $data['location'] ?></td> <!-- Виведення місця проведення -->
                            <td><?= $data['username'] ?></td> <!-- Виведення імені користувача -->

                            <td>
                                <?php
                                // Виведення статусу бронювання
                                if($data['status'] == 0){
                                    echo "<a href='#' class='btn btn-warning' > Pending </a>"; // Якщо статус 0 — очікує
                                }else{
                                    echo "<a href='#' class='btn btn-success' > Approved </a>"; // Якщо статус 1 — підтверджено
                                }
                                ?>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // Якщо бронювань не знайдено
                    echo 'no booking found';
                }
                ?>

            </table>
        </div>
    </div>
</div>

<?php include('footer.php')  ?> <!-- Підключення футера сайту -->

</body>
</html>
