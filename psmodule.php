<?php

/*
 * Example module for PrestaShop e-commerce
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
  
    /*
     * @ The install method. If the module performs actions on installation, 
     * such as checking PS's settings or registering its own settings in the database,     
     * it is highly recommended to change them back, or remove them, when uninstalling the module.
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
  
    /*
     * @ The uninstall method. Make sure it removes all tables inserted into database at install time.
     *
    */
    public function uninstall()
    
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('PSMODULE_NAME')
        )
            return false;
 
        return true;
    
    }
    
    /*
     * @ TODO:
     * - add some functionality through module controlers
     * - display something on the front page making use of 'hooks'
     * - add some style in .css file
     * - create the template files
    */
    
    /*
     * @getContent() method will make a 'Configure' link appear in the back office with the option of oppwning a configuration page
     *
    */
    
    public function getContent()
    {
        $output = null;
 
        if (Tools::isSubmit('submit'.$this->name))
        {
            $ps_module_name = strval(Tools::getValue('PSMODULE_NAME'));
            if (!$ps_module_name
              || empty($ps_module_name)
              || !Validate::isGenericName($ps_module_name))
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            else
            {
                Configuration::updateValue('PSMODULE_NAME', $ps_module_name);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }
        return $output.$this->displayForm();
    }
    
}
