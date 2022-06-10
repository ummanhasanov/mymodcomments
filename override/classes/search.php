<?php

class Search extends SearchCore {

    public static function find($id_lang, $expr, $page_number = 1, $page_size = 1, $order_by = 'position', $order_way = 'desc', $ajax = false,
            $use_cookie = true, Context $context = null) {
// Call parent method
        $find = parent::find($id_lang, $expr, $page_number, $page_size, $order_by,
                        $order_way, $ajax, $use_cookie, $context);
// Return products
        return $find;
    }

}
