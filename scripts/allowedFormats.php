<?php


// Check if allowed formats are correct for each field;
/*
$entity_type = 'node';
$field_name = 'field_title';
$my_bundle = 'fc_teaser';
*/

function validateAllowedFormats() {

  $entity_types = ['node', 'paragraph'];

  $incorrect_fields = [];

  foreach($entity_types as $entity_type){
    $bundles = \Drupal::service('entity_type.bundle.info')->getBundleInfo($entity_type);
    foreach($bundles as $key => $bundle){
      $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions($entity_type, $key);
      foreach($fields as $field_config) {
        if (in_array($field_config->getType(), _allowed_formats_field_types())) {
          $formats = $field_config->getSetting('allowed_formats');
            $formats_string = "";
            $correct = "OK";
            if(is_array($formats) && count($formats)){
            
              $formats_string = implode(", ", $formats);
            }
            $field_id = $entity_type . "." . $key . "." . $field_config->getName();
            
        // if($key == $my_bundle &&  $field_config->getName() == 'field_teaser_title'){
          // $allowed_formats = ['type_d'];
            $allowed_formats = fieldHasCorrectFormats($field_id, $formats);
            if(is_array($allowed_formats)){
              $correct = "NOT OK";
              $incorrect_fields[] = "" . $field_id . " : " . $formats_string . "\t [ " . $correct . " ]\n\r";
          //   saveAllowedFormats($field_config, $allowed_formats);
            }
          // echo "\n\r" . $field_id . " : " . $formats_string . "\t [ " . $correct . " ]";
        //}
        }
      }
    }
  }
  echo "List of fields with ncorrect formats:\n\r";
  foreach($incorrect_fields as $incorrect_field){
    echo $incorrect_field;
  }
}

function fieldHasCorrectFormats($field_id, $formats){
  $field_allowed_formats = getAllowedFormatsByField($field_id);
  if(empty($field_allowed_formats[0])){
    return FALSE;
  }
  if(($formats == $field_allowed_formats)){
    return True;
  }
  return $field_allowed_formats;
 
}

function saveAllowedFormats($field_config, $allowed_formats){
  $field_config->setSetting('allowed_formats', $allowed_formats);
  $res = $field_config->save();
  echo $res;
}

function getAllowedFormatsByField($field_id) {
  $fields_allowed_formats = [
    "node.news_page.field_title" => ['type_a','plain_text'],
    "node.overview_page.field_title" => ['type_a','plain_text'],
    "node.page.field_amp_text" => [''],
    "node.page.field_title" => ['type_a','plain_text'],
    "node.rubens_rubin.field_title" => ['type_a','plain_text'],
    "node.subject_of_study.body" => [''],
    "node.subject_of_study.field_amp_text" => [''],
    "node.subject_of_study.field_s_course_content" => [''],
    "node.teaser.field_amp_text" => [''],
    "node.teaser.field_title" => ['type_a','plain_text'],
    "paragraph.accordion_box_download.field_text_formatted_long" => ['type_c'],
    "paragraph.accordion_box_info.field_text_formatted_long" => ['type_e'],
    "paragraph.action_area.field_action_area_text_2" => [''],
    "paragraph.action_area.field_text" => ['type_c'],
    "paragraph.circle.field_number" => ['type_c'],
    "paragraph.circle.field_text_above" => ['type_c'],
    "paragraph.circle.field_text_under" => ['type_c'],
    "paragraph.fc_teaser.field_teaser_subline" => ['type_a','type_e'],
    "paragraph.fc_teaser.field_teaser_subline_en" => [''],
    "paragraph.fc_teaser.field_teaser_title" => ['type_e'],
    "paragraph.fc_teaser.field_teaser_title_en" => [''],
    "paragraph.fc_teaser.field_text_formatted_long" => ['type_b'],
    "paragraph.fc_teaser.field_text_formatted_long_en" => [''],
    "paragraph.headline.field_headline" => ['type_a'],
    "paragraph.headline.field_subline" => ['type_a'],
    "paragraph.leading.field_text" => ['type_a'],
    "paragraph.leading.field_topline" => ['type_a'],
    "paragraph.logo.field_text_formatted_long" => ['type_c'],
    "paragraph.quote.field_text_formatted_long" => ['type_c'],
    "paragraph.sc_bottom_quote.field_text_formatted_long" => ['type_c'],
    "paragraph.sc_top_quote.field_text_formatted_long" => ['type_c'],
    "paragraph.study_subjects_list.field_text" => [''],
    "paragraph.teaser.field_teaser_text_1" => ['type_b'],
    "paragraph.teaser.field_teaser_text_2" => ['type_b'],
    "paragraph.teaser.field_teaser_text_3" => ['type_b'],
    "paragraph.text.field_text_formatted_long" => ['type_e'],
    "paragraph.text_sidebar.field_text_formatted_long" => ['type_d']
  ];
  if(isset($fields_allowed_formats[$field_id])){
    return $fields_allowed_formats[$field_id];
  }
}

