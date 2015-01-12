
<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="notifications-table">
		<?php if(count($data->notifications) == 0 ) {?>
			No messages found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th>Subject</th>
				<th>Date Sent</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Welcome</td>
				<td>Sun 12 2014</td>
			</tr>
			<tr>
				<td>Important Update</td>
				<td>Sun 12 2014</td>
			</tr>
			<tr>
				<td>Welcome</td>
				<td>Sun 12 2014</td>
			</tr>
		</tbody>
		<?php } //end if-else block?>
	</table>

</div>