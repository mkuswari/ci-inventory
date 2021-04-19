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
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-8 mx-auto">
											<form action="<?= base_url("incomingitem/create") ?>" method="post">
												<div class="form-group">
													<label for="incoming_item_code">Kode Transaksi</label>
													<input type="text" class="form-control" name="incoming_item_code" id="incoming_item_code" placeholder="Kode Barang" value="<?= $incoming_item_code ?>" readonly>
												</div>
												<div class="form-group">
													<label for="id_supplier">Supplier</label>
													<select name="id_supplier" id="id_supplier" class="form-control select2">
														<option value="" disabled selected>--Pilih Supplier--</option>
														<?php foreach ($suppliers as $supplier) : ?>
															<option value="<?= $supplier["id_supplier"] ?>"><?= $supplier["supplier_code"] ?> | <?= $supplier["supplier_name"] ?></option>
														<?php endforeach; ?>
													</select>
													<?= form_error('id_category', '<div class="invalid-feedback font-weight-bold pl-1">', '</div>') ?>
												</div>
												<div class="form-group">
													<label for="id_items">Barang</label>
													<select name="id_items" id="ItemId" class="form-control select2">
														<option value="" disabled selected>--Pilih Barang--</option>
														<?php foreach ($items as $item) : ?>
															<option value="<?= $item["id_item"] ?>" data-stock="<?= $item["item_stock"] ?>"><?= $item["item_code"] ?> | <?= $item["item_name"] ?></option>
														<?php endforeach; ?>
													</select>
													<?= form_error('id_category', '<div class="invalid-feedback font-weight-bold pl-1">', '</div>') ?>
												</div>
												<div class="form-group">
													<label for="item_stock">Stock Barang</label>
													<input type="number" class="form-control <?= form_error('item_stock') ? 'is-invalid' : ''; ?>" name="item_stock" id="ItemStock" placeholder="Stock Barang" readonly>
													<?= form_error('item_stock', '<div class="invalid-feedback font-weight-bold pl-1">', '</div>') ?>
												</div>
												<div class="form-group">
													<label for="incoming_item_qty">Jumlah Stok Masuk</label>
													<input type="number" class="form-control <?= form_error('incoming_item_qty') ? 'is-invalid' : '' ?>" name="incoming_item_qty" id="IncomingItemQty" placeholder="Jumlah Stok Masuk">
												</div>
												<div class="form-group">
													<label for="item_stock_total">Jumlah Total Stock</label>
													<input type="number" class="form-control <?= form_error('item_stock_total') ? 'is-invalid' : ''; ?>" name="item_stock_total" id="ItemStockTotal" placeholder="Jumlah Total Stock" readonly>
													<?= form_error('item_stock_total', '<div class="invalid-feedback font-weight-bold pl-1">', '</div>') ?>
												</div>
												<hr>
												<div class="form-action">
													<button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
													<button type="reset" class="btn btn-warning btn-lg">Reset Form</button>
												</div>
											</form>
										</div>
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
	<script>
		$(document).ready(function() {
			$('#ItemId').change(function(e) {
				e.preventDefault();
				var id = $(this).attr('id');
				var stock = $("#" + id + " option:selected").data('stock');
				$('#ItemStock').val(stock);
				var stockIn = $('#IncomingItemQty').val();
				var totalStock = stock + stockIn;
				$('#ItemStockTotal').val(totalStock);
			})

		});
	</script>

</body>

</html>
