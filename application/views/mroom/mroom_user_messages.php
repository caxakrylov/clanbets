<div class="page-header">
	<div class="pull-left">
		<h1><?=$user->username?> - User messages</h1>
	</div>
	<div class="pull-right">

	</div>
</div>

<div class="box box-bordered box-color lightgrey">
	<div class="box-content nopadding">
		<div class="tab-content padding tab-content-inline tab-content-bottom">
			<div class="tab-pane active" id="maintable">
				<div class="box-content nopadding">
					<p>Username - <span class="editplayer2"><? echo $user->username.' ('.$user->utc.')';?></span>. Balance - <span class="editplayer2">$<?=$user->money?></span></p>

					<ul class="chat">
						<div id="wallmess">

						</div>
					</ul>

					<table class="tablesupport">
						<tbody>
							<tr>
								<td style="border-top:1px solid #ddd; padding-top:10px;">Message:</td>
							<tr>
								<td><textarea class="form-control" rows="3" name="usermessage" id="usermessage"></textarea></td>
							</tr>
							<tr>
								<td style="border-bottom:1px solid #ddd; padding-bottom:10px;">
									<button class="btn btn-primary" onclick="btnsendmessage(<?=$user->id?>);">Send</button>
									<span style="margin-left:5px;" class="label lred" id="messerror"></span>
								</td>
							</tr>
						</tbody>
					</table>


				</div>
			</div>
		</div>
	</div>
</div>

	<script type="text/javascript">

		$(document).ready(function(){
			refreshchat(<?=$user->id?>);
		});
	</script>
