<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/product
     *  - or -
     *      http://example.com/index.php/product/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/product/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();

        $this->general_mdl->setTable('products');

        $this->load->model('dx_auth/users', 'users');
        $this->load->model('dx_auth/user_profile', 'profile');

        $this->data['controller_url'] = "admin/product/";
    }

    public function index()
    {        
        $product_data = array();

        $this->data['q'] = $q = $this->input->get_post('q');
        // $this->data['start'] = $start = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
        // $this->data['pageSize'] = $pageSize = $this->input->get_post('pageSize') ? $this->input->get_post('pageSize') : 20;

        $like = array();

        if($q){
            $like['name'] = $q;
        }

        //查询数据的总量,计算出页数
        // $query = $this->general_mdl->get_query_or_like();
        // $this->data['total'] = $query->num_rows();
        // $page = ceil($query->num_rows()/$pageSize);
        // $this->data['page'] = $page;

        //取出当前面数据
        // $query = $this->general_mdl->get_query_or_like($like, array(), $start-1, $pageSize);
        $query = $this->general_mdl->get_query_or_like($like, array());
        $product_data = $query->result_array();
        // $this->data['current_page'] = $start;

        // $prev_link = $this->data['controller_url'].'?page='.($start == 1 ? $start : $start-1);
        // $prev_link .= $q ? '&q='.$q : '';

        // $next_link = $this->data['controller_url'].'?page='.($start == $page ? $start : $start+1);
        // $next_link .= $q ? '&q='.$q : '';

        // $this->data['prev_link'] = $prev_link;
        // $this->data['next_link'] = $next_link;

        // $page_link = array();
        // for ($i=1; $i <= $page; $i++){
        //     $page_link[$i] = $this->data['controller_url'].'?page='.$i;
        //     $page_link[$i] .= $q ? '&q='.$q : '';
        // }
        // $this->data['page_links'] = $page_link;

        $this->data['title'] = '产品管理';
        $this->data['result'] = $product_data;

        $this->load->view('admin_product/list', $this->data);
    }

    //添加
    public function add()
    {
        $this->load->view('admin_product/add', $this->data);
    }

    //添加保存
    public function add_save()
    {
        $data = $this->input->post(NULL, TRUE);

        if($product_id = $this->general_mdl->create($data))
        {
            $response['status'] = "y";
            $response['info'] = "添加成功";
        }else{
            $response['status'] = "n";
            $response['info'] = "添加失败";
        }

        echo json_encode($response);
    }

    //修改
    public function edit()
    {
        $this->data['id'] = $this->input->post('id');

        $query = $this->general_mdl->get_query_by_where(array('id' => $this->data['id']));
        $row = $query->row_array();

        $this->data['row'] = $row;

        $this->load->view('admin_product/edit', $this->data);
    }

    //修改保存
    public function edit_save()
    {
        $data = $this->input->post(NULL, TRUE);
        $id = $data['id'];
        unset($data['id']);
        $isUpdated = $this->general_mdl->update(array('id'=>$id),$data);

        if($isUpdated){
            $response['status'] = "y";
            $response['info'] = "修改成功";
        }else{
            $response['status'] = "n";
            $response['info'] = "修改完成";
        }

        echo json_encode($response);
    }

    //删除
    public function del()
    {
        $id = $this->input->post('id');

        $response['success'] = false;
 
        $this->general_mdl->delete_by_id($id);
        $response['success'] = true;

        echo json_encode($response);
    }

    //产品库存检查
    public function stock_check($pid)
    {
        $qty = $this->input->post('param');

        $query = $this->general_mdl->get_fields(array('id' => $pid), 'stock');
        $stock = $query->row()->stock;

        if($stock >= $qty){
            $data['status'] = "y";
            $data['info'] = "产品库存充足";
        }else{
            $data['status'] = "n";
            $data['info'] = "产品现存:".$stock."支";

        }
        echo json_encode($data);
    }

    //入库页面
    public function stock_ctrl()
    {
        $this->config->load('wine_erp');
        $this->data['operators'] = $this->config->item('operators');

        $this->data['id'] = $this->input->post('id');
        $this->data['name'] = $this->input->post('name');
        $this->data['stock'] = $this->input->post('stock');
        $this->load->view('admin_product/stock_ctrl', $this->data);
    }

    //入库
    public function stock_save()
    {
        $stock = abs($this->input->post('stock'));
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $operator = $this->input->post('operator');
        $remarks = $this->input->post('remarks');
      
        $isUpdated = $this->general_mdl->field_arith('stock', $stock, array('id'=>$id));

        if($isUpdated){
            $response['status'] = "y";
            $response['info'] = "操作成功";

            //库存记录
            $tmp = '%s %s->%s支';
            $default_remarks = sprintf(
                $tmp, 
                $name, $stock > 0 ? '入库' : '出库', 
                abs($stock)
            );
            $log['pid'] = $id;
            $log['operator'] = $operator;
            $log['remarks'] = $default_remarks."<br>".$remarks;
            $log['datetime'] = date('Y-m-d H:i:s');
            $this->db->insert('stock_log', $log);

        }else{
            $response['status'] = "n";
            $response['info'] = "操作失败";
        }

        echo json_encode($response);
    }

    //入库记录
    public function stock_log()
    {        
        $this->config->load('wine_erp');
        $this->data['operators'] = $this->config->item('operators');

        $this->general_mdl->setTable('stock_log');

        $product_data = array();

        $this->data['id'] = $id = $this->input->get_post('id');

        $this->data['q'] = $q = $this->input->get_post('q');
        $this->data['start'] = $start = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
        $this->data['pageSize'] = $pageSize = $this->input->get_post('pageSize') ? $this->input->get_post('pageSize') : 20;

        $like = array();

        if($q){
            $like['remarks'] = $q;
        }

        $this->data['controller_url'] = "admin/product/stock_log/?id=".$id;
        //查询数据的总量,计算出页数
        $query = $this->general_mdl->get_query_or_like($like, array("pid" => $id));
        $this->data['total'] = $query->num_rows();
        $page = ceil($query->num_rows()/$pageSize);
        $this->data['page'] = $page;

        //取出当前面数据
        $query = $this->general_mdl->get_query_or_like($like, array("pid" => $id), $start-1, $pageSize);
        $product_data = $query->result_array();
        $this->data['current_page'] = $start;

        $prev_link = $this->data['controller_url'].'&page='.($start == 1 ? $start : $start-1);
        $prev_link .= $q ? '&q='.$q : '';

        $next_link = $this->data['controller_url'].'&page='.($start == $page ? $start : $start+1);
        $next_link .= $q ? '&q='.$q : '';

        $this->data['prev_link'] = $prev_link;
        $this->data['next_link'] = $next_link;

        $page_link = array();
        for ($i=1; $i <= $page; $i++){
            $page_link[$i] = $this->data['controller_url'].'&page='.$i;
            $page_link[$i] .= $q ? '&q='.$q : '';
        }
        $this->data['page_links'] = $page_link;

        $this->data['title'] = '库存记录';
        $this->data['result'] = $product_data;

        $this->load->view('admin_product/stock_log', $this->data);
    }
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */
