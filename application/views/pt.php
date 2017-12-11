		<div id="hasil" class="row" style="">
			<div class="col-md-12">
				<div class="panel panel-primary">
	  				<div class="panel-heading">
	    				<h3 class="panel-title"><span class="glyphicon glyphicon-check aria-hidden="true"></span>&nbsp;&nbsp;Calculate Result</h3>
				  	</div>
	  				<div class="panel-body">
	  					<div class="row">
	  						<div class="col-md-12">
			  					<div class="panel panel-info">
					  				<div class="panel-heading">
					    				<h3 class="panel-title"><i>Part of Speech</i> Tag</h3>
								  	</div>
								  	<div class="panel-body">
								  		<table class="table table-condensed">
					  						<tbody>
					  							<?php if(isset($tagz)){ ?>
					  							<tr class="warning">
					  								<?php foreach($sentence as $word){ ?>
					  								<td><?php echo $word; ?></td>
					  								<?php } ?>
					  							</tr>
					  							<tr class="warning">
					  								<?php foreach($tagz as $word){ ?>
					  								<td><?php echo $word; ?></td>
					  								<?php } ?>
					  							</tr>					  							
					  							<?php }else{ ?>
					  							<tr>
					  								Sorry, can't recognize the given word. Please try again.
					  							</tr>
					  							<?php } ?>
					  						</tbody>
					  					</table>
									</div>
								</div>
							</div>						
						</div>												
					</div>
				</div>
			</div>
		</div>		
