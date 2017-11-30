<style>
.swal-wide{
    width:850px !important;
}
</style>
<!-- breadcrumb -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php base_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
         <li>
            <a href="#">Developement</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Create File</span>
        </li>
    </ul>
</div>
<!-- end breadcrumb -->
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a  data-toggle="tab" tabindex="-1" aria-expanded="true" href="#tab-1">
                        <i class="blue"></i>
                        <strong> Generate File MVC </strong>
                    </a>
                </li>
                <li class="">
                    <a  data-toggle="tab" tabindex="-1" aria-expanded="true" href="#tab-2">
                        <i class="blue"></i>
                        <strong> Master Detail </strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content no-border" style="height:400px;">

            <div class="tab-pane fade active in" id="tab-1">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                        <label class="control-label col-md-3">Folder Name
                        </label>
                        <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control required" required id="folder_name" name="folder_name"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default success" type="button" id="btn-lov-duration">
                                    <i class="fa fa-ellipsis-h fa-1x"></i>
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Name
                        </label>
                        <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control required" required id="name" name="name"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default success" type="button" id="btn-lov-duration">
                                    <i class="fa fa-ellipsis-h fa-1x"></i>
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Table Name
                        </label>
                        <div class="col-md-8">
                            <div class="input-group">
                            <input type="text" class="form-control required" required id="table_name" name="table_name"   />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="btn-lov-schema">
                                    <i class="fa fa-ellipsis-h fa-1x"></i>
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Alias
                        </label>
                        <div class="col-md-8">
                            <div class="input-group">
                            <input type="text" class="form-control required" required id="alias" name="alias"   />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="btn-lov-schema">
                                    <i class="fa fa-ellipsis-h fa-1x"></i>
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">
                        </label>
                        <div class="col-md-8">
                            <button class="btn btn-primary" type="button" id="submit" >Submit</button>
                            <!-- <button class="btn btn-primary" type="button" id="replace" >Replace</button> -->
                            <button class="btn btn-success" type="button" id="permission" >Set Permission</button>
                            <button class="btn btn-danger" type="button" id="rollback" >Rollback</button>
                        </div>
                    </div>

                    </div>
                    <div class="space-4"></div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-2">
                
            </div>
        </div>
            

    </div>
    <hr>
</div>


<script>

    function submit(a,b,c,d){
        
        $.ajax({
            url: "<?php echo WS_JQGRID.'dev.create_file_controller/submitData'; ?>",
            type: "POST",
            data: {name:a, table_name:b, folder_name:c, alias:d},
            success: function (data) {
                data = JSON.parse(data);
                swal({title: "Info!", text: data.status, html: true, type: "info"});
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                return false;
            }
        });
        
    }

    function replace(){
        
        $.ajax({
            url: "<?php echo WS_JQGRID.'dev.create_file_controller/replaceData'; ?>",
            type: "POST",
            data: {},
            success: function (data) {

            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                return false;
            }
        });
        
    }

    function permisssion(a,b,c,d){
        
        $.ajax({
            url: "<?php echo WS_JQGRID.'dev.create_file_controller/setPermission'; ?>",
            type: "POST",
            data:{name:a, table_name:b, folder_name:c, alias:d},
            success: function (data) {
                data = JSON.parse(data);
                swal({title: "Info!", text: data.status, html: true, type: "info"});
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                return false;
            }
        });
        
    }

    function getFileExists(a,b,c){

        $.ajax({
            url: "<?php echo WS_JQGRID.'dev.create_file_controller/getFileExists'; ?>",
            type: "POST",
            data:{name:a, table_name:b, folder_name:c},
            success: function (data) {
                data = JSON.parse(data);

                controller = data.status.controller == '0' ? 'File Not Found' :  data.status.controller ;
                model = data.status.model == '0' ? 'File Not Found' :  data.status.model ;
                view = data.status.view == '0' ? 'File Not Found' :  data.status.view ;

                file = 'Controller : '+ controller + " \n";
                file += 'Models : '+ model + " \n";
                file += 'Views : '+ view + " \n";
                
                rollback(a,b,c,file);
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                return false;
            }
        });
        
    }

    function rollback(a,b,c, file){
            swal({
                title: "Are you sure?",
                text: "This File Will Be Removed From Your Storage ! \n "+ file,
                type: "warning",
                showCancelButton: true,
                customClass: 'swal-wide',
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes',
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    rollbackAction(a,b,c);
                }
            });
    }

    function rollbackAction(a,b,c){
        
        $.ajax({
            url: "<?php echo WS_JQGRID.'dev.create_file_controller/rollbackAction'; ?>",
            type: "POST",
            data:{name:a, table_name:b, folder_name:c},
            success: function (data) {
                data = JSON.parse(data);
                swal({title: "Info!", text: data.status, html: true, type: "info"});
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                return false;
            }
        });
        
    }

    $(document).ready(function(){
        var returnData;
        $('#submit').click(function(){
            
            a = $('#name').val();
            b = $('#table_name').val();
            c = $('#folder_name').val();
            d = $('#alias').val();

            if( a.length < 1 || b.length < 1 || c.length < 1 || d.length < 1){
                swal({title: "Warning !", text: 'Incomplete Data', html: true, type: "warning"});
            }else{
                submit(a,b,c,d);
            }
           
        });

        $('#permission').click(function(){
            a = $('#name').val();
            b = $('#table_name').val();
            c = $('#folder_name').val();
            d = $('#alias').val();

           if( a.length < 1 || b.length < 1 || c.length < 1 || d.length < 1){
                swal({title: "Warning !", text: 'Incomplete Data', html: true, type: "warning"});
            }else{
                permisssion(a,b,c,d);
            }
           
        });

        $('#rollback').click(function(e){
           
            e.preventDefault();
            
            a = $('#name').val();
            b = $('#table_name').val();
            c = $('#folder_name').val();

           if( a.length < 1 || b.length < 1 || c.length < 1 ){
                swal({title: "Warning !", text: 'Incomplete Data', html: true, type: "warning"});
            }else{
                getFileExists(a,b,c);
            }
           
        });

        $('#replace').click(function(){
           
           replace();
           
        }); 

    });

</script>