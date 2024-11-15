<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>

<?php include('connect.php');  // Підключення до бази даних ?>
<?php include('header.php');  // Додавання заголовка (хедера) на сторінку ?>

<section id="team" class="team section-bg">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <!-- Розділ з інформацією про театр -->
        <div class="section-title">
            <h3>Our <span>Theater</span></h3>
        </div>

        <div class="row mt-5">
            <?php
            // Запит для отримання інформації про фільми та категорії
            $sql = "SELECT theater.*, movies.*, categories.catname
                    FROM theater
                    INNER JOIN movies ON movies.movieid = theater.movieid
                    INNER JOIN categories ON categories.catid = movies.catid
                    ORDER BY theater.theaterid DESC";
            $res  = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0){
                // Відображає кожен запис театру у вигляді картки
                while($data = mysqli_fetch_array($res)){
                    ?>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <div class="member-img">
                                <img src="admin/uploads/<?= $data['image'] ?>" style="height:250px !important; width:250px !important;" alt="">
                                <div class="social">
                                    <!-- Посилання для перегляду трейлера -->
                                    <a href="admin/uploads/<?= $data['trailer'] ?>" target="_blank" class="btn btn-primary" style="width:150px;">Watch Trailer</a>
                                </div>
                            </div>
                            <div class="member-info">
                                <!-- Назва театру -->
                                <h4><?= $data['theater_name'] ?></h4>
                                <!-- Назва фільму та його категорія -->
                                <h6><?= $data['title'] ?> <span><?= $data['catname'] ?></span></h6>
                                <!-- Час показу, дні та дата -->
                                <span><?= $data['timing'] ?> <span><?= $data['days'] ?></span></span>
                                <span><?= $data['date'] ?></span>
                                <!-- Місцезнаходження театру -->
                                <span><?= $data['location'] ?></span>
                                <!-- Ціна квитка -->
                                <h4>Per Ticket: Rs.<?= $data['price'] ?></h4>
                                <!-- Кнопка для бронювання квитків -->
                                <a href="booking.php?id=<?= $data['theaterid'] ?>" target="_blank" class="btn btn-primary"> Book Now </a>
                            </div>
                        </div>
                    </div>



                    <?php
                }
            }


            ?>
        </div>
    </div>
</section>

<?php include('footer.php');  // Додає футер на сторінку ?>



</body>
</html>
