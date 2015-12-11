<?php

/*
* Version 1.0.0
*/

if (!defined('_PS_VERSION_'))
	exit;

class PsModule extends Module
{
  public function __construct()
  {
    $this->name = 'psmodule';
    $this->tab = 'front_office_features';
    $this->version = '1.0.0';
    $this->author = 'Firstname Lastname';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 
    parent::__construct();
 
    $this->displayName = $this->l('Ps Module');
    $this->description = $this->l('Description of Ps Module.');
 
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
 
    if (!Configuration::get('PSMODULE_NAME'))      
      $this->warning = $this->l('No name provided');
  }
  /**
    * @ This suppose to be a comment
    */
  
  public function install()
  {
    if (Shop::isFeatureActive())
      Shop::setContext(Shop::CONTEXT_ALL);
 
    if (!parent::install() ||
      !$this->registerHook('leftColumn') ||
      !$this->registerHook('header') ||
      !Configuration::updateValue('PSMODULE_NAME', 'Test')
    )
      return false;
 
    return true;
  }
  
  public function uninstall()
  {
    if (!parent::uninstall() ||
      !Configuration::deleteByName('PSMODULE_NAME')
    )
      return false;
 
    return true;
  }
}
