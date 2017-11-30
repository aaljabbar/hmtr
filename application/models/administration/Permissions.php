<?php

/**
 * Permissions Model
 *
 */
class Permissions extends Abstract_model {

    public $table           = "permissions";
    public $pkey            = "permission_id";
    public $alias           = "prms";

    public $fields          = array(
                                'permission_id'             => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Permissions'),
                                'permission_name'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Permission Name'),
                                'permission_display_name'   => array('nullable' => true, 'type' => 'str', 'unique' => true, 'display' => 'Display Name'),
                                'permission_description'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "prms.*";
    public $fromClause      = "permissions prms";

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
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];
            //if false please throw new Exception
        }
        return true;
    }

    function checkNotExistPermission($permissionName){

            $sql = " SELECT decode(count(1),0,'true','false') is_not_exist from hmtri.permissions where upper(permission_name) = upper('".$permissionName."') ";
            $query = $this->db->query($sql);
            $item  = $query->row_array();
    
            return $item['is_not_exist'];
    }

    function getPermissionId($permissionName){

            $sql = " SELECT permission_id from hmtri.permissions where permission_name = ?";
            $query = $this->db->query($sql, array($permissionName));
            $item  = $query->row_array();
    
            return $item['permission_id'];
    }

}

/* End of file Permissions.php */