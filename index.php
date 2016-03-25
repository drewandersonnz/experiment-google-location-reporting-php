<!DOCTYPE html>
<?php
$config = array_merge(include "./config.php", $_GET);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>experiments.drewanderson.org</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    </head>

    <body>

    <div class="well">
        Please ensure you are currently logged into your google account. This tool does not use your account directly, it just generates download links for the Google Location History Reporting feature.
    </div>

    <div class="drew-year-selector">
        <h1>Choose Year</h1>
<?php
if (! is_numeric($config['year'])) {
    throw new Exception("Invalid year");
}

$years = range(max(2000, $config['year'] - 5), min(gmdate('Y'), $config['year'] + 5));
?>
        <?php foreach ($years as $year) { ?>
            <?php $class = ($year == $config['year']) ? 'btn btn-info' : 'btn btn-default'; ?>
            <a class="<?php print $class; ?>" href="?<?php print http_build_query(array_merge($_GET, array('year' => $year, ))); ?>"><?php print $year; ?></a>
        <?php } ?>
        <a class="<?php print $class; ?>" href="?<?php print http_build_query(array_merge($_GET, array('year' => null, ))); ?>">this year</a>
    </div>


    <div class="drew-download-selector">
        <h1>Choose Downloads</h1>
<?php
if (! is_numeric($config['year'])) {
    throw new Exception("Invalid year");
}

$months = range(12, 1);

// https://maps.google.com/locationhistory/b/0/kml?startTime=1259625600000&endTime=1262304000000
$urlBase = 'https://maps.google.com/locationhistory/b/0/kml';
?>
        <ul>
        <?php foreach ($months as $month) { ?>
            <?php
            // Skip if this is in the future
            if (gmmktime(0, 0, 0, $month, 01, $config['year']) > time()) {
                continue;
            }

            $display = gmdate('F Y', gmmktime(0, 0, 0, $month, 01, $config['year']));
            $urlArray = array(
                'startTime' => gmmktime(0, 0, 0, $month, 01, $config['year']) * 1000,
                'endTime' => gmmktime(0, 0, 0, $month + 1, 01, $config['year']) * 1000,
            );
            ?>
            <li><a class="" href="<?php print $urlBase . '?' . http_build_query($urlArray); ?>"><?php print $display; ?></a></li>
        <?php } ?>
        </ul>
    </div>


    </body>
</html>
