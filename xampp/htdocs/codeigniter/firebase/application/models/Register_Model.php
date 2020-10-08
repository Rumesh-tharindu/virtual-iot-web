<?php

class Register_Model extends CI_Model{

   
    public function projectName(){
        $this->db->select("location_code");
        $query=$this->db->get("project");
        return $query->result_array();
    }

    public function storeData(){
         $resourcesId=$this->input->post("resources_id");
        $data=array(
            'tank_id'=>$this->input->post("resources_id"),
            'resources_type'=>$this->input->post("resources_name"),
            'volume'=>$this->input->post("capacity"),
            'project_id'=>$this->input->post("loaction_id"),
        );

        $this->db->insert('tanks',$data);
        
        $this->dbforge->add_field(array(
            'id'=>array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment'=>TRUE,
            ),
            'resources_type'=>array(
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,

            ),
            'type'=>array(
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,

            ),
            'numberOrLocation'=>array(
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,

            ),
            'received_quentity'=>array(
                'type'=>'INT',
                'constraint'=>10,
                'null'=>true,

            ),
            'issued_quantity'=>array(
                'type'=>'INT',
                'constraint'=>10,
                'null'=>true,

            ),
            'issued_to'=>array(
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,

            ),
            'Issued_by'=>array(
                'type'=>'VARCHAR',
                'constraint'=>100,
                'null'=>false,

            ),
            'dt datetime default current_timestamp'
            

           

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($resourcesId);

        return "successfully added to system";
    }

    public function getTank(){
        $this->db->select("tank_id");
        $query=$this->db->get("tanks");
        return $query->result_array();
    }
}


?>