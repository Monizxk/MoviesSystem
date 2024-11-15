<?php
include('connect.php');
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кіностудії</title>
    <script>
        // Додає активний клас для кнопки навігації "Кіностудії" при завантаженні сторінки
        window.addEventListener("load", function () {
            document.querySelector("#nav_category").classList.add("active");
        });
    </script>
</head>
<body>

<?php include('header.php') ?>

<?php
// Перевірка на редагування запису, якщо `editid` є в URL
if(isset($_GET['editid'])){
    $editid = $_GET['editid'];
    $sql = "SELECT * FROM `categories` WHERE catid = '$editid'";
    $res = mysqli_query($con, $sql);
    $editdata = mysqli_fetch_array($res);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <form action="categories.php" method="post">
                    <!-- Приховане поле для передачі ID категорії -->
                    <input type="hidden" class="form-control" value="<?=$editdata['catid']?>" name="catid">
                    <div class="form-group mb-4">
                        <!-- Поле для редагування назви кіностудії -->
                        <input type="text" class="form-control" name="catname" value="<?=$editdata['catname']?>" placeholder="Введіть кіностудію">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="Оновити" name="update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
} else {  // Форма для додавання нової кіностудії
    ?>

    <div class="container" style="margin-top: 130px">
        <div class="row">
            <div class="col-lg-6">
                <form action="categories.php" method="post">
                    <div class="form-group mb-4">
                        <!-- Поле для введення нової назви кіностудії -->
                        <input type="text" class="form-control" name="catname" placeholder="Введіть назву кіностудії">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Додати" name="add">
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <!-- Відображення списку кіностудій -->
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Дії</th>
                    </tr>

                    <?php
                    $sql = "SELECT * FROM `categories`";
                    $res = mysqli_query($con, $sql);
                    if(mysqli_num_rows($res) > 0){
                        while($data = mysqli_fetch_array($res)){
                            ?>
                            <tr>
                                <td><?= $data['catid'] ?></td>
                                <td><?= $data['catname'] ?></td>
                                <td>
                                    <!-- Кнопки для редагування та видалення кіностудій -->
                                    <a href="categories.php?editid=<?= $data['catid'] ?>" class="btn btn-primary">Редагувати</a>
                                    <a href="categories.php?deleteid=<?= $data['catid'] ?>" class="btn btn-danger">Видалити</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="3">Кіностудія не знайдена</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <?php
}
include('footer.php');
?>

</body>
</html>

<?php
// Додавання нової кіностудії
if(isset($_POST['add'])){
    $name = $_POST['catname'];
    $sql = "INSERT INTO `categories`(`catname`) VALUES ('$name')";

    // Перевірка на існування кіностудії з такою ж назвою
    if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM categories WHERE catname LIKE '$name'")) > 0) {
        echo "<script> alert('Кіностудія вже існує')</script>";
        return;
    }

    if(mysqli_query($con, $sql)){
        echo "<script> alert('Кіностудія додана')</script>";
        echo "<script> window.location.href='categories.php' </script>";
    } else {
        echo "<script> alert('Кіностудія не додана')</script>";
    }
}

// Оновлення інформації про кіностудію
if(isset($_POST['update'])){
    $catid = $_POST['catid'];
    $name = $_POST['catname'];

    $sql = "UPDATE `categories` SET `catname`='$name' WHERE catid = '$catid'";

    // Перевірка на існування кіностудії з такою ж назвою
    if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM categories WHERE catname LIKE '$name'")) > 0) {
        echo "<script> alert('Кіностудія з цим іменем вже існує')</script>";
        return;
    }

    if(mysqli_query($con, $sql)){
        echo "<script> alert('Кіностудія оновлена')</script>";
        echo "<script> window.location.href='categories.php' </script>";
    } else {
        echo "<script> alert('Кіностудія не оновлена')</script>";
    }
}

// Видалення кіностудії
if(isset($_GET['deleteid'])){
    $deleteid = $_GET['deleteid'];
    $sql = "DELETE FROM `categories` WHERE catid = '$deleteid'";

    try {
        if (mysqli_query($con, $sql)) {
            echo "<script> alert('Кіностудія видалена')</script>";
            echo "<script> window.location.href='categories.php' </script>";
        } else {
            echo "<script> alert('Кіностудія не видалена')</script>";
        }
    } catch (Exception $e) {
        echo "<script> alert('Не вдалося видалити Кіностудію')</script>";
    }
}
?>
