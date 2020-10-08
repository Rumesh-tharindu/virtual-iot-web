<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("Register_Model");
        $this->load->dbforge();
       
    }

    public function index(){
        $data['project_codes']=$this->Register_Model->projectName();
        $this->load->view('register_view',$data);

    }
    public function store(){
      
      $config=array(
          array( 'field'=>'resources_id',
          'label'=>'Resources ID',
          'rules'=>'trim|required|is_unique[tanks.tank_id]'
      )
    
    );

    $valdator=array('success'=>false,'message'=>array());

    $this->form_validation->set_rules($config);
    $this->form_validation->set_error_delimiters('<p style="font-weight:bold;" class="text-danger">','</p>');

    if($this->form_validation->run()===true){

       $result= $this->Register_Model->storeData();
       $valdator['message']=$result;
       $valdator['success']=true;

       echo json_encode($valdator);

    }
    else{
        $valdator['success']=false;
        foreach($_POST as $key=>$value){
            $valdator['message'][$key]=form_error($key);
        }

        echo json_encode($valdator);
    }

    }

    public function updatedata(){
      
        $data['tanks']=  $this->Register_Model->getTank();
        $this->load->view('addvolume',$data);
        
        
    }
}

?>