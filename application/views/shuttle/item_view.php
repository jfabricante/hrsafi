<?php 
	/*echo '<pre>';
	print_r($is_locked);
	echo '</pre>';*/
?>
<link href="<?php echo base_url('resources/plugins/select/css/bootstrap-select.min.css');?>" rel="stylesheet" >
<link href="<?php echo base_url('resources/plugins/datepicker/css/bootstrap-datepicker.min.css');?>" rel="stylesheet" >
<form>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<h4 class="modal-title"><?php echo $title; ?></h4>
	</div>

	<div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="occurence-date">Date</label>
					<input type="text" class="form-control datepicker" id="occurence-date" name="occurence-date" readonly value="<?php echo date('m/d/Y h:i A', strtotime($entities[0]['occurence_date'])) ?>" required>
				</div>	
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="destination"></label>
					<input type="text" class="form-control" id="destination" readonly name="destination" value="<?php echo $entities[0]['area']?>" required>

					<input type="text" class="form-control hidden" id="shuttle-code" readonly name="shuttle-code" value="<?php echo $entities[0]['shuttle_code']?>" required>
				</div>	
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table class="table table-condensed table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Employee No.</th>
							<th>Validate</th>
						</tr>
					</thead>

					<tbody>
						<?php $count = 1; ?>
						<?php foreach ($passengers as $entity): ?>
							<tr>
								<td><?php echo $count ?></td>
								<td><?php echo $entity['fullname'] ?></td>
								<td><?php echo $entity['employee_no'] ?></td>
								<td><input type="checkbox" name="validate" class="validate" value="<?php echo $entity['id'] ?>" <?php echo in_array($entity['id'], $employee_ids) ? 'checked' : '' ?> <?php echo count($is_locked) ? 'disabled' : '' ?>></td>
							</tr>
							<?php $count++ ?>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
	
	<div class="modal-footer">
		<div class="form-group">
			<button type="button" class="btn btn-flat btn-info pull-left" data-dismiss="modal">Close</button>

			<button type="button" class="btn btn-flat btn-danger" id="lock-btn">Lock Items</button>
		</div>
	</div>
	
</form><!-- End Form -->
<script src="<?php echo base_url('resources/plugins/select/js/bootstrap-select.min.js');?>"></script>
<script src="<?php echo base_url('resources/plugins/datepicker/js/bootstrap-datepicker.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		const appUrl          = "<?php echo base_url('index.php/') ?>";
		const $occurence_date = $('#occurence-date');
		const $shuttle_code   = $('#shuttle-code');
		const $lock_btn       = $('#lock-btn');
		const $validate       = $('.validate');

		$(document).on('click', '.validate', function() {
			let $self = $(this);

			$.post(appUrl + 'shuttle/ajaxFileLateShuttle', { employee_id: $self.val(), occurence_date: $occurence_date.val(), shuttle_code: $shuttle_code.val() })
			.done(function(data) {
				console.log(data);
			});
		});

		$lock_btn.on('click', function() {
			let $self = $(this);

			$.post(appUrl + 'shuttle/ajaxLockItems', { occurence_date: $occurence_date.val(), shuttle_code: $shuttle_code.val() })
			.done(function(data) {
				console.log(data);

				$.each($validate, function() {
					$(this).prop('disabled', true)
				});
			});
		})
	});
</script>
