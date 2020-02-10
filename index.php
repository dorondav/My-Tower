<?php require_once('./includes/header.php'); ?>
<?php


require_once('./classes/DB.php');
require_once('./classes/Table.php');

$db = DB::getInstance();
$customersList = new Customers();
$continent = new Continent();
// print_r($continent->customerLocation());
print_r(Continent::customerLocation());
$file1 = new GeoName();
$file1->fetchCountryInfo();
$table = new Table($continent);
$customersList->uploadCsv();

?>
<div class="container">
    <h1> Call Data Statistical Analysis</h1>
    <hr>

    <!-- Add Form to upload Customers CSV -->
    <?php echo $customersList->setForm() ?>


    <hr>
    <?php require_once('./includes/table.php'); ?>

</div>
<?php require_once('./includes/footer.php'); ?>