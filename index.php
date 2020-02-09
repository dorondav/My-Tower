<?php require_once('./includes/header.php'); ?>
<?php
// spl_autoload_register(function ($class) {
//     require_once('classes/' . $class . '.php');
// });
require_once('./classes/DB.php');
$db = DB::getInstance();
$file1 = new GeoName();
$file1->fetchCountryInfo();
?>
<div class="container">
    <h1> Call Data Statistical Analysis</h1>
    <hr>
    <?php require_once('./includes/csvForm.php'); ?>
    <hr>
    <?php require_once('./includes/table.php'); ?>

</div>
<?php require_once('./includes/footer.php'); ?>