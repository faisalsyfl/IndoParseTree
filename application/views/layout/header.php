<!doctype html>
<html class="no-js" lang="en">
<head>
	<!-- Page Header -->
	
	<title>ID Parse Tree</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">  	
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">  	
	<link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
  	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</head>
<body onload="load()">
	<!-- Navigation  -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a style="padding-top: 10px; color:white;" class="navbar-brand" href="<?php echo site_url(); ?>">&nbsp;&nbsp;<span><img src="<?php echo base_url(); ?>assets/img/h.png" width="5%">&nbsp;&nbsp;</span>Indonesia Parse Tree</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul style="padding-right: 10px;" class="nav navbar-nav navbar-right">
					<li>
						<div style="padding: 8px 5px 0px 0px">
							<button class="btn btn-warning" type="button" onclick="toggleFullScreen()"><span class="glyphicon glyphicon-fullscreen"></span></button>
						</div>
					</li>
					<li>					
						<div class="dropdown" style="padding: 8px 5px 0px 0px" id="dropdown">
		  					<button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;About</button>
						  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    <li class="dropdown-header">Programmer</li>
							    <li><a href="http://about.me/faisalsyfl" target="_blank">Faisal Syaiful Anwar</a></li>
							    <li><a href="http://about.me/faisalsyfl" target="_blank">Anita Dyah Pertiwi</a></li>
						  	</ul>
						</div>
					</li>					
				</ul>
			</div>
		</div>
	</nav>

	<div id="loader"></div>

	<!-- Page Container -->
	<div class="container animate-bottom" style="display: none; padding-top: 70px;" id="container">
		<div class="row" id="rowmanual">
			<div class="col-md-7">
				<div class="panel panel-primary">
	  				<div class="panel-heading">
	    				<h3 class="panel-title"><span class="glyphicon glyphicon-pencil aria-hidden="true"></span>&nbsp;&nbsp;Input Testing</h3>
				  	</div>
	  				<div class="panel-body">
	  					<?php echo form_open('Home/pt'); ?>
	  					<h4><i>Part of Speech</i> Tag</h4>
							<div class="form-group">
								<div class="col-md-12">
									<input type="text" class="form-control" placeholder="Sentence" name="sentence" required="">		
								</div>
						  </div>
							<small style='font-style:italic; color:grey;'>&nbsp;&nbsp;&nbsp;&nbsp;ex: sikap oposisi sangat disayangkan oleh kami</small>
							<br>
  							<div class="form-group">
								<input type="submit" class="btn btn-success form-control " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" id="submitm" value="Check">	  
						  </div>
						 <?php echo form_close(); ?>
						 <?php echo form_open('Home/ac'); ?>
	  					<h4>Ambiguity Checker</h4>
							<div class="form-group">
								<div class="col-md-12">
									<input type="text" class="form-control" placeholder="Word" name="word" required="">
								</div>
						  </div>
							<small style='font-style:italic; color:grey;'>&nbsp;&nbsp;&nbsp;&nbsp;ex: makan, waktu, untuk</small>
							<br>
  							<div class="form-group">
								<input type="submit" class="btn btn-success form-control " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" id="submitm" value="Check">			  						  
						  </div>
						 <?php echo form_close(); ?>
	  					<?php echo form_open('Home/parser'); ?>
	  					<h4>Syntactic Parser</h4>
							<div class="form-group">
								<div class="col-md-12">
									<input type="text" class="form-control" placeholder="Sentence" name="sentence" required="">
								</div>
						  </div>
							<small style='font-style:italic; color:grey;'>&nbsp;&nbsp;&nbsp;&nbsp;ex: saya juga memakan uang dan dua kartu</small>
							<br>
  							<div class="form-group">
								<input type="submit" class="btn btn-success form-control " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" id="submitm" value="Check">	  
						  </div>
						 <?php echo form_close(); ?>
					</div>
				</div>	
			</div>
			<div class="col-md-5">
				<div class="panel panel-primary">
	  				<div class="panel-heading">
	    				<h3 class="panel-title"><span class="glyphicon glyphicon-info-sign aria-hidden="true"></span>&nbsp;&nbsp;Information & Top Frequency</h3>
				  	</div>
	  				<div class="panel-body">
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						  <div class="panel panel-warning">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						          Model Information
						        </a>
						      </h4>
						    </div>
						    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
				  					<table class="table table-condensed">
				  						<tbody>
				  							<tr>
				  								<td>Number of Token</td>
				  								<td>:</td>
				  								<td><?php echo $numOfToken; ?></td>
				  							</tr>
				  							<tr>
				  								<td>Number of Tag</td>
				  								<td>:</td>
				  								<td><?php echo $numOfTag; ?></td>
				  							</tr>				  								  							
				  						</tbody>
				  					</table>
						      </div>
						    </div>
						  </div>
						  <div class="panel panel-info">
						    <div class="panel-heading" role="tab" id="headingTag">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTag" aria-expanded="false" aria-controls="collapseTag">
						          Tagset Information
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTag" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTag">
						      <div class="panel-body">
						      	<?php foreach($tagset as $tag){ ?>
				  					<button type="button" class="btn btn-success" style="background-color:<?php echo $tag['bgcolor'] ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $tag['desk']." | ".$tag['ex']; ?>" ><?php echo $tag['tag']; ?></button>
						      	<?php } ?>
						      </div>
						    </div>
						  </div>						  
						  <div class="panel panel-info">
						    <div class="panel-heading" role="tab" id="headingTwo">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Top 10 TAG transition
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						      <div class="panel-body">
				  					<table class="table table-condensed">
				  						<tbody>
				  							<?php $i=1;foreach($topTransition as $row){  ?>
				  							<tr>
				  								<td><?php echo $i++; ?></td>
				  								<td><?php echo $row['key']; ?></td>
				  								<td><?php echo $row['count']; ?></td>
				  								<td><?php echo round($row['prob'],6); ?></td>
				  							</tr>
											<?php if($i==11) break;} ?>
				  						</tbody>
				  					</table>
						      </div>
						    </div>
						  </div>
						  <div class="panel panel-info">
						    <div class="panel-heading" role="tab" id="headingThree">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          Top 10 emission probabilities
						        </a>
						      </h4>
						    </div>
						    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTree">
						      <div class="panel-body">
				  					<table class="table table-condensed">
				  						<tbody>
				  							<?php $i=1;foreach($topEmission as $row){ if($row['key'] == "|Z") continue;?>
				  							<tr>
				  								<td><?php echo $i; ?></td>
				  								<td><?php echo $row['key']; ?></td>
				  								<td><?php echo $row['count']; ?></td>
				  								<td><?php echo round($row['prob'],6); ?></td>
				  								
				  							</tr>
											<?php $i++; if($i==11) break;} ?>						
				  						</tbody>
				  					</table>
						      </div>
						    </div>
						  </div>
  						  <div class="panel panel-danger">
						    <div class="panel-heading" role="tab" id="headingFour">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						          Want to contribute? 
						        </a>
						      </h4>
						    </div>
						    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						      <div class="panel-body">
				  					<h4>COMING SOON!</h4>
						      </div>
						    </div>
						  </div>						  								  
						</div>	  				
					</div>
				</div>	
			</div>
		</div>