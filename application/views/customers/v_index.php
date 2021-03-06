<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php $this->load->view("components/main/_head"); ?>
<!-- ./head -->

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<!-- navbar -->
			<?php $this->load->view("components/main/_navbar"); ?>
			<!-- ./navbar -->
			<!-- sidebar -->
			<?php $this->load->view("components/main/_sidebar"); ?>
			<!-- ./sidebar -->

			<!-- Main Content -->
			<div class="main-content">
				<section class="section">
					<div class="section-header d-flex justify-content-between">
						<h1><?= $title; ?></h1>
						<a href="<?= base_url("customer/create") ?>" class="btn btn-primary btn-lg">Tambah Customer</a>
					</div>
					<!-- alert flashdata -->
					<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
					<!-- end alert flashdata -->
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped" id="table-1">
											<thead>
												<tr>
													<th class="text-center">
														No
													</th>
													<th>Kode Customer</th>
													<th>Nama Customer</th>
													<th>E-mail Customer</th>
													<th>No HP Customer</th>
													<th>Alamat Customer</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1; ?>
												<?php foreach ($customers as $customer) : ?>
													<tr>
														<td><?= $no++; ?></td>
														<td><?= $customer["customer_code"] ?></td>
														<td><?= $customer["customer_name"] ?></td>
														<td><?= $customer["customer_email"] ?></td>
														<td><?= $customer["customer_phone"] ?></td>
														<td><?= $customer["customer_address"] ?></td>
														<td>
															<!-- <a href="" class="btn btn-icon btn-info"><i class="fas fa-eye"></i></a> -->
															<a href="<?= base_url("customer/update/" . $customer["id_customer"]) ?>" class="btn btn-icon btn-warning"><i class="fas fa-pencil-alt"></i></a>
															<a href="<?= base_url("customer/delete/" . $customer["id_customer"]) ?>" class="btn btn-icco btn-danger btn-delete"><i class="fas fa-trash"></i></a>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<!-- footer -->
			<?php $this->load->view("components/main/_footer"); ?>
			<!-- ./footer -->
		</div>
	</div>


	<!-- scripts -->
	<?php $this->load->view("components/main/_scripts"); ?>
	<!-- ./scripts -->

</body>

</html>
