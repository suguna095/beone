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
   <div class="container">
   <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="glyphicon glyphicon-home"></i>   Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">General Setting</li>
					<li class="breadcrumb-item active" aria-current="page">Company Details</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

    
    <div class="container">
                <!-- Title -->
	<section class="hk-sec-wrapper">
            <div class="breadcrumb-line">
	            <div class="hk-pg-header">
			    <h4><i data-feather="arrow-left-circle"></i></i> 
                <span class="text-semibold"></span>Company Details</h4>
			    </div>
			</div>
	<form role="form" enctype="multipart/form-data" class="form-horizontal">	
			<section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Company Details</h5><br>
							<h5 class="hk-sec-title"><i class="glyphicon glyphicon-user"></i>  Admin Login Setup</h5><br>
                            <div class="row">
                                <div class="col-sm">
                                   
                                        <div class="form-group">
                                            <label for="inputText">User Name</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                    
                                    
                                        <div class="form-group">
                                            <label for="inputPassword5">Password</label>
                                            <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
                                        </div>
                                    
                                </div>
                            </div>
            </section>
			<section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title"><i class="fa fa-building-o"></i>  Company Info</h5><br>
                            <div class="row">
                                <div class="col-sm">
                                    
                                        <div class="form-group">
                                            <label for="inputText">Company Name</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                    
                                   
                                        <div class="form-group">
                                            <label for="inputText">Company Address</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                   
									
                                        <div class="form-group">
                                            <label for="inputText">Phone</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                    
									
                                        <div class="form-group">
                                            <label for="inputText">VAT</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                   
									
                                        <div class="form-group">
                                            <label for="inputText">Email</label>
                                            <input type="email" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                    
                                </div>
                            </div>
            </section>
			<section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title"><i class="glyphicon glyphicon-cog"></i>  Other Settings</h5><br>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label class="text-bold">Set Default Time Zone</label>
                                        <select class="form-control custom-select">
                                                <option selected>--Select--</option>
                                                <option value="1">One</option>
                                        </select>
									</div>	
                                        <div class="form-group">
                                            <label for="inputText">Pages</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
										
										<div class="form-group">
                                            <label for="inputText">Set Default Vat%</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
                                      
									   <div class="form-group">
                                        <label class="text-bold">Set Default Country</label>
                                        <select class="form-control custom-select">
                                                <option selected>--Select--</option>
                                                <option value="1">One</option>
                                        </select>
									   </div>
									    <div class="form-group">
                                            <label for="inputText">Set Default AWB No</label>
                                            <input type="text" id="inputText" class="form-control" aria-describedby="textHelpBlock">
                                        </div>
										<div class="form-group">
                                        <label class="text-bold">Default Currency</label>
                                        <select class="form-control custom-select">
                                                <option selected>--Select--</option>
                                                <option value="1">One</option>
                                        </select>
									   </div>
									   <div class="form-group">
                                        <label class="text-bold">Admin Character Set</label>
                                        <select class="form-control custom-select">
                                                <option selected>--Select--</option>
                                                <option value="1">One</option>
                                        </select>
									   </div>
									   <div class="form-group">
                                        <label class="text-bold">Front Character Set</label>
                                        <select class="form-control custom-select">
                                                <option selected>--Select--</option>
                                                <option value="1">One</option>
                                        </select>
									   </div>
									   
						          <label class="text-bold">Logo</label>
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                <span class="input-group-append">
														<span class=" btn btn-primary btn-file"><span class="fileinput-new">Select Logo</span><span class="fileinput-exists">Change</span>
                                                <input type="file" name="...">
                                                </span>
                                                <a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </span>
                                            </div>
                                        </div>
										<div class="form-group">
                                        <label class="text-bold"></label>
            
                                        <input type="radio" name="messanger_type" value="S"  checked="checked" >
                                        
                                        <span id="" style="color:#fb9337"></span></span>
                                       </div>
                                   
                                </div>
                            </div>
										
                                     
									 <button type="submit" class="btn btn-primary mr-10">Update</button>
                                </div>
                            </div>
            </section>
	</form>		
                <!-- /Title -->
    </section>            
				<?php include APPPATH.'views/includes/footer.php';?>