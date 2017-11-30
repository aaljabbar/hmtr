<?php

/*
  filename : $filename$
  Author   : $author$
  Date     : $crdate$
 
 */
class Corporate extends Abstract_model {

    public $table           = 'corporate';
    public $pkey            = 'corporate_id';
    public $alias           = 'cp';

    public $fields          = array(
								'corporate_id'=> array ( 'pkey' => true, 'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Corporate Id' ),
 								'corporate_nm'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Corporate Nm' ),
 								'address'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Address' ),
 								'no_fax'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Fax' ),
 								'no_telp'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Telp' ),
 								'npwp_no'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Npwp No' ),
 								'created_date'=> array ( 'pkey' => false, 'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array ( 'pkey' => false, 'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'update_by'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_by'=> array ( 'pkey' => false, 'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' )
                            );

    public $selectClause    =   " 
									cp.corporate_id,
 									cp.corporate_nm,
 									cp.address,
 									cp.no_fax,
 									cp.no_telp,
 									cp.npwp_no,
 									cp.created_date,
 									cp.update_date,
 									cp.update_by,
 									cp.created_by
                                ";
    public $fromClause      = " corporate cp ";

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
            $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata['user_name'];
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name'];
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Icons.php */