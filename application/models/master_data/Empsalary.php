<?php

/*
  classname :  Empsalary
  Date      : 29-11-2017 02:19:36
 
 */
class Empsalary extends Abstract_model {

    public $table           = 'empsalary';
    public $pkey            = 'empsalary_id';
    public $alias           = 'empsal';

    public $fields          = array(
								'empsalary_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Empsalary Id' ),
 								'emp_master_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'salary'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Salary' ),
 								'pay_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Pay Date' ),
 								'valid_from'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Valid From' ),
 								'valid_until'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Valid Until' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'p_reference_list_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'P Reference List Id' )
                            );

    public $selectClause    =   " 
									empsal.empsalary_id,
 									empsal.emp_master_id,
 									empsal.salary,
 									empsal.pay_date,
 									empsal.valid_from,
 									empsal.valid_until,
 									empsal.created_date,
 									empsal.created_by,
 									empsal.update_by,
 									empsal.update_date,
 									empsal.p_reference_list_id
                                ";
    public $fromClause      = " empsalary empsal ";

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