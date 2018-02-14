<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class send_msg
{
	/**
    * CI���
    * 
    * @access private
    * @var object
    */
	private $_CI;
    /**
    * message_mdlģ��
    * 
    * @access private
    * @var object
    */
	private $_MsgMdl;
    
	private $form_id;//������ID
	private $to_id;//������ID
	private $title;//��Ϣ����
	private $msg;//��Ϣ����
	private $id;//��ϢID
    
    private $Fields = array();
    
    public function __construct()
    {
        /** ��ȡCI��� */
		$this->_CI = & get_instance();
        
        $this->_CI->load->model('message_mdl', 'msg_mdl');
        $this->_MsgMdl = $this->_CI->msg_mdl;
    }
    
    //���÷�����id
    public function setFormId($fromid){
        $this->form_id = $fromid;
        $this->Fields['from_id'] = $fromid;
    }
    
    //���ý�����id
    public function setToId($toid){
        $this->to_id = $toid;
        $this->Fields['to_id'] = $toid;
    }
    
    //������Ϣ����
    public function setTitleId($title){
        $this->title = $title;
        $this->Fields['title'] = $title;
    }
    
    //������Ϣ����
    public function setMsg($msg){
        $this->msg = $msg;
        $this->Fields['message'] = $msg;
    }
    
    //������Ϣid
    public function setId($id){
        $this->id = $id;
    }
    
    //������Ϣ
    /*
    ** ���浽���ݿ�
    **
    */
    public function send_message()
    {
        $this->_MsgMdl->setData($this->Fields);
        return $this->_MsgMdl->create();
    }
    
    //���͸������
    public function send_multi_messages()
    {
         $toArray = split ('[,;]', $this->to_id);
         foreach($toArray as $row){
            $this->setToId($row);
            $msgIdArray[] = $this->send_message();
         }
         return $msgIdArray;
    }
    
    //ɾ����Ϣ
    public function del_message()
    {        
        return $this->_MsgMdl->delete_by_id($this->id);
    }
    
    //ɾ��������Ϣ
    public function del_multi_messages()
    {
         $idArray = split ('[,;]', $this->id);
         foreach($idArray as $row){
            $this->setId($row);
            $Array[] = $this->del_message();
         }
         return $Array;
    }
}
?>