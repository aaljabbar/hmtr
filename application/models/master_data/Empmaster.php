<?php

/*
  classname :  Empmaster
  Date      : 28-11-2017 05:13:38
 
 */
class Empmaster extends Abstract_model {

    public $table           = 'empmaster';
    public $pkey            = 'emp_master_id';
    public $alias           = 'emp';

    public $fields          = array(
								'emp_master_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'bussinessunit_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Bussinessunit Id' ),
 								'emp_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Name' ),
 								'nick_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Nick Name' ),
 								'address'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Address' ),
 								'nik'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Nik' ),
 								'path_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Path Name' ),
 								'npwp_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Npwp Code' ),
 								'no_ktp'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Ktp' ),
 								'tgl_lhr'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Tgl Lhr' ),
 								'tmpt_lhr'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Tmpt Lhr' ),
 								'start_dat'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Start Dat' ),
 								'end_dat'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'End Dat' ),
 								'status'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Status' ),
 								'emp_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Code' ),
 								'bpjs_tk_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Bpjs Tk Code' ),
 								'bpjs_kes_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Bpjs Kes Code' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' )
                            );

    public $selectClause    =   " 
									emp.emp_master_id,
 									emp.bussinessunit_id,
 									emp.emp_name,
 									emp.nick_name,
 									emp.address,
 									emp.nik,
 									emp.path_name,
 									emp.npwp_code,
 									emp.no_ktp,
 									emp.tgl_lhr,
 									emp.tmpt_lhr,
 									emp.start_dat,
 									emp.end_dat,
 									emp.status,
 									emp.emp_code,
 									emp.bpjs_tk_code,
 									emp.bpjs_kes_code,
 									emp.created_by,
 									emp.created_date,
 									emp.update_date,
 									emp.update_by
                                ";
    public $fromClause      = " empmaster emp ";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {

            //do something
			// example :
			
            /* $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata['user_name'];
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name'];
			*/

			$this->db->set('start_dat',"to_date('".$this->record['start_dat']."','yyyy-mm-dd')",false);
			$this->db->set('tgl_lhr',"to_date('".$this->record['tgl_lhr']."','yyyy-mm-dd')",false);
			unset($this->record['start_dat']);
			unset($this->record['tgl_lhr']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
			//example:
			
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Icons.php */