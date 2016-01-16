<?php

class mymoduledisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        // views/template/front/display.tpl
        $this->setTemplate('display.tpl');
    }
}
