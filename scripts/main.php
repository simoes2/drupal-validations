<?php

/*
Main script file
To run a script list script in runn list 
*/

function runScripts($selected_option){
  switch ($selected_option) {
    case "1":
      echo "\n\rRun script to validate Config Entities\n\r";
      include 'ValidateConfigEntities.php';
      validateConfigEntities();
      break;
    case "2":
      echo "\n\rRun script to validate Allowed Formats\n\r";
      include 'allowedFormats.php';
      validateAllowedFormats();
      break;
  }
}

echo "Options:\n\r";
echo "1 - Validate Config Entities\n\r";
echo "2 - Validate allowed html formats used in fields\n\r"; 

if(isset($extra[0])) {
  $selected_option = $extra[0];
  runScripts($selected_option);
}
