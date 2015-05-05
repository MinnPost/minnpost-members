<?php
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<?php $title = 'Claim Partner Offers'; ?>
<?php include('includes/head.php'); ?>
<?php include('includes/partner-offers/run.php'); ?>    
<?php include('includes/footer.php'); ?>