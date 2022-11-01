<?php
error_reporting(-1);
//Работа с база данных

define("SERVERNAME","localhost");
define("DB_LOGIN", "root");
define("PASSWORD", "");
define("DB_NAME", "new_db");

//$connect = new mysqli(SERVERNAME,DB_LOGIN,PASSWORD, DB_NAME);
//$sql = "UPDATE `heroes` SET `age`=26 WHERE `name`='Chembers'";
//if($connect->query($sql)===true) {
//    echo "record update";
//}else echo "error record";
//$connect->query($sql);
//$connect->close();

$name = $age = $rank = '';
$connect = new mysqli(SERVERNAME,DB_LOGIN,PASSWORD, DB_NAME);
$sql = "SELECT * FROM `heroes`";
$result = $connect->query($sql);
for($user = array(); $row = $result->fetch_assoc(); $user [] = $row);

//print_r($user);

$connect->close();
$last = count($user) -1;
$last_id = $user [$last] ['id'] +1;



if(isset($_POST ['add_heroes'] )) {
    $name = $_POST['name'] ?? '0';
    $age = $_POST['age'] ?? '0';
    $rank = $_POST['rank'] ?? '0';
    $connect = new mysqli(SERVERNAME,DB_LOGIN,PASSWORD, DB_NAME);
    $sql = "INSERT INTO `heroes`(`id`,`name`,`age`,`rank`) VALUES ('$last_id', '$name', '$age', '$rank')";
    $connect->query($sql);
    $connect->close();
    header("Location: /DB.MySql.php");
}

if(isset($_GET ['change'] )) {
    $id = $_GET ['change'] ?? '';
    $name = $user [$id] ['name']?? '';
    $age = $user [$id] ['age']?? '';
    $rank = $user [$id] ['rank']?? '';
    $id_base = $user [$id] ['id']?? '';
}

if(isset($_POST ['edit_heroes'] )) {
    $name = $_POST['name'] ?? '0';
    $age = $_POST['age'] ?? '0';
    $rank = $_POST['rank'] ?? '0';
    $connect = new mysqli(SERVERNAME,DB_LOGIN,PASSWORD, DB_NAME);
    $sql = "UPDATE `heroes` SET `name` = '$name', `age` = '$age', `rank` = '$rank' WHERE `id`='$id_base'";
    $connect->query($sql);
    $connect->close();
    header("Location: /DB.MySql.php");
}

if(isset($_POST ['delete_heroes'] )) {
    $connect = new mysqli(SERVERNAME,DB_LOGIN,PASSWORD, DB_NAME);
    $sql = "DELETE FROM `heroes` WHERE `id` = '$id_base'";
    $connect->query($sql);
    $connect->close();
    header("Location: /DB.MySql.php");
}

?>

<form action="#" method="POST">
    <input type="text" name="name" placeholder="name" id="" value="<?=$name?>">
    <input type="number" name="age" id="" value="<?=$age?>" placeholder="age">
    <input type="number" name="rank" value="<?=$rank?>" id="" placeholder="rank">
    <input type="submit" value="Add heroes" name="add_heroes">
    <?php if(isset($_GET['change'])): ?>
    <input type="submit" value="Edit" name="edit_heroes">
    <input type="submit" value="Delete" name="delete_heroes">
    <?php endif; ?>
</form>

<?php
foreach ($user as $k => $item) {
    echo "<p>$item[id] | $item[name] | age: $item[age] | rank $item[rank] <a href='? change=$k'>Select</a> </p>";
}