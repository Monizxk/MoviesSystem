<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>

<!-- Включення файлу з заголовком сторінки -->
<?php include('header.php') ?>
<!-- Підключення до бази даних -->
<?php include('connect.php')?>

<script>
    // Додає клас 'active' до елемента з ID 'nav_main', щоб позначити активний розділ меню
    document.querySelector("#nav_main").classList.add("active")
</script>

<section id="team" class="team section-bg" style="padding-top: 130px">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <!-- Заголовок секції -->
        <div class="section-title">
            <h3>Наші <span>Фільми</span></h3>
        </div>

        <!-- Форма для пошуку фільмів -->
        <form action="index.php" method="post">
            <div class="row justify-content-center">

                <!-- Поле для введення назви фільму -->
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="movie_search" placeholder="Пошук за назвою">
                    </div>
                </div>

                <!-- Випадаючий список для вибору категорії -->
                <div class="col-lg-2 col-md-6">
                    <div class="form-group">
                        <select name="catid" class="form-control">
                            <option value="">Кіностудія</option>
                            <?php
                            // SQL-запит для отримання списку категорій з бази даних
                            $sql = "SELECT * FROM `categories`";
                            $res = mysqli_query($con, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                // Відображення категорій у випадаючому списку
                                while ($data = mysqli_fetch_array($res)) {
                                    ?>
                                    <option value="<?= $data['catid'] ?>"> <?= $data['catname'] ?> </option> <?php
                                }
                            } else {
                                // Повідомлення, якщо категорій не знайдено
                                ?>
                                <option value="">Кіностудія не знайдена</option>  <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Кнопка для запуску пошуку -->
                <div class="col-lg-1 col-md-6">
                    <div class="form-group">
                        <input type="submit" name="btnSearch" value="Пошук" class="btn btn-primary">
                    </div>
                </div>

            </div>
        </form>

        <!-- Відображення результатів пошуку -->
        <div class="row mt-5">
            <?php
            // Перевірка, чи було натиснуто кнопку 'Пошук'
            if (isset($_POST['btnSearch'])) {
                $movie_search = $_POST['movie_search']; // Отримання даних з поля введення
                $catid = $_POST['catid']; // Отримання вибраної категорії

                // Формування SQL-запиту для пошуку фільмів
                $sql = "SELECT movies.*, categories.catname
                        FROM movies
                        INNER JOIN categories ON categories.catid = movies.catid
                        WHERE movies.title LIKE '%$movie_search%'";

                // Додання умов фільтрації за категорією, якщо вона вибрана
                if ($catid != "") {
                    $sql .= " AND movies.catid = '$catid'";
                }

                $res = mysqli_query($con, $sql);
                // Перевірка наявності результатів пошуку
                if (mysqli_num_rows($res) > 0) {
                    // Відображення кожного знайденого фільму
                    while ($data = mysqli_fetch_array($res)) {
                        ?>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate"
                             data-aos="fade-up" data-aos-delay="100">
                            <div class="member">
                                <div class="member-img">
                                    <!-- Відображення зображення фільму -->
                                    <img src="uploads/<?= $data['image'] ?>"
                                         style="height:250px !important; width:250px !important;" alt="">
                                    <div class="social">
                                        <!-- Посилання для перегляду трейлера -->
                                        <a href="uploads/<?= $data['trailer'] ?>" target="_blank"
                                           class="btn btn-primary" style="width:150px;">Watch Trailer</a>
                                    </div>
                                </div>
                                <div class="member-info">
                                    <!-- Відображення назви фільму та категорії -->
                                    <h4><?= $data['title'] ?></h4>
                                    <span><?= $data['catname'] ?></span>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
            } else {
                // SQL-запит для відображення всіх фільмів за замовчуванням
                $sql = "SELECT movies.*, categories.catname
                        FROM movies
                        INNER JOIN categories ON categories.catid = movies.catid
                        ORDER BY movies.movieid DESC";
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {
                    // Відображення кожного фільму
                    while ($data = mysqli_fetch_array($res)) {
                        ?>

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate"
                             data-aos="fade-up" data-aos-delay="100">
                            <div class="member">
                                <div class="member-img">
                                    <!-- Відображення зображення фільму -->
                                    <img src="uploads/<?= $data['image'] ?>"
                                         style="height:250px !important; width:250px !important;" alt="">
                                    <div class="social">
                                        <?php
                                        // Перевірка наявності трейлера і його відображення
                                        $trailer = $data["trailer"];
                                        if ($data['trailer'] != "") {
                                            echo "<a href='uploads/$trailer' target='_blank'
                                                  class='btn btn-primary' style='width:150px;'>Трейлер</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="member-info">
                                    <!-- Відображення назви фільму та категорії -->
                                    <h4><?= $data['title'] ?></h4>
                                    <span><?= $data['catname'] ?></span>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Включення нижньої частини сторінки -->
<?php include('footer.php') ?>

</body>
</html>
