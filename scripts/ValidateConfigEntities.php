<?php

/**
 * Validate config entities
 * Validate dependencies in config entities
 */


function validateConfigEntities() {

  $all_entities = \Drupal::entityTypeManager()->getDefinitions();

  foreach($all_entities as $entity_type){
    if($entity_type->getGroup() == 'configuration'){
      $entity = \Drupal::entityTypeManager()->getStorage($entity_type->id());
      $eis = $entity->loadMultiple();
      foreach($eis as $ei){
        try {
          $result = $ei->calculateDependencies();
          //var_dump($result);
          echo "\n\rEntity: " . $ei->id();
        } catch (Exception $e) {
          echo '\n\r### ERROR ### Caught exception: ',  $e->getMessage(), "\n";
        }
      }
    }
  }

}
//var_dump($all_entities);