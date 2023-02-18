<?php

/**
 * Validate config entities
 * Validate dependencies in config entities
 */


function validateConfigEntities() {

  $all_entities = \Drupal::entityTypeManager()->getDefinitions();

  $msg = FALSE;
  $count_entities = count($all_entities);
  $errors = 0;
  $invalid_entities = [];
  foreach($all_entities as $entity_type){
    if($entity_type->getGroup() == 'configuration'){
      $entity = \Drupal::entityTypeManager()->getStorage($entity_type->id());
      $eis = $entity->loadMultiple();
      foreach($eis as $ei){
        try {
          $result = $ei->calculateDependencies();
          //var_dump($result);
          //echo "\n\rEntity: " . $ei->id();

        } catch (Exception $e) {
          $errors ++;
          $invalid_entities[] =  $ei->getEntityTypeId();
          $msg .= $ei->id() . ': \n\r Error: '.  $e->getMessage(). "\n";
        }
      }
    }
  }
   if($msg && $errors){
    print "\n\rNumber of entities validated: " . $count_entities;
    print "\n\rNumber of entities with validation errors: " . $errors . " (". implode(" , ", $invalid_entities) . ")";
    print "\n\rDetails: " . $msg;
   }

}
//var_dump($all_entities);