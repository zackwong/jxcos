<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        $data['title'] = '红酒erp管理系统';
        $this->load->view('admin/head', $data);
        $this->load->view('admin/home');
	}

}
