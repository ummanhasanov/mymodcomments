<?php

class MyModComment extends ObjectModel {

    public $id_mymod_comment;
    public $id_product;
    public $firstname;
    public $lastname;
    public $email;
    public $grade;
    public $comment;
    public $date_add;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'mymod_comment',
        'primary' => 'id_mymod_comment',
        'multilang' => false,
        'fields' => array(
            'id_product' => array(
                'type' => self:: TYPE_INT, 'validate' => 'isUnsugnedId', 'required' => true),
            'firstname' => array('type' => self:: TYPE_STRING, 'validate' => 'IsName', 'size' => 20),
            'lastname' => array('type' => self:: TYPE_STRING, 'validate' => 'IsName', 'size' => 20),
            'email' => array('type' => self:: TYPE_STRING, 'validate' => 'IsEmail'),
            'grade' => array('type' => self:: TYPE_INT, 'IsUnsignedInt'),
            'comment' => array('type' => self:: TYPE_HTML, 'validate' => 'isCleanHTML'),
            'date_add' => array('type' => self:: TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
        ),
    );

}
