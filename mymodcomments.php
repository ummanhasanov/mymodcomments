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

    public function getHookController($hook_name) {
        //        Include the controller file
        require_once (dirname(__FILE__) . '/controllers/hook/' . $hook_name . '.php');

        //        Build the controller name dinamically
        $controller_name = $this->name . $hook_name . 'Controller';

        //        Instantiate controller
        $controller = new $controller_name($this, __FILE__, $this->_path);

        //        Return the controller
        return $controller;
    }

    public function hookDisplayProductTabContent($params) {
        $controller = $this->getHookController('displayProductTabContent');
        return $controller->run($params);
    }

    public function hookDisplayBackOfficeHeader($params) {
        $controller = $this->getHookController('displayBackOfficeHeader');
        return $controller->run($params);
    }

    public function hookModulesRoutes() {
        $controller = $this->getHookController('modulesRoutes');
        return $controller->run();
    }

    public function getContent() {
        $controller = $this->getHookController('getContent');
        return $controller->run();
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



    public function renderForm() {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('My Module configuration'),
                    'icon' => 'icon-envelope'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable grades:'),
                        'name' => 'enable_grades',
                        'desc' => $this->l('Enable grades on products.'),
                        'values' => array(
                            array('id' => 'enable_grades_1', 'value' => 1, 'label' => $this->l('Enabled')),
                            array('id' => 'enable_grades_0', 'value' => 0, 'label' => $this->l('Disabled'))
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable comments:'),
                        'name' => 'enable_comments',
                        'desc' => $this->l('Enable comments on products.'),
                        'values' => array(
                            array('id' => 'enable_comments_1', 'value' => 1, 'label' => $this->l('Enabled')),
                            array('id' => 'enable_comments_0', 'value' => 0, 'label' => $this->l('Disabled'))
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->table = 'mymodcomments';
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int) Configuration::get('PS_BO_ALLOW_EMPLOYEE_LANG');
        $helper->submit_action = 'mymod_pc_form';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules',
                        false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => array(
                'enable_grades' => Tools::getValue('enable_grades',
                        Configuration::get('MYMOD_GRADES')),
                'enable_comments' => Tools::getValue('enable_comments',
                        Configuration::get('MYMOD_COMMENTS')),
            ),
            'languages' => $this->context->controller->getLanguages()
        );

        return $helper->generateForm(array($fields_form));
    }

}
