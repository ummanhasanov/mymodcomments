<?php

require_once(dirname(__FILE__) . '/classes/MyModComment.php');

class MyModComments extends Module {

    public function __construct() {
        $this->name = 'mymodcomments';
        $this->tab = 'front_office_features';
        $this->version = '0.2';
        $this->author = 'Umman Hasanov';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('My Module Of Product Comments');
        $this->description = $this->l('With this module your customers will be able to grade and comments your products');
    }

    public function install() {
        // Call install parent method
        if (!parent::install()) {
            return false;
        }
        // Execute module install SQL statements
        $sql_file = dirname(__FILE__) . '/install/install.sql';
        if (!$this->loadSQLFile($sql_file)) {
            return false;
        }


        // Register hooks
        if (!$this->registerHook('displayProductTabContent') ||
                !$this->registerHook('displayBackOfficeHeader') ||
                !$this->registerHook('ModuleRoutes')) {
            return false;
        }

        // Preset configuration values
        Configuration::updateValue('MYMOD_GRADES', '1');
        Configuration::updateValue('MYMOD_COMMENTS', '1');

        // All went well!
        return true;
    }

    public function uninstall() {
        // Call uninstall parent method
        if (!parent::uninstall()) {
            return false;
        }
        // Execute module uninstall SQL statements
//        $sql_file = dirname(__FILE__) . '/insatll/uninstall.sql';
//        if (!$this->loadSQLFile($sql_file)) {
//            return false;
//        }
        // Delete configuration values
        Configuration::deleteByName('MYMOD_GRADES');
        Configuration::deleteByName('MYMOD_COMMENTS');

        // All went well!
        return true;
    }

    public function loadSQLFile($sql_file) {
        // Get install SQL file content
        $sql_content = file_get_contents($sql_file);

        // Replace prefix and store SQL command in array
        $sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
        $sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);

        // Execute each SQL statement
        $result = true;
        foreach ($sql_requests as $request) {
            if (!empty($request)) {
                $result &= Db::getInstance()->execute(trim($request));
            } return $result;
        }
    }

    public function onClickOption($type, $href = false) {
        $confirm_reset = $this->l('Reseting this module will delete all comments from your database, are you sure you want to reset it?');

        $reset_callback = "return mymodcomments_reset('" . addslashes($confirm_reset) . "');";
        $matchType = array(
            'reset' => $reset_callback,
            'delete' => "return confirm('Confirm delete?')",
        );
        if (isset($matchType[$type])) {
            return $matchType[$type];
        }
        return '';
    }

    public function hookDisplayProductTabContent($params) {
        $this->processProductTabContent();
        $this->assignProductTabContent();
        return $this->display(__FILE__, 'displayProductTabContent.tpl');
    }

    public function processConfiguration() {
        if (Tools::isSubmit('mymod_pc_form')) {
            $enable_grades = Tools::getValue('enable_grades');
            $enable_comments = Tools::getValue('enable_comments');
            Configuration::updateValue('MYMOD_GRADES', $enable_grades);
            Configuration::updateValue('MYMOD_COMMENTS', $enable_comments);
            $this->context->smarty->assign('confirmation', 'ok');
        }
    }


    public function getContent() {
        $this->processConfiguration();
        return $this->display(__FILE__, 'getContent.tpl');
    }

    public function processProductTabContent() {
        if (Tools::isSubmit('mymod_pc_submit_comment')) {
            $id_product = Tools::getValue('id_product');
            $firstname = Tools::getValue('firstname');
            $lastname = Tools::getValue('lastname');
            $email = Tools::getValue('email');
            $grade = Tools::getValue('grade');
            $comment = Tools::getValue('comment');
//            $insert = array(
//                'id_product' => (int) $id_product,
//                'firstname' => pSQL($firstname),
//                'lastname' => pSQL($lastname),
//                'email' => pSQL($email),
//                'grade' => (int) $grade,
//                'comment' => pSQL($comment),
//                'date_add' => date('Y-m-d  H:i:s'),
//            );
//            Db::getInstance()->insert('mymod_comment', $insert);
            if (!Validate::isName($firstname) || !Validate::isName($lastname) || !Validate::isEmail($email)) {
                $this->context->smarty->assign('new_comment_posted', 'error');
                return false;
            }
            $MyModComment = new MyModComment();
            $MyModComment->id_product = (int) $id_product;
            $MyModComment->firstname = $firstname;
            $MyModComment->lastname = $lastname;
            $MyModComment->email = $email;
            $MyModComment->grade = (int) $grade;
            $MyModComment->comment = nl2br($comment);
            $MyModComment->add();

            $this->context->smarty->assign('new_comment_posted', 'true');
        }
    }

    public function assignProductTabContent() {
        $enable_grades = Configuration::get('MYMOD_GRADES');
        $enable_comments = Configuration::get('MYMOD_COMMENTS');

        $id_product = Tools::getValue('id_product');
        $comments = MyModComment::getProductComments($id_product, 0, 3);
        $this->context->controller->addCSS($this->_path . 'views/css/mymodcomments.css', 'all');
        $this->context->controller->addJS($this->_path . 'views/js/mymodcomments.js');
        $this->context->controller->addJQueryUI('ui.slider');
        $this->context->controller->addCSS($this->_path . 'views/css/star-rating.css', 'all');
        $this->context->controller->addJS($this->_path . 'views/js/star-rating.js');

        $this->context->smarty->assign('enable_grades', $enable_grades);
        $this->context->smarty->assign('enable_comments', $enable_comments);
        $this->context->smarty->assign('comments', $comments);
        $product = new Product((int) $id_product, false, $this->context->cookie->id_lang);
        $this->context->smarty->assign('product', $product);
    }

    public function hookDisplayBackOfficeHeader($params) {

// If we are not on section modules, we do not add JS file
        if (Tools::getValue('controller') != 'AdminModules') {
            return '';
        }

// Assign module mymodcomments base dir
        $this->context->smarty->assign('pc_base_dir', __PS_BASE_URI__ . 'modules/' . $this->name . '/');

// Display template
        return $this->display(__FILE__, 'displayBackOfficeHeader.tpl');
    }

    public function hookModuleRoutes() {
        return array(
            'module-mymodcomments-comments' => array(
                'controller' => 'coments',
                'rule' => 'product-comments{/:module_action}{/:product_rewrite}
                {/:id_product}/page{/:page}', 'keywords' => array(
                    'id_product' => array(
                        'regexp' => '[\d]+',
                        'param' => 'id_product'),
                    'page' => array(
                        'regexp' => '[\d]+',
                        'param' => 'page'),
                    'module_action' => array(
                        'regexp' => '[\w]+',
                        'param' => 'module_action'),
                    'params' => array('fc' => 'module', 'module' => 'mymodcomments', 'controller' => 'comments'),
                    'product_rewrite' => array('regexp' => '[\w-_]+', 'param' => 'product_rewrite')
                )
            )
        );
    }

}
