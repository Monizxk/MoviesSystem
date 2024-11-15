<?php
// Підключаємо файл з'єднання з базою даних
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фільми</title>
    <script>
        // Додаємо активний клас до елементу навігації для сторінки додавання фільму
        window.addEventListener("load", function () {
            document.querySelector("#nav_add_movie").classList.add("active")
        })
    </script>
</head>
<body>

<?php include('header.php')  // Включаємо заголовок сторінки ?>

<div class="container" style="margin-top: 130px">
    <div class="row">
        <div class="col-lg-6">
            <!-- Форма для додавання нового фільму -->
            <form action="add_movie.php" method="post" enctype="multipart/form-data">

                <!-- Випадаючий список для вибору кіностудії -->
                <div class="form-group mb-4">
                    <select name="catid" class="form-control">
                        <option value="">Вибрати кіностудію</option>

                        <?php
                        // Отримуємо список кіностудій з таблиці `categories`
                        $sql = "SELECT * FROM `categories`";
                        $res  = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res) > 0){
                            // Виводимо кожну кіностудію як опцію у списку
                            while($data = mysqli_fetch_array($res)){
                                ?> <option value="<?=$data['catid']?>"> <?=$data['catname']?> </option> <?php
                            }
                        }else{
                            ?> <option value="">Кіностудії не знайдено</option>  <?php
                        }
                        ?>
                    </select>
                </div>

                <!-- Поле для вводу назви фільму -->
                <div class="form-group mb-4">
                    <input type="text" class="form-control" name="title" value="" placeholder="Назва">
                </div>

                <!-- Поле для вводу опису фільму -->
                <div class="form-group mb-4">
                    <input type="text" class="form-control" name="description" value="" placeholder="Опис">
                </div>

                <!-- Поле для вибору дати виходу фільму -->
                <div class="form-group mb-4">
                    <input type="date" class="form-control" name="releasedate" value="" >
                </div>

                <!-- Поле для завантаження постера фільму -->
                <div class="form-group mb-4">
                    Постер:
                    <input type="file" class="form-control" name="image" value="" >
                </div>

                <!-- Поле для завантаження трейлера фільму -->
                <div class="form-group mb-4">
                    Трейлер:
                    <input type="file" class="form-control" name="trailer" value="" >
                </div>

                <!-- Кнопка для додавання нового фільму -->
                <div class="form-group ">
                    <input type="submit" class="btn btn-primary" value="Додати" name="add">
                </div>

            </form>
        </div>

        <div class="col-lg-6">
            <!-- Таблиця для відображення списку фільмів -->
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Кіностудія</th>
                    <th>Постер</th>
                    <th>Дії</th>
                </tr>

                <?php
                // Запит для отримання фільмів та пов'язаних з ними кіностудій
                $sql = "SELECT movies.*, categories.catname FROM movies INNER JOIN categories ON categories.catid = movies.catid";
                $res  = mysqli_query($con, $sql);
                if(mysqli_num_rows($res) > 0){
                    // Виводимо кожен фільм у рядок таблиці
                    while($data = mysqli_fetch_array($res)){
                        ?>
                        <tr>
                            <td><?= $data['movieid'] ?></td>
                            <td><?= $data['title'] ?></td>
                            <td><?= $data['catname'] ?></td>
                            <td> <img src="uploads/<?= $data['image'] ?>" height="50" width="50" alt=""> </td>
                            <td>
                                <a href="add_movie.php?editid=<?= $data['movieid'] ?>" class="btn btn-primary"> Редагувати</a>
                                <a href="add_movie.php?deleteid=<?= $data['movieid'] ?>" class="btn btn-danger"> Видалити</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo 'Фільмів не знайдено';
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php')  // Включаємо підвал сторінки ?>

</body>
</html>

<?php
// Обробка додавання нового фільму
if(isset($_POST['add'])){
    $catid = $_POST['catid'];
    $title = $_POST['title'];
    $description = substr($_POST['description'], 0, 100);
    $releasedate = $_POST['releasedate'];

    // Обробка файлів для збереження постера та трейлера
    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];
    $trailer = $_FILES['trailer']['name'];
    $tmp_trailer = $_FILES['trailer']['tmp_name'];

    move_uploaded_file($tmp_image , "uploads/$image");
    move_uploaded_file($tmp_trailer , "uploads/$trailer");

    // SQL-запит для додавання фільму в базу даних
    $sql = "INSERT INTO `movies`(`title`, `description`, `releasedate`, `image`, `trailer`, `movie`, `catid`, `rating`) 
    VALUES ('$title','$description','$releasedate','$image','$trailer','','$catid', '')";

    try {
        // Виконання запиту і перевірка результату
        if (mysqli_query($con, $sql)) {
            echo "<script> alert('Фільм додано')</script>";
            echo "<script> window.location.href='add_movie.php' </script>";
        } else {
            echo "<script> alert('Фільм не додано')</script>";
        }
    } catch (Exception $e) {
        echo "<script> alert('Фільм не додано')</script>";
    }
}
?>
