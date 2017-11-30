<?php

/*
  classname :  Bussinesunit
  Date      : 28-11-2017 01:26:57
 
 */
class Bussinesunit extends Abstract_model {

    public $table           = 'bussinesunit';
    public $pkey            = 'bussinessunit_id';
    public $alias           = 'bu';

    public $fields          = array(
								'bussinessunit_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Bussinessunit Id' ),
 								'corporate_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Corporate Id' ),
 								'butype_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Butype Id' ),
 								'bu_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Bu Name' ),
 								'address'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Address' ),
 								'no_fax'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Fax' ),
 								'no_telp'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'No Telp' ),
 								'bu_code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Bu Code' ),
 								'npwp_no'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Npwp No' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' )
                            );

    public $selectClause    =   " 
									bu.bussinessunit_id,
 									bu.corporate_id,
 									bt.code butype_id,
 									bu.bu_name,
 									bu.address,
 									bu.no_fax,
 									bu.no_telp,
 									bu.bu_code,
 									bu.npwp_no,
 									bu.created_date,
 									bu.update_by,
 									bu.created_by
                                ";
    public $fromClause      = " bussinesunit bu 
                                join butype bt on bu.butype_id = bt.butype_id
                                ";

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