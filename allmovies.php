<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Всі фільми</title>
    <script>
        // Додає клас "active" до навігаційного пункту "nav_movies" при завантаженні сторінки
        window.addEventListener("load", function () {
            document.querySelector("#nav_movies").classList.add("active")
        })
    </script>
</head>
<body>

<?php include('connect.php');  // Підключення до бази даних ?>
<?php include('header.php');  // Додавання заголовка (хедера) на сторінку ?>

<section id="team" class="team section-bg">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <!-- Розділ з фільмами Голлівуду -->
        <div class="section-title">
            <h3>Hollywood <span>Movies</span></h3>
        </div>

        <div class="row mt-5">
            <?php
            // Отримує фільми з категорії Голлівуд (catid = 1)
            $sql = "SELECT movies.*, categories.catname
                    FROM movies
                    INNER JOIN categories ON categories.catid = movies.catid
                    WHERE movies.catid = 1
                    ORDER BY movies.movieid DESC";
            $res  = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0){
                // Відображає кожен фільм у вигляді картки
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
                                <h4><?= $data['title'] ?></h4>
                                <span><?= $data['catname'] ?></span>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            }
            ?>
        </div>

        <!-- Розділ з фільмами Боллівуду -->
        <div class="section-title">
            <h3>Bollywood <span>Movies</span></h3>
        </div>

        <div class="row mt-5">
            <?php
            // Отримує фільми з категорії Боллівуд (catid = 2)
            $sql = "SELECT movies.*, categories.catname
                    FROM movies
                    INNER JOIN categories ON categories.catid = movies.catid
                    WHERE movies.catid = 2
                    ORDER BY movies.movieid DESC";
            $res  = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0){
                // Відображає кожен фільм у вигляді картки
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
                                <h4><?= $data['title'] ?></h4>
                                <span><?= $data['catname'] ?></span>
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
