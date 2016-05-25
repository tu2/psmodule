<?php

/*
 * Module Version 1.0.0
*/

class psmoduledisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    
    {
        parent::initContent();
        
        // template disply
        // views/template/front/display.tpl
        $this->setTemplate('display.tpl');
    }
    
    
}
