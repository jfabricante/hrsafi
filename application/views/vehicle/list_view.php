<!-- Items block -->
<section class="content private-vehicle">
	<!-- row -->
	<div class="row">
		<!-- col-md-6 -->
		<div class="col-md-6">
			<!-- Box danger -->
			<?php echo $this->session->flashdata('message'); ?>

			<div class="box box-danger">
				<!-- Content -->
				<div class="box-header with-border">
					<a href="<?php echo base_url('index.php/vehicle/form') ?>" data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false">
						<button class="btn btn-flat btn-success pull-right" >Add Vehicle Item <i class="fa fw fa-plus" aria-hidden="true"></i></button>
					</a>
				</div>

				<div class="box-body">
					<!-- Item table -->
					<table class="table table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Employee No.</th>
								<th>Date</th>
							</tr>
						</thead>

						<tbody>
							<?php $count = 1; ?>
							<?php foreach ($entities as $entity): ?>
								<tr>
									<?php $date = date('m/d/Y h:i A', strtotime($entity['occurence_date'])); ?>
									<td><?php echo $count; ?></td>
									<td><?php echo $entity['fullname']; ?></td>
									<td><?php echo $entity['employee_no']; ?></td>
									<td><?php echo $date ?></td>
								</tr>
								<?php $count++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					<!-- End of table -->
				</div>
				<!-- End of content -->
			</div>
			<!-- End of danger -->
		</div>
		<!-- End of col-md-6 -->
	</div>
	<!-- End of row -->
</section>
<div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.table').DataTable();
	});

	// Detroy modal
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});

</script>