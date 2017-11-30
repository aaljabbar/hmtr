<?php

/*
  classname :  Telegrambot
  Date      : 24-11-2017 10:46:50
 
 */
class Telegrambot extends Abstract_model {

    public $table           = 'telegrambot';
    public $pkey            = 'id';
    public $alias           = 'tel';

    public $fields          = array(
								'id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Id' ),
 								'botid'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Botid' ),
 								'name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Name' ),
 								'token'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Token' ),
 								'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' )
                            );

    public $selectClause    =   " 
									tel.id,
 									tel.botid,
 									tel.name,
 									tel.token,
 									tel.description
                                ";
    public $fromClause      = " telegrambot tel ";

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