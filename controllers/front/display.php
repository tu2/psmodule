<?php

class mymoduledisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        
        $this->context->smarty->assign(
                array(
                    'page_wellcome_message' => $this->l('Wellcome to my shop')
                )
            );
        // views/template/front/display.tpl
        $this->setTemplate('display.tpl');
    }
}
