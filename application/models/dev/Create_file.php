<?php

/**
 * Users Model
 *
 */
class Create_file extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(
                               );

    public $selectClause    = " ";

    public $fromClause      = "";

    public $refs            = array();

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db->_escape_char = ' ';
    }

    
    function checkTableName($tablename){
        if($tablename){
            $sql = " select count(1) cek 
                      from dba_tables
                        where table_name = upper('".$tablename."') ";
            $query = $this->db->query($sql);
            $item  = $query->row_array();
    
            return $item['cek'];
        }else{
            return 0;
        }
    }

    function getPkTable($tablename){
        if($tablename){
            $sql = " SELECT lower(ispktable(upper('".$tablename."'), null, 'GETPK')) as pkname FROM DUAL";
            $query = $this->db->query($sql);
            $item  = $query->row_array();
    
            return $item['pkname'];
        }else{
            return 0;
        }
    }

    function getArrayTable($tablename){
        if($tablename){
            $sql = "SELECT    ''''
                                || LOWER (column_name)
                                || ''''
                                || '=> array ( '
                                || case when   hmtri.ispktable(table_name, column_name, 'ISPK') = '1' then 
                                        ' ''pkey'' => true, ' 
                                        else null end  
                                || ' ''type'' => '
                                || ''''
                                || DECODE (data_type,
                                            'NUMBER', 'int',
                                            'VARCHAR2', 'str',
                                            'DATE', 'date',
                                            'str')
                                || ''''
                                || ' , ''nullable'' => '
                                || DECODE (nullable, 'N', 'false', 'true')
                                || ' , ''unique'' => false'
                                || ' , ''display'' =>  '
                                || ''''
                                || INITCAP (REPLACE (column_name, '_', ' '))
                                || ''''
                                || ' )'  array
                            FROM dba_tab_columns
                            WHERE  table_name = upper('".$tablename."') 
                            ORDER BY column_id asc ";
            $query = $this->db->query($sql);
            $item  = $query->result_array();

            $ret = '';
            $count = 0;
            foreach ($item as $key => $value) {
                $count++;
                if($count === count($item)){
                    $ret .= "\t\t\t\t\t\t\t\t".$value['array'];
                }else{
                    $ret .= "\t\t\t\t\t\t\t\t".$value['array'].','."\n ";
                }
            }
            
            return $ret;

        }else{
            return 0;
        }
    }

    function getListCol($tablename, $alias){
        if($tablename){
            $sql = "        SELECT lower(column_name) col
                            FROM dba_tab_columns
                            WHERE  table_name = upper('".$tablename."') 
                            ORDER BY column_id asc ";
            $query = $this->db->query($sql);
            $item  = $query->result_array();

            $ret = '';
            $count = 0;
            foreach ($item as $key => $value) {
                 $count++;
                if($count === count($item)){
                    $ret .= "\t\t\t\t\t\t\t\t\t".$alias.$value['col'];
                }else{
                    $ret .= "\t\t\t\t\t\t\t\t\t".$alias.$value['col'].','."\n ";
                }
            }
            
            return $ret;

        }else{
            return 0;
        }
    }

    function getListGrid($tablename){
         if($tablename){
            $sql = "        SELECT  CASE 
                                        WHEN hmtri.ispktable(table_name, column_name, 'ISPK') = '1' THEN 
                                            '{label: ' ||  '''ID''' || ', name: ''' ||  lower(column_name) || ''', key: true, width: 5, sorttype: ''number'', editable: true, hidden: true}' 
                                            ELSE
                                            '{label: '''|| INITCAP (REPLACE (column_name, '_', ' '))  ||''',name: ''' ||  lower(column_name) || ''' ,width: '||case when data_length < 100 then 100 else data_length end||', align: ''' ||  DECODE (data_type, 'NUMBER', 'right','left') || ''',editable: true,#' 
                                               ||
                                                    case when data_length > 100 then  
                                                         '$5 edittype:''textarea'',#'
                                                    else  null end
                                                 ||   '$5 editoptions:{# '
                                                 ||   '$6    size: 30,#'
                                                 ||   '$6    maxlength:' || data_length || '#'
                                                 ||   '$5},editrules: {required: false}#'
                                                 || ' $4}'
                                            END listgrid
                                    FROM dba_tab_columns
                                    WHERE  table_name = upper('".$tablename."') 
                                     AND column_name not in ('CREATED_BY','CREATED_DATE','UPDATE_BY', 'UPDATE_DATE')
                                    ORDER BY column_id asc
                                            ";
            $query = $this->db->query($sql);
            $item  = $query->result_array();

            $ret = '';
            $count = 0;
            foreach ($item as $key => $value) {

                $val = $value['listgrid'];
                $val = str_replace('#', "\n ", $val);
                $val = str_replace('$4', " \t\t\t\t ", $val);
                $val = str_replace('$5', " \t\t\t\t\t ", $val);
                $val = str_replace('$6', " \t\t\t\t\t\t ", $val);

                $count++;
                if($count === count($item)){
                    $ret .= "\t\t\t\t".$val;
                }else{
                    $ret .= "\t\t\t\t".$val.','." \n ";
                }
            }
            
            return $ret;

        }else{
            return 0;
        }
    }

    function getListGrid_bck($tablename, $alias){
        if($tablename){
            $sql = "        SELECT 
                                    DECODE(hmtri.ispktable(table_name, column_name, 'ISPK'),'true',1,0 ) ispk,
                                    INITCAP (REPLACE (column_name, '_', ' ')) label, 
                                     lower(column_name) name,  
                                     DECODE (data_type,
                                            'NUMBER', 'right','left') align, 
                                     DECODE (data_type,
                                            'NUMBER', 'int',
                                            'VARCHAR2', 'str',
                                            'DATE', 'date',
                                            'str') dat, 
                                            data_length
                            FROM dba_tab_columns
                            WHERE  table_name = upper('".$tablename."') 
                            ORDER BY column_id asc ";
            $query = $this->db->query($sql);
            $item  = $query->result_array();

            $ret = '';
            $count = 0;
            foreach ($item as $key => $value) {
                
                if($value['ispk'] == '1'){
                    //$ret .= '{label: 'ID', name: 'icon_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true}
                }

                 $count++;
                if($count === count($item)){
                    $ret .= "\t\t\t\t\t\t\t\t\t".$alias.$value['col'];
                }else{
                    $ret .= "\t\t\t\t\t\t\t\t\t".$alias.$value['col'].','."\n ";
                }
            }
            
            return $ret;

        }else{
            return 0;
        }
    }
    
    function getFileExists($foldername, $name){
        $pathApp = FCPATH."application\ ";
        
        $pathController = str_replace(' ', '',$pathApp.'libraries\ '.$foldername.'\ '.ucfirst($name).'_controller.php');
        $pathModel = str_replace(' ', '',$pathApp.'models\ '.$foldername.'\ '.ucfirst($name).'.php');
        $pathView = str_replace(' ', '',$pathApp.'views\ '.$foldername.'\ '.strtolower($name).'.php'); 
        
        $dirController = str_replace(' ', '',$pathApp.'libraries\ '.$foldername);
        $dirModel = str_replace(' ', '',$pathApp.'models\ '.$foldername);
        $dirView = str_replace(' ', '',$pathApp.'views\ '.$foldername);

        $templatePath = FCPATH."template_mvc\ ";
        $templateController = str_replace(' ', '',$templatePath.'controller.php');
        $templateModel = str_replace(' ', '',$templatePath.'model.php');
        $templateView = str_replace(' ', '',$templatePath.'view.php');

        $ret = array('controller' => 0,
                     'model' => 0, 
                     'view' => 0
                     );
        
        if(file_exists($pathController)){
            $ret['controller'] = $pathController;
        }
        if(file_exists($pathModel)){
            $ret['model'] = $pathModel;
        }
        if(file_exists($pathView)){
            $ret['view'] = $pathView;
        }

        return $ret;
    }

    function rollbackAction($foldername, $name){
        $pathApp = FCPATH."application\ ";
        
        $pathController = str_replace(' ', '',$pathApp.'libraries\ '.$foldername.'\ '.ucfirst($name).'_controller.php');
        $pathModel = str_replace(' ', '',$pathApp.'models\ '.$foldername.'\ '.ucfirst($name).'.php');
        $pathView = str_replace(' ', '',$pathApp.'views\ '.$foldername.'\ '.strtolower($name).'.php'); 
        
        $dirController = str_replace(' ', '',$pathApp.'libraries\ '.$foldername);
        $dirModel = str_replace(' ', '',$pathApp.'models\ '.$foldername);
        $dirView = str_replace(' ', '',$pathApp.'views\ '.$foldername);

        $templatePath = FCPATH."template_mvc\ ";
        $templateController = str_replace(' ', '',$templatePath.'controller.php');
        $templateModel = str_replace(' ', '',$templatePath.'model.php');
        $templateView = str_replace(' ', '',$templatePath.'view.php');

        $ret = '';
        
        if(file_exists($pathController)){
            if(!unlink($pathController)){
                $ret .= 'Failed Delete Controller'." \n";
            }else{
                $ret .= 'Controller Deleted'." \n";
            }
        }
        if(file_exists($pathModel)){
            if(!unlink($pathModel)){
                $ret .= 'Failed Delete Model'." \n";
            }else{
                $ret .= 'Model Deleted'." \n";
            }
        }
        if(file_exists($pathView)){
            if(!unlink($pathView)){
                $ret .= 'Failed Delete view'." \n";
            }else{
                $ret .= 'View Deleted'." \n ";
            }
        }

        return $ret;
    }

    function checkFileExists($foldername, $name, $tableName, $alias){
        
        $pathApp = FCPATH."application\ ";
        
        $pathController = str_replace(' ', '',$pathApp.'libraries\ '.$foldername.'\ '.ucfirst($name).'_controller.php');
        $pathModel = str_replace(' ', '',$pathApp.'models\ '.$foldername.'\ '.ucfirst($name).'.php');
        $pathView = str_replace(' ', '',$pathApp.'views\ '.$foldername.'\ '.strtolower($name).'.php'); 
        
        $dirController = str_replace(' ', '',$pathApp.'libraries\ '.$foldername);
        $dirModel = str_replace(' ', '',$pathApp.'models\ '.$foldername);
        $dirView = str_replace(' ', '',$pathApp.'views\ '.$foldername);

        $templatePath = FCPATH."template_mvc\ ";
        $templateController = str_replace(' ', '',$templatePath.'controller.php');
        $templateModel = str_replace(' ', '',$templatePath.'model.php');
        $templateView = str_replace(' ', '',$templatePath.'view.php');

        $ret = array('controller' => $pathController.' Not Exist', 'model' => $pathModel.' Not Exist', 'view' => $pathView.' Not Exist', );
        
        if(!is_dir($dirController)){
            mkdir($dirController, 0777);
        }
        if(!is_dir($dirModel)){
            mkdir($dirModel, 0777);
        }
        if(!is_dir($dirView)){
            mkdir($dirView, 0777);
        }

        if (file_exists($pathController)) {
            $ret['controller'] = 'Already Exist';
        }else{
            if(copy($templateController,$pathController))
            $this->replaceFileContent($pathController, $foldername, $tableName, $alias, $type='CONTROLLER');
            $ret['controller'] = 'OK';
        }

        if (file_exists($pathModel)) {
            $ret['model'] = 'Already Exist';
        }else{
            if(copy($templateModel,$pathModel))
            $this->replaceFileContent($pathModel, $foldername, $tableName, $alias, $type='MODELS');
            $ret['model'] = 'OK';
        }

        if (file_exists($pathView)) {
            $ret['view'] = 'Already Exist';
        }else{
            if(copy($templateView,$pathView))
            $this->replaceFileContent($pathView, $foldername, $tableName, $alias, $type='VIEWS');
            $ret['view'] = 'OK';
        }

        return $ret;

    }

    function submitData($foldername, $name, $tablename, $alias){
        
        $ret = array();
        // check table 
        $ret['table_status'] = $this->checkTableName($tablename) > 0 ? 'Table OK' : 'Table Not Found';
        
        // check file exists 
        $ret['file_status'] = $this->checkFileExists($foldername,$name, $tablename, $alias);

        // create file 

        return $ret;
    }

    function submitDataMd($foldername, $name, $tablename, $alias){
        
        $ret = array();
        // check table 
        $ret['table_status'] = $this->checkTableName($tablename) > 0 ? 'Table OK' : 'Table Not Found';
        
        // check file exists 
        if($ret['table_status'] == 'Table OK'){

            $ret['file_status'] = $this->checkFileExists($foldername,$name, $tablename, $alias);

        }

        return $ret;
    }

    function replaceFileContent($filepath, $foldername, $tableName, $alias, $type){
        
        if($filepath){

            $str            = file_get_contents($filepath);
            $tableName      = strtolower($tableName);

            if($type == 'CONTROLLER'){
                
                $classname      = ucfirst($tableName).'_controller';
                $versionDate    = date('d-m-Y h:i:s');
                $pkey           = $this->getPkTable($tableName);
                $modelclass     = strtolower($foldername.'/'.$tableName);
                $modelci        = strtolower('$ci->'.$tableName);
                $logging        = $tableName;

                $permissionAdd      = 'can-add-'.$tableName;
                $permissionEdit     = 'can-edit-'.$tableName;
                $permissionDel      = 'can-del-'.$tableName;
                $permissionView     = 'can-view-'.$tableName;

                $str = str_replace( '$classname$', $classname ,$str); 
                $str = str_replace( '$versionDate$', $versionDate ,$str); 
                $str = str_replace( '$pkey$', $pkey ,$str); 
                $str = str_replace( '$modelclass$', $modelclass ,$str); 
                $str = str_replace( '$modelci$', $modelci ,$str);     
                $str = str_replace( '$permissionAdd$', $permissionAdd ,$str);     
                $str = str_replace( '$permissionEdit$', $permissionEdit ,$str);     
                $str = str_replace( '$permissionDel$', $permissionDel ,$str);     
                $str = str_replace( '$permissionView$', $permissionView ,$str);   
                $str = str_replace( '$logging$', $logging ,$str);   

            }

            if($type == 'MODELS'){
                
                $versionDate    = date('d-m-Y h:i:s');
                $aliasDot       = strlen($alias) > 0 ? $alias.'.' : '';
                $pkTable        =  $this->getPkTable($tableName);
                $arrayTable     =  $this->getArrayTable($tableName);
                $listCol        =  $this->getListCol($tableName, $aliasDot);

                $str = str_replace( '$versionDate$', $versionDate ,$str); 
                $str = str_replace( '$classname$', ucfirst($tableName) ,$str); 
                $str = str_replace( '$tablename$', $tableName ,$str); 
                $str = str_replace( '$alias$', $alias ,$str); 
                $str = str_replace( '$pkey$', $pkTable ,$str);     
                $str = str_replace( '$arraytable$', $arrayTable ,$str);   
                $str = str_replace( '$listcol$', $listCol ,$str);     

            }

            if($type == 'VIEWS'){

                $menu       = $tableName;
                $urlclass   = strtolower($foldername.'.'.$tableName.'_controller');
                $listgrid   = $this->getListGrid($tableName);
                $caption    = ucfirst($tableName);

                $str = str_replace( '$menu$', $menu ,$str); 
                $str = str_replace( '$urlclass$', $urlclass ,$str); 
                $str = str_replace( '$listgrid$', $listgrid ,$str);     
                $str = str_replace( '$caption$', $caption ,$str);    

            }
            
            //$str = str_replace( 'line1', "\r\n" ,$str);

            file_put_contents($filepath, $str);

        }
    }

    function replaceFileContentMd($filepath, $foldername, $tableName, $alias, $type){
        
        if($filepath){

            $str            = file_get_contents($filepath);
            $tableName      = strtolower($tableName);

            if($type == 'CONTROLLER'){
                
                $classname      = ucfirst($tableName).'_controller';
                $versionDate    = date('d-m-Y h:i:s');
                $pkey           = $this->getPkTable($tableName);
                $modelclass     = strtolower($foldername.'/'.$tableName);
                $modelci        = strtolower('$ci->'.$tableName);
                $logging        = $tableName;

                $permissionAdd      = 'can-add-'.$tableName;
                $permissionEdit     = 'can-edit-'.$tableName;
                $permissionDel      = 'can-del-'.$tableName;
                $permissionView     = 'can-view-'.$tableName;

                /* $columnRef  =   '' ;
                $refId      =
                $varRefId   = */

                $str = str_replace( '$columnRef$', $columnRef ,$str); 
                $str = str_replace( '$refId$', $refId ,$str); 
                $str = str_replace( '$varRefId$', $varRefId ,$str); 
                $str = str_replace( '$classname$', $classname ,$str); 
                $str = str_replace( '$versionDate$', $versionDate ,$str); 
                $str = str_replace( '$pkey$', $pkey ,$str); 
                $str = str_replace( '$modelclass$', $modelclass ,$str); 
                $str = str_replace( '$modelci$', $modelci ,$str);     
                $str = str_replace( '$permissionAdd$', $permissionAdd ,$str);     
                $str = str_replace( '$permissionEdit$', $permissionEdit ,$str);     
                $str = str_replace( '$permissionDel$', $permissionDel ,$str);     
                $str = str_replace( '$permissionView$', $permissionView ,$str);   
                $str = str_replace( '$logging$', $logging ,$str);   

            }

            if($type == 'MODELS'){
                
                $versionDate    = date('d-m-Y h:i:s');
                $aliasDot       = strlen($alias) > 0 ? $alias.'.' : '';
                $pkTable        =  $this->getPkTable($tableName);
                $arrayTable     =  $this->getArrayTable($tableName);
                $listCol        =  $this->getListCol($tableName, $aliasDot);

                $str = str_replace( '$versionDate$', $versionDate ,$str); 
                $str = str_replace( '$classname$', ucfirst($tableName) ,$str); 
                $str = str_replace( '$tablename$', $tableName ,$str); 
                $str = str_replace( '$alias$', $alias ,$str); 
                $str = str_replace( '$pkey$', $pkTable ,$str);     
                $str = str_replace( '$arraytable$', $arrayTable ,$str);   
                $str = str_replace( '$listcol$', $listCol ,$str);     

            }

            if($type == 'VIEWS'){

                $menu       = $tableName;
                $urlclass   = strtolower($foldername.'.'.$tableName.'_controller');
                $listgrid   = $this->getListGrid($tableName);
                $caption    = ucfirst($tableName);

                $str = str_replace( '$menu$', $menu ,$str); 
                $str = str_replace( '$urlclass$', $urlclass ,$str); 
                $str = str_replace( '$listgrid$', $listgrid ,$str);     
                $str = str_replace( '$caption$', $caption ,$str);    

            }
            
            //$str = str_replace( 'line1', "\r\n" ,$str);

            file_put_contents($filepath, $str);

        }
    }

    function makePermission($tablename){
        if($tablename){

            $tablename = strtolower($tablename);
            $ci = & get_instance();
            $ci->load->model('administration/permissions');
            $table = $ci->permissions;

            $item = array( 'add', 'edit', 'del', 'view');

            $table->actionType == 'CREATE';
            foreach ($item as $key => $value) {

                $permission = 'can-'.$value.'-'.$tablename;

                if($table->checkNotExistPermission($permission)){
                    
                    $items['permission_name'] = $permission;
                    $items['permission_id'] = $table->generate_id($table->table, $table->pkey);

                    $table->setRecord($items);
                    $table->create();
                    $id = $table->getPermissionId($permission);
                    $id = $id > 0 ? $id : false;
                    $this->setPermissionToAdmin($id);

                }

            }
            return 'OK';
        }else{
            return 'NO TABLENAME';
        }
    }
    
    function setPermissionToAdmin($permission_id){
        if($permission_id){

            $ci = & get_instance();
            $ci->load->model('administration/permission_role');
            $table = $ci->permission_role;

            if($table->checkNotExistPermissionRole($permission_id, 1)){
                $items['permission_id'] = $permission_id;
                $items['role_id'] = 1;
                $table->actionType == 'CREATE';
                $table->setRecord($items);
                $table->create();
            }
            
            return true;
        }else{
            return false;
        }
    }

}

/* End of file Users.php */