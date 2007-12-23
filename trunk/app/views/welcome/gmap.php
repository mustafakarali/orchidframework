<?
$map = $app->library->gmap;
//$map->setMapType("satellite");
?>
<head>
  <? $map->printGoogleJS(); ?>
</head>
<body>
<?


$map->addGeoPoint(38.517885,-122.18462,"1013 Headlands Dr., Napa, Ca");
$map->showMap();

?>
</body>

