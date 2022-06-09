<?php

class MyModCommentsCommentsModuleFrontController extends ModuleFrontController {

    public $product;

    public function setMedia() {
        
        // We call the parent method
        parent::setMedia();
        
        // Save the module path in a variable
        $this->path = __PS_BASE_URI__ . 'modules/mymodcomments/';
        
        // Include the module CSS and JS files needed
        $this->context->controller->addCSS($this->path . 'views/css/starrating.css', 'all');
        $this->context->controller->addJS($this->path . 'views/js/star-rating.js');
        $this->context->controller->addCSS($this->path.'views/css/mymodcomments.css', 'all');
        $this->context->controller->addJS($this->path.'views/js/mymodcomments.js');
    }

    public function initContent() {
        parent::initContent();

        $actions_list = array('list' => 'initList');
        $id_product = (int) Tools::getValue('id_product');
        $module_action = Tools::getValue('module_action');

        $this->product = new Product((int) $id_product, false, $this->context->cookie->id_lang);

        if ($id_product > 0 && isset($actions_list[$module_action])) {
            $this->{$actions_list[$module_action]}();
        }
    }

    protected function initList() {
//        Get comments
        $comments = Db::getInstance()->executeS(
                'SELECT * FROM `' . _DB_PREFIX_ . 'mymod_comment` 
                WHERE `id_product` = ' . (int) $this->product->id .
                ' ORDER BY `date_add` DESC');
//        Assign comments and product objects
        $this->context->smarty->assign('comments', $comments);
        $this->context->smarty->assign('product', $this->product);
        $this->setTemplate('list.tpl');
    }

}
