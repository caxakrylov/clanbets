	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">
	                   			<span>Main table</span>
	                   			<span style="float:right;">
	                    		     	<select class="selectpicker" id='selectpic' multiple>
	                    		     		<?foreach($disciplines as $item){
	                    		     			if (isset($_SESSION['disciplines_user']) && $_SESSION['disciplines_user'] == 'all') {?>
	                    		     				<option selected="selected" value="<?=$item->id?>"><?=$item->name?></option>
	                    		     			<? } elseif (isset($_SESSION['disciplines_user']) && in_array($item->id, $_SESSION['disciplines_user'])) {?>
										<option selected="selected" value="<?=$item->id?>"><?=$item->name?></option>
									<?} else {?>
										<option value="<?=$item->id?>"><?=$item->name?></option>
									<?}
								}?>
							</select>
						</span>
	                   		</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->
	            	<div class="row">
	                	<div class="col-lg-12">
                        		<div class="table-responsive">
                        			<span id="descript">У нас вы можете сделать ставки на киберспорт, e sport. Некоторые ставки cs go, dota2 бывают непредсказуемыми. Стабильные ставки на танки, wot.</span>
                            			<table class="table table-bordered table-hover table-nomargin table-condensed" id="mainTable">

		                                    	<thead>
		                                       	<tr>
		                                            		<th>
					                                      	<select name="UTC" size="1" id="setUTC" onchange="sUTC(this)">
												<?foreach($UTC as $item){
													if (isset($_SESSION['utc_user']) && $_SESSION['utc_user'] == $item->value) {?>
														<option selected value="<?=$item->value?>"><?=$item->name?></option>
													<?} else {?>
														<option value="<?=$item->value?>"><?=$item->name?></option>
													<?}}?>
											</select>
		                                            		</th>
										<th>Best of</th>
										<th colspan='2'>Player #1</th>
										<th colspan='2'>Player #2</th>
										<th>Draw</th>
										<th>Event</th>
										<th>State</th>
		                                        	</tr>
		                                    	</thead>
								<tbody id="tableHolder">
								</tbody>
                            			</table>
                        		</div>
                        		<!-- /.table-responsive -->
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->

 <!-- Modal -->
<div class="modal fade" id="PromoModal" tabindex="-1" role="dialog" aria-labelledby="PromoModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="PromoModalLabel">Information</h4>
			</div>
			<div class="modal-body" style="padding:0 40px;">
					<h5 style="text-align:center; padding:10px 20px;">
						Promo "$10 + $1 FREE".
					</h5>
					<p>Hello! If you make a deposit of $10, you get $1 free.</p>
					<p>For every $10 add $1 for free. For every $1 free you need to put 2 bets before you withdraw the money.</p>
					<p style="text-align:right;"><a href="/promotions">Read more <i class="fa fa-angle-double-right"></i></a></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
