<?php

class MyModCommentsGetContentController {

    public function renderForm() {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('My Module configuration'),
                    'icon' => 'icon-envelope'
                    ),
                'input' => array(
                    array(
                        'type' => 'switch', 'label' => $this->l('Enable grades:'),
                        'name' => 'enable_grades', 
                        'desc' => $this->l('Enable grades on products.'),
                        'value' => array(
                            array('id' => 'enable_grades_1', 'value' => 1, 'label' => $this->l('Enabled')),
                            array('id' => 'enable_grades_0', 'value' => 0, 'label' => l('Disabled'))
                            ),
                        ),
                    array(
                        'type' => 'switch', 
                        'label' => $this->l('Enable comments:'),
                        'name' => 'enable_comments',
                        'desc' => $this->l('Enable comments on products.'), 
                        'value' => array(
                            array('id' => 'enable_comments_1', 'value' => 1, 'label' => l('Enabled')),
                            array('id' => 'enable_comments_0', 'value' => 0, 'label' => l('Disabled'))
                            ),
                        ),
                    ),
                'submit' => array('title' => $this->l('Save'))
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
