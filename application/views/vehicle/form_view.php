<link href="<?php echo base_url('resources/plugins/select2/css/select2.min.css');?>" rel="stylesheet" >
<link href="<?php echo base_url('resources/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" >
<style type="text/css">
	.img-responsive.loading {
		width: 55%;
		padding-left: 60px;
	}
</style>
<form>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<h4 class="modal-title"><?php echo $title; ?></h4>
	</div>

	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
            	<div class="col-md-4"></div>
            	<div class="col-md-4">
            		<img src="<?php echo base_url('resources/images/tenor.gif') ?>" class="img-responsive loading hidden">
            	</div>
            	<div class="col-md-4">
            		<input type="button" class="btn btn-flat btn-danger pull-right" name="add_item" id="add_item" value="Add Item">
            	</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<table class="table table-condensed table-striped table-bordered">
					<thead>
						<tr>
							<th>Name</th>
							<th>Employee No.</th>
							<th>Date Time</th>
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
			<button type="button" class="btn btn-flat btn-info pull-left" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>

			<button type="button" class="btn btn-flat btn-success" id="btn-save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
		</div>
	</div>
	
</form><!-- End Form -->
<script src="<?php echo base_url('resources/plugins/select2/js/select2.min.js');?>"></script>
<script src="<?php echo base_url('resources/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// $('#occurence-date').datepicker();
		$('.select2').select2();

		const appUrl         = "<?php echo base_url('index.php/') ?>";
		const $table_content = $('#table-content');
		const $add_btn       = $('#add_item');
		let itemObj          = [];
		let counter          = 1;


		$add_btn.on('click', function() {
			let markup = '';

			markup += '<tr id="' + counter + '">';
				markup += '<td>';
					markup += '<select class="select2 employee_id" name="emp_id">';
						markup += '<?php foreach($entities as $entity): ?>';
							markup += '<option value="<?php echo $entity['id'] ?>"><?php echo $entity['fullname'] ?></option>'		
						markup += '<?php endforeach ?>';
					markup += '</select>';
				markup += '</td>';

				markup += '<td class="emp_no"></td>';

				markup += '<td>';			
					markup += '<div class="input-group date form_datetime" data-date="<?php echo date('m/d/Y h:i A') ?>" data-date-format="mm/dd/yyyy HH:ii P" >';
						markup += '<input class="form-control occurence-date" size="16" type="text" value="" readonly >';
						markup += '<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>';
						markup += '<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>';
					markup += '</div>'
					markup += '<input type="hidden" value="" />';
				markup += '</td>';
			markup += '</tr/>';

			$table_content.append(markup);

			counter++;
		});

		$(document).on('click', 'select', function () {             
		    $(this).select2();
		});


		$(document).on('change', 'select', function() {
			const $self = $(this);
			let $tr     = $self.parent().parent();

			$.post(appUrl + 'vehicle/ajaxFetchEmpNo', { employee_id: $self.val() })
			.done(function(data) {
				let result = JSON.parse(data);

				$tr.find('.emp_no').html(result['employee_no']);
			});
			
		});

		$(document).on('click', '.form_datetime', function () {             
		    $(this).datetimepicker({
		    	weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
		        showMeridian: 1
		    });
		});

		$('#btn-save').on('click', function() {
			$('.loading').removeClass('hidden');

			// Push ID to item Object
			$('.employee_id').each(function(i) {
				itemObj.push({employee_id: $(this).select2('data')[0]['id']})
			});


			// Override the object
			$('.occurence-date').each(function(i) {
				itemObj[i]['occurence_date'] = $(this).val();
			});

			if (itemObj.length > 0)
			{
				$.post(appUrl + 'vehicle/ajaxSaveItems', { data: itemObj })
				.done(function(data) {
					$('.loading').addClass('hidden');
					location.reload(); 
				});
			}
			else
			{
				alert('No data to be processed');
			}

		});



	});
</script>
