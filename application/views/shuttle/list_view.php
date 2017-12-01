<!-- Items block -->
<section class="content late-shuttle">
	<!-- row -->
	<div class="row">
		<!-- col-md-6 -->
		<div class="col-md-6">
			<!-- Box danger -->
			<?php echo $this->session->flashdata('message'); ?>

			<div class="box box-danger">
				<!-- Content -->
				<div class="box-header with-border">
					<a href="<?php echo base_url('index.php/shuttle/form') ?>" data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false">
						<button class="btn btn-flat btn-success pull-right" >File Late Shuttle <i class="fa fw fa-plus" aria-hidden="true"></i></button>
					</a>
				</div>

				<div class="box-body">
					<!-- Item table -->
					<table class="table table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Shuttle Code</th>
								<th>Destination</th>
								<th>Date</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							<?php $count = 1; ?>
							<?php foreach ($entities as $entity): ?>
								<tr>
									<?php $date = date('m/d/Y h:i A', strtotime($entity['occurence_date'])); ?>
									<td><?php echo $count; ?></td>
									<td><?php echo $entity['shuttle_code']; ?></td>
									<td><?php echo $entity['area']; ?></td>
									<td><?php echo $date ?></td>
									<td>
										<a href="<?php echo base_url('index.php/shuttle/view_item/' . $entity['shuttle_code'] . '/' . date('Y-m-d', strtotime($entity['occurence_date']))); ?>" data-toggle="modal" data-target=".bs-example-modal-sm">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</a>
									</td>
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
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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