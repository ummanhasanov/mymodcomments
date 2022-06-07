<?php
class MyModCommentsCommentsModuleFrontController extends
ModuleFrontController
{
    public function initContent() {
        parent::initContent();
        $this->setTemplate('list.tpl');
    }
}
