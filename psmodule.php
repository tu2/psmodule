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
    
    /*
     * @displayForm method displays the configuration form using some of the PS methods
     *
    */
    
    public function displayForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
     
        // Init Fields form array
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Settings'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Configuration value'),
                    'name' => 'PSMODULE_NAME',
                    'size' => 20,
                    'required' => true
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );
        
        /*
         * HelperForm is one of the helper methods along with HelperOptions, HelperList, HelperView and HelperHelpAccess        
         * that enable you to generate standard HTML elements for the back office as well as for module configuration pages
         * $helper->module: requires the instance of the module that will use the form
         * $helper->name_controller: requires the name of the module
         * $helper->token: requires a unique token for the module
         * $helper->currentIndex
         * $helper->default_form_language: requires the default language for the shop
         * $helper->allow_employee_form_lang: requires the default language for the shop
         * $helper->title:
         *
        */
        
        $helper = new HelperForm();
     
        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
     
        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
     
        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
            array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );
     
        // Load current value
        $helper->fields_value['PSMODULE_NAME'] = Configuration::get('PSMODULE_NAME');
        
        // generateForm() method
        return $helper->generateForm($fields_form);
    }
}
