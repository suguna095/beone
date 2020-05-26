<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ProductCategoryList extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
    }
public function category_list()
{
$this->load->view('productcategorylist/category_list');
}
}