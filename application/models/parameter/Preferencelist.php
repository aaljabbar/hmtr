<?php

/*
  classname :  Preferencelist
  Date      : 29-11-2017 02:11:12
 
 */
class Preferencelist extends Abstract_model {

    public $table           = 'preferencelist';
    public $pkey            = 'p_reference_list_id';
    public $alias           = 'prl';

    public $fields          = array(
								'p_reference_list_id'=> array (   'pkey' => true,'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'P Reference List Id' ),
 								'code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Code' ),
 								'p_reference_type_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'P Reference Type Id' ),
 								'reference_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Reference Name' ),
 								'listing_no'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Listing No' ),
 								'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' ),
 								'creation_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Creation Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'updated_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Updated Date' ),
 								'updated_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Updated By' )
                            );

    public $selectClause    =   " 
									prl.p_reference_list_id,
 									prl.code,
 									prl.p_reference_type_id,
 									prl.reference_name,
 									prl.listing_no,
 									prl.description,
 									prl.creation_date,
 									prl.created_by,
 									prl.updated_date,
 									prl.updated_by
                                ";
    public $fromClause      = " preferencelist prl ";

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