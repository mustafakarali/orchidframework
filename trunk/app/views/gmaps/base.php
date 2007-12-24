<head>
  <? 
  $map = $app->library->gmap;
  $map->printGoogleJS(); 
  $map->setMapType("satellite");
  ?>
</head>
<body>
<?
$map->addGeoPoint(23.700001,90.389999,"Dhaka");
$map->showMap();

?>
</body>