<?php

/*
  classname :  Corporate
  Date      : 28-11-2017 12:20:52
 
 */
class Corporate extends Abstract_model {

    public $table           = 'corporate';
    public $pkey            = 'corporate_id';
    public $alias           = 'cor';

    public $fields          = array(
								'corporate_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Corporate Id' ),
 								'corporate_nm'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Corporate Nm' ),
 								'address'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Address' ),
 								'no_fax'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Fax' ),
 								'no_telp'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Telp' ),
 								'npwp_no'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Npwp No' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' )
                            );

    public $selectClause    =   " 
									cor.corporate_id,
 									cor.corporate_nm,
 									cor.address,
 									cor.no_fax,
 									cor.no_telp,
 									cor.npwp_no,
 									cor.created_date,
 									cor.update_date,
 									cor.update_by,
 									cor.created_by
                                ";
    public $fromClause      = " corporate cor ";

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