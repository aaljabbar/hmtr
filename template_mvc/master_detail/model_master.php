<?php

/*
  classname :  $classname$
  Date      : $versionDate$
 
 */
class $classname$ extends Abstract_model {

    public $table           = '$tablename$';
    public $pkey            = '$pkey$';
    public $alias           = '$alias$';

    public $fields          = array(
$arraytable$
                            );

    public $selectClause    =   " 
$listcol$
                                ";
    public $fromClause      = " $tablename$ $alias$ ";

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