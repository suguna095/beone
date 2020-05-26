<!DOCTYPE html>

<html lang="en">



<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Fastcoo</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <?php include APPPATH.'views/includes/styles.php';?>
</head>

<body>
   <?php include APPPATH.'views/includes/header.php';?>
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-light bg-transparent">
					<li class="breadcrumb-item"><a href="#"><i class="glyphicon glyphicon-home"></i>   Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">App</li>
					<li class="breadcrumb-item active" aria-current="page">App</li>
				</ol>
	</nav>
	<div class="container">
				<!-- Title -->
			
            
    
	        <div class="breadcrumb-line">
			<div class="hk-pg-header">
			<h4><i data-feather="arrow-left-circle"></i></i> 
                <span class="text-semibold">Datatables</span> - Upload App</h4>
			</div>
			</div>
				<!-- /Title -->
				
				<!-- Row -->
	<div class="content">
	<div class="panel panel-flat">
	<section class="hk-sec-wrapper">
	<div class="col-sm-6">
        <div class="panel-heading">
           <h4><i class="glyphicon glyphicon-th-large"></i></i></i> 
                <span class="text-semibold">App</span></h4>
        </div>
	</div>
	<br>
		<div class="row">
			<div class = "container">
				<div class = "col-xl-12">
				
				
					<section class="hk-sec-wrapper">
                            
                        <div class="row">
                            <div class="col-sm">
								<div class="col-sm-6">
                                    <form name="uplaod_file" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload App</span>
                                                </div>
                                                <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                <span class="input-group-append">
												<span class=" btn btn-primary btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                                                <input type="file" name="...">
                                                </span>
                                                <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </span>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Screen Shot</span>
                                                </div>
                                                <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                <span class="input-group-append">
														<span class=" btn btn-primary btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                                                <input type="file" name="...">
                                                </span>
                                                <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </span>
                                            </div>
                                        </div>
										<div class="form-group">
            
                                         <label>Upload Path</label>
                                         <input type="text" name="upload_path" class="form-control" value="" />
			
                                        </div>
										<div class="form-group">
            
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" value="" /></textarea>
                                        </div>
			
		                            <div class="form-group">
                                     <label>Email</label>
                                     <input type="email" id="myEmail" name="usermail" multiple class="form-control" value="" />
			                        </div>
                                     <button type="submit" class="btn btn-primary mr-10">Upload</button>
                                    </form>
                                </div>
                            </div>
						</div>
                    </section>
					<section class="hk-sec-wrapper">
                            
                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <table id="datable_1" class="table table-hover w-100 display pb-30">
										
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>Apps</th>
                                                    <th>Screen Shot</th>
                                                    <th>Upload Path</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td> 
													<a href="" target="_blank"><img src="<?php echo base_url()."assets/"; ?>dist/img/logo-dark.png"" height="40" width="30"> <i class="fa fa-download" aria-hidden="true"></i></a></td>
													<td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
													<div class="btn-group">
                                                       <button type="button" class="btn btn-primary"><i class="icon-list"></i></button>
                                                       <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                       <span class="sr-only">Toggle Dropdown</span>
                                                       </button>
                                                       <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(138px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                       <a class="dropdown-item" ng-click="delete()" ng-confirm-click="Do you want to Delete?">Delete</a>
                                                        </div>
                                                    </div>
													</td>
                                                </tr>
                                                
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </section>
				</div>
	
			</div>
				<!-- /Row -->
		</div>
		</section>
		</div>
		</div>
	</div>
 
   <?php include APPPATH.'views/includes/footer.php';?>