<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->data['controller_url'] = "admin/report/";
    }

    public function index()
    {
        $this->config->load('wine_erp');
        $this->data['operators'] = $this->config->item('operators');
        $this->data['order_type'] = $this->config->item('order_type');

        $month = $this->input->get_post('month') ? $this->input->get_post('month') : date('m');
        $year = $this->input->get_post('year') ? $this->input->get_post('year') : date('Y');
        $this->data['biller'] = $biller = $this->input->get_post('biller');

        $this->db->start_cache();
        if($month && $year){
            $this->db->where("date_format(o.datetime,'%Y-%m') = '".trans_date_format($year.'-'.$month, "Y-m")."'");
            $this->data['month'] = $month;
            $this->data['year'] = $year;
        }elseif ($year) {
            $this->db->where('year(o.datetime) = '.$year);
            $this->data['year'] = $year;
        }

        if($biller){
            $this->db->where('biller', $biller);
        }

        $this->db->select('i.pid,i.pname,i.price');
        $this->db->select_sum('i.qty', 'total_qty');
        $this->db->join('order_items as i', 'i.oid=o.id','left');
        $this->db->group_by('i.pid');
        $this->db->stop_cache();

        $this->db->where('o.type', 1);
        $data_type1 = $this->db->get('order as o')->result_array();

        $this->db->where('o.type', 4);
        $data_type4 = $this->db->get('order as o')->result_array();
        
        $this->data['total_price_type1'] = $this->data['total_price_type4'] = 0;
        foreach ($data_type1 as $key => $item) {
            $this->data['total_price_type1'] += $item['total_qty']*$item['price'];
        }
        foreach ($data_type4 as $key => $item) {
            $this->data['total_price_type4'] += $item['total_qty']*$item['price'];
        }
        //取出当前面数据

        $this->data['title'] = '销售统计与订单管理';
        $this->data['rs_type1'] = $data_type1;
        $this->data['rs_type4'] = $data_type4;

        $this->load->view('admin_report/list', $this->data);
    }
    
}
