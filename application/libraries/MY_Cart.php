<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

    public function __construct()
    {
        parent::__construct();
        $this->product_name_rules = '\S';
    }
}