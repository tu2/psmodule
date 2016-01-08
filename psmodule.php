<?php

/*
 * Example module for PrestaShop e-commerce online shop
 * For more info about PrestaShop visit https://www.prestashop.com/en/
 * Module Version 1.0.0
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
     * @ The install() method of our class. If the module performs actions on installation, 
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
     * @getContent() method will make a 'Configure' link appear in the back office with the option of opening a configuration page
     * This method will make use of some of the PS 'tools':
     * Tools::isSubmit() is a PrestaShop-specific method, which checks if the indicated form has been validated
     * Tools:getValue() is a PrestaShop-specific method, which retrieve the content of the POST or GET array 
     * in order to get the value of the specified variable. In this case, we retrieve the value of the PSMODULE_NAME form variable,
     * turn its value into a text string using the strval() method, and stores it in the $ps_module_name PHP variable
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
     * Configuration Page [Back Office]
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
         * that enable you to generate standard HTML elements for the back office as well as for module configuration pages.
         *
         * Example of some of the HelperForm methods:
         * $helper->module = $this; requires the instance of the module that will use the form
         * $helper->name_controller = $this->name; requires the name of the module
         * $helper->token = Tools::getAdminTokenLite('AdminModules'); requires a unique token for the module
         * $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
         * $helper->default_form_language: requires the default language for the shop.
         * $helper->allow_employee_form_lang: requires the default language for the shop.
         * $helper->title = $this->displayName; requires the title for the form.
         * $helper->show_toolbar: requires a boolean value – whether the toolbar is displayed or not
         * $helper->toolbar_scroll: requires a boolean value – whether the toolbar is always visible when scrolling or not
         * $helper->submit_action = 'submit'.$this->name; requires the action attribute for the form's <submit> tag
         * $helper->toolbar_btn: requires the buttons that are displayed in the toolbar. In our example, the "Save" button and the "Back" button
         * $helper->fields_value[]: this is where we can define the value of the named tag
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
