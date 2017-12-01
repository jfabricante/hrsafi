<link href="<?php echo base_url('resources/plugins/select/css/bootstrap-select.min.css');?>" rel="stylesheet" >
<link href="<?php echo base_url('resources/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" >
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
	                <label for="dtp_input1">DateTime</label>
	                <div class="input-group date form_datetime" data-date="<?php echo date('m/d/Y h:i A') ?>" data-date-format="mm/dd/yyyy HH:ii P" data-link-field="dtp_input1">
	                    <input class="form-control" size="16" id="occurence-date" type="text" value="" readonly >
	                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	                </div>
					<input type="hidden" id="dtp_input1" value="" /><br/>
	            </div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="destination">Destination</label>
					<select name="destination" id="destination" class="form-control selectpicker" data-live-search="true">
						<option></option>

						<?php foreach($areas as $row): ?>
							<option value="<?php echo $row->shuttle_code; ?>" <?php echo isset($entity->shuttle_code) ? $entity->shuttle_code == $row->shuttle_code ? 'selected' : '' : ''; ?> >
								<?php echo $row->area; ?>
							</option>
						<?php endforeach; ?>
					</select>
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
							<th>Emp ID</th>
							<th>Validate</th>
						</tr>
					</thead>

					<tbody id="table-content">
						
					</tbody>
				</table>
			</div>
		</div>

	</div>
	
	<div class="modal-footer">
		<div class="form-group">
			<button type="button" class="btn btn-flat btn-info" data-dismiss="modal">Close</button>
		</div>
	</div>
	
</form><!-- End Form -->
<script src="<?php echo base_url('resources/plugins/select/js/bootstrap-select.min.js');?>"></script>
<script src="<?php echo base_url('resources/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// $('#occurence-date').datepicker();
		$('#destination').selectpicker();

		const appUrl          = "<?php echo base_url('index.php/') ?>";
		const $table_content  = $('#table-content');
		const $occurence_date = $('#occurence-date');
		const $destination    = $('#destination');
		const $lock_btn       = $('#lock-btn');

		$destination.on('change', function() {
			let $self = $(this);

			$.post(appUrl + 'shuttle/ajaxFetchPassenger', { shuttle_code: $self.val(), occurence_date: $occurence_date.val() })
			.done(function(data) {
				$table_content.html(data)
			});
		});

		$(document).on('click', '.validate', function() {
			let $self = $(this);

			$.post(appUrl + 'shuttle/ajaxFileLateShuttle', { employee_id: $self.val(), occurence_date: $occurence_date.val(), shuttle_code: $destination.val() })
			.done(function(data) {
				console.log(data);
			});
		});


		$('.form_datetime').datetimepicker({
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1
	    });
	});
</script>
