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
            'grade' => array('title' => $this->l('Grade'), 'align' =>
                'right', 'width' => 80),
            'comment' => array('title' => $this->l('Comment'), 'search' =>
                false),
            'date_add' => array('title' => $this->l('Date add'), 'type' =>
                'date'),
        );
        // Enable bootstrap
        $this->bootstrap = true;
        // Call of the parent constructor method
        parent::__construct();
    }

}
