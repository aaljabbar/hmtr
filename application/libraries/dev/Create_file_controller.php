<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Create_file_controller
* @version 14/11/2017 
*/
class Create_file_controller {

    function submitData(){
        
        $foldername = getVarClean('folder_name','str','');
        $name = getVarClean('name','str','');
        $tablename = getVarClean('table_name','str','');
        $alias = getVarClean('alias','str','');
        $is_MD = getVarClean('is_md','int',0);

        $data = array('status' => '', 'message' => '', 'success'=> false);

        try{
            
            $ci = & get_instance();
            $ci->load->model('dev/create_file');
            $table = $ci->create_file;

            if($is_MD ==1){
                $data['status'] = $table->submitData(   strtolower($foldername), 
                                                        strtolower($name), 
                                                        strtolower($tablename), 
                                                        strtolower($alias)
                                                    );
            }else{
                $data['status'] = $table->submitDataMd(     strtolower($foldername), 
                                                            strtolower($name), 
                                                            strtolower($tablename), 
                                                            strtolower($alias)
                                                    );
            }
            
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        echo json_encode($data);
        exit();
    }
    
    
    function rollbackAction(){
        
        $foldername = getVarClean('folder_name','str','');
        $name = getVarClean('name','str','');
        $tablename = getVarClean('table_name','str','');
        $alias = getVarClean('alias','str','');

        $data = array('status' => '', 'message' => '', 'success'=> false);

        try{
            
            $ci = & get_instance();
            $ci->load->model('dev/create_file');
            $table = $ci->create_file;

            $data['status'] = $table->rollbackAction(   strtolower($foldername), 
                                                        strtolower($name)
                                                );
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        echo json_encode($data);
        exit();
    }

    function getFileExists(){
        
        $foldername = getVarClean('folder_name','str','');
        $name = getVarClean('name','str','');
        $tablename = getVarClean('table_name','str','');
        $alias = getVarClean('alias','str','');

        $data = array('status' => '', 'message' => '', 'success'=> false);

        try{
            
            $ci = & get_instance();
            $ci->load->model('dev/create_file');
            $table = $ci->create_file;

            $data['status'] = $table->getFileExists(   strtolower($foldername), 
                                                    strtolower($name)
                                                );
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        echo json_encode($data);
        exit();
    }

    function setPermission(){
        
        $foldername = getVarClean('folder_name','str','');
        $name = getVarClean('name','str','');
        $tablename = getVarClean('table_name','str','');
        $alias = getVarClean('alias','str','');

        $data = array('status' => '', 'message' => '', 'success'=> false);

        try{
            
            $ci = & get_instance();
            $ci->load->model('dev/create_file');
            $table = $ci->create_file;

            $data['status'] = $table->makePermission( 
                                                        strtolower($tablename)
                                                    );
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        echo json_encode($data);
        exit();
    }

    /*  function replaceData(){
        $item = array( 'add', 'edit', 'delete', 'view');
        $ret = '';
        foreach ($item as $key => $value) {
            $ret .= $value.'|';
        }
        $data = array('status' => $ret);
        echo json_encode($data);
        exit();
     } */
     function replaceData2(){

        $pathApp = FCPATH."application\ ";
        $filepath =  str_replace(' ', '',$pathApp.'models\ parameter\ param_test.php');

        $data = array('status' => '', 'message' => '', 'success'=> false);

        try{
            $ci = & get_instance();
            $ci->load->model('dev/create_file');
            $table = $ci->create_file;

            $tableName = 'corporate';
            $alias = 'cp';
            $aliasDot = strlen($alias) > 0 ? $alias.'.' : '';
            
            $pkTable    =  $table->getPkTable($tableName);
            $arrayTable =  $table->getArrayTable($tableName);
            $listCol    =  $table->getListCol($tableName, $aliasDot);
            
            $str = file_get_contents($filepath);

            $str = str_replace( '$classname$', ucfirst($tableName) ,$str); 
            $str = str_replace( '$tablename$', $tableName ,$str); 
            $str = str_replace( '$alias$', $alias ,$str); 
            $str = str_replace( '$pkey$', $pkTable ,$str);     
            $str = str_replace( '$arraytable$', $arrayTable ,$str);   
            $str = str_replace( '$listcol$', $listCol ,$str);      
            //$str = str_replace( 'line1', "\r\n" ,$str);

            file_put_contents($filepath, $str);

            $data['status'] = "";
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        echo json_encode($data);
        exit();
    }

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','corporate_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('parameter/corporate');
            $table = $ci->corporate;

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;
            logging('view data user');

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                permission_check('can-add-user');
                $data = $this->create();
            break;

            case 'edit' :
                permission_check('can-edit-user');
                $data = $this->update();
            break;

            case 'del' :
                permission_check('can-delete-user');
                $data = $this->destroy();
            break;

            default:
                permission_check('can-view-user');
                $data = $this->read();
            break;
        }

        return $data;
    }


    function create() {

        $ci = & get_instance();
        $ci->load->model('parameter/corporate');
        $table = $ci->corporate;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'CREATE';
        $errors = array();

        if (isset($items[0])){
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{

                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->create();

                    $table->db->trans_commit(); //Commit Trans

                }catch(Exception $e){

                    $table->db->trans_rollback(); //Rollback Trans
                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data added successfully1';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->create();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully2';
                logging('create data user');
            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update() {

        $ci = & get_instance();
        $ci->load->model('parameter/corporate');
        $table = $ci->corporate;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'UPDATE';

        if (isset($items[0])){
            $errors = array();
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{
                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->update();

                    $table->db->trans_commit(); //Commit Trans

                    $items[$i] = $table->get($items[$i][$table->pkey]);
                }catch(Exception $e){
                    $table->db->trans_rollback(); //Rollback Trans

                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data update successfully';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->update();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';
                logging('update data user');

                $data['rows'] = $table->get($items[$table->pkey]);
            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function destroy() {
        $ci = & get_instance();
        $ci->load->model('parameter/corporate');
        $table = $ci->corporate;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        try{
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');

                    $table->remove($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                }

                $table->remove($items);
                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';
            logging('delete data user');

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }


    function updateProfile() {

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        $id = getVarClean('id','int',0);
        $email = getVarClean('email','str','');
        $password = getVarClean('password','str','');
        $password_confirmation = getVarClean('password_confirmation','str','');

        try {
            $ci = & get_instance();
            $ci->load->model('parameter/corporate');
            $table = $ci->corporate;

            if(empty($id)) throw new Exception('ID tidak boleh kosong');
            if(empty($email)) throw new Exception('Email tidak boleh kosong');

            $item = $table->get($id);
            if($item == null) throw new Exception('ID tidak ditemukan');

            $record = array();
            if(!empty($password) and $ci->session->userdata('ldap_status') == 'NO') {
                if(strlen($password) < 4) throw new Exception('Min.Password 4 Karakter');
                if($password != $password_confirmation) throw new Exception('Password tidak cocok');

                $record['password'] = md5($password);
            }
            $record['user_email'] = $email;
            $record['user_id'] = $id;

            $table->actionType = 'UPDATE';
            $table->db->trans_begin(); //Begin Trans
                $table->setRecord($record);
                $table->update();
            $table->db->trans_commit(); //Commit Trans

            $ci->session->set_userdata('user_email',$email);

            $data['success'] = true;
            $data['message'] = 'Data profile berhasil diupdate';
            logging('update data profile');
        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
        }

        return $data;
    }
}

/* End of file Users_controller.php */