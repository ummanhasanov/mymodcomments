<?php

class AdminMyModCommentsController extends ModuleAdminController {

    public function __construct() {
        // Set variables
        $this->table = 'mymod_comment';
        $this->className = 'MyModComment';
        $this->fields_list = array(
            'id_mymod_comment' => array('title' => $this->l('ID'), 'align' =>
                'center', 'width' => 25),
            'firstname' => array('title' => $this->l('Firstname'), 'width' =>
                120),
            'lastname' => array('title' => $this->l('Lastname'), 'width' =>
                140),
            'email' => array('title' => $this->l('E-mail'), 'width' => 150),
            'product_name' => array('title' => $this->l('Product'), 'width' =>
                100, 'filter_key' => 'pl!name'),
            'grade_display' => array('title' => $this->l('Grade'), 'align' =>
                'right', 'width' => 80, 'filter_key' => 'a!grade'),
            'comment' => array('title' => $this->l('Comment'), 'search' =>
                false),
            'date_add' => array('title' => $this->l('Date add'), 'type' =>
                'date'),
        );

        // Enable bootstrap
        $this->bootstrap = true;

        // Call of the parent constructor method
        parent::__construct();

        // Update the SQL request of the HelperList
        $this->_select = "pl.`name` as product_name, CONCAT(a.`grade`, '/5') as
                grade_display";
        $this->_join = 'LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl 
                ON (pl.`id_product` = a.`id_product` AND pl. `id_lang` = 
                ' . (int) $this->context->language->id . ')';

        // Add actions
        $this->addRowAction('view');
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        // Add bulk actions
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Would you like to delete the selected
            items?'),),
            // You can add you own action on bulk
            'myaction' => array(
                'text' => $this->l('My Action'),
                'confirm' => $this->l('Are you sure?'),
            )
        );

        // Define meta and toolbar title
        $this->meta_title = $this->l('Comments on product');
        if (Tools::getIsset('viewmymod_comment')) {
            $this->meta_title = $this->l('View Comment') . '#' .
                    Tools::getValue('id_mymod_comment');
        }

        $this->toolbar_title[] = $this->meta_title;
    }

    protected function processBulkMyAction() {
        Tools::dieObject($this->boxes);
    }

    public function renderView() {
        // Build delete link
        $admin_delete_link = $this->context->link->getAdminLink(
                        'AdminMyMOdComments') . '&deletemymod_comment&id_mymod_comment=' . (int) $this->object->id;

        // Add delete shortcut button to toolbar
        $this->page_header_toolbar_btn['delete'] = array(
            'href' => $admin_delete_link,
            'desc' => $this->l('Delete it'),
            'icon' => 'process-icon-delete',
            'js' => "return confirm('" . $this->l('Are you sure you want to delete it ?') . "');",
        );

        $this->object->loadProductName();
        $tpl = $this->context->smarty->createTemplate(
                dirname(__FILE__) .
                '/../../views/templates/admin/view.tpl');
        $tpl->assign('mymodcomment', $this->object);

        return $tpl->fetch();
    }

}
