<?php

require_once 'tokenizer.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function tokenizer_civicrm_config(&$config) {
  _tokenizer_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function tokenizer_civicrm_xmlMenu(&$files) {
  _tokenizer_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function tokenizer_civicrm_install() {
  _tokenizer_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function tokenizer_civicrm_uninstall() {
  _tokenizer_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function tokenizer_civicrm_enable() {
  // continue
  _tokenizer_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function tokenizer_civicrm_disable() {
  // continue
  _tokenizer_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function tokenizer_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _tokenizer_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function tokenizer_civicrm_managed(&$entities) {
  _tokenizer_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function tokenizer_civicrm_caseTypes(&$caseTypes) {
  _tokenizer_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function tokenizer_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _tokenizer_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * buildform
 */
function tokenizer_civicrm_buildForm($formName, &$form) {
  // set buildForm
}

/**
 * pagerun
 */
function tokenizer_civicrm_pageRun(&$page) {
  // set pageRun
}

/**
 * implementation of hook_civicrm_tokens()
 */
function tokenizer_civicrm_tokens(&$tokens) {
  $tokens['ctrl'] = array(
    'ctrl.hello' => 'Token for printing hello world + cid'
  );
}

/**
 * implementation of hook_civicrm_tokenValues()
 */
function tokenizer_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = array(), $context = NULL) {

  // Don't print country in mailing label if country is equal CiviCRM default country.
  if ($context == 'CRM_Contact_Form_Task_Label') {
    // CiviCRM default country
    $result = civicrm_api3('Setting', 'get', array(
      'sequential' => 1,
      'return' => "defaultContactCountry",
    ));
    $default = $result["values"][0]["defaultContactCountry"];
    // Replace tokens for each contact
    foreach ($cids as $cid) {
      // Select 'contact' tokens.
      foreach ($tokens['contact'] as $name) {
        switch ($name) {
          case 'country':
            $country = $values[$cid]['country_id'];
            if ($country == $default) {
              $values[$cid]['country'] = "";
            }
            break;
        }
      }
    }
  }

  // Custom tokens.
  foreach ($cids as $cid) {
    // Select 'ctrl' tokens.
    watchdog('tokenizer', print_r($tokens['ctrl'],true));
    foreach ($tokens['ctrl'] as $name) {
      switch ($name) {
        case 'hello':
          $values[$cid]['ctrl.hello'] = "Hello contact id: $cid";
          break;
      }
    }
  }
}

