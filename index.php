<?php require_once('./includes/header.php'); ?>
<?php


require_once('./classes/DB.php');
$db = DB::getInstance();
$customersList = new Customers();
$file1 = new GeoName();
$file1->fetchCountryInfo();

print_r($customersList->uploadCsv());
?>
<div class="container">
    <h1> Call Data Statistical Analysis</h1>
    <hr>

    <!-- Add Form to upload Customers CSV -->
    <?php echo $customersList->uploadForm() ?>


    <hr>
    <?php require_once('./includes/table.php'); ?>

</div>
<?php require_once('./includes/footer.php'); ?>