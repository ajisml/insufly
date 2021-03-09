<?= $this->extend('_partials/template') ?>
<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/selectric.css') ?>">
<?= $this->endSection() ?>
<?= $this->section('s-body') ?>
	<div class="section-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h4>Buat Produk</h4>
					</div>
					<div class="card-body">
						<form method="POST">
							<div class="form-group">
								<label for="nameProduct">Nama Produk</label>
								<input type="text" class="form-control" id="nameProduct">
							</div>
							<div class="form-group">
								<label for="categoryProduct">Kategori</label>
								<select name="category" id="categoryProduct" class="form-control selectric">
									<option value="">-- Pilih salah satu --</option>
									<?php foreach($category as $cat) : ?>
									<option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<button class="btn btn-success btn-add" type="button"><i class="fas fa-paper-plane"></i> Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">
						<h4>Tambah Variasi</h4>
						<button class="btn btn-primary add-variant" type="button"><i class="fas fa-plus"></i></button>
					</div>
				</div>
				<form method="POST" id="card-variasi"></form>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Daftar Produk</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Nama Produk</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody id="tbproduct">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>
<?= $this->section('bottom') ?>
<!-- Modal Product -->
<div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="labelProduct" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelProduct">Edit Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="frmproduct">
	      <div class="modal-body">
	      	<input type="hidden" id="idProduct">
        	<div class="form-group">
        		<label for="nameProduct">Nama Produk</label>
        		<input type="text" placeholder="Masukan Nama Produk" class="form-control" id="nameProductModal">
        	</div>
        	<div class="form-group">
        		<label for="categoryProduct">Kategori</label>
        		<select name="category" class="form-control" id="categoryModal">
        			<option>-- Tunggu Sebentar --</option>
        		</select>
        	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary btn-edit">Save changes</button>
	      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Variant Product -->
<div class="modal fade" id="modalVariantProduct" tabindex="-1" role="dialog" aria-labelledby="labelVariantProduct" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelVariantProduct">Edit Produk Variant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="frmvariant">
	      <div class="modal-body">
	      	<div class="modalVariant"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary btn-edit">Save changes</button>
	      </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
	<script src="<?= base_url('assets/js/jquery.selectric.min.js') ?>"></script>
	<script>
		$(document).ready(function(){
			tbl_product();
			function tbl_product(){
				$.ajax({
					type 	: 	"GET",
					url 	: 	"<?= base_url('api/getProduct') ?>",
					dataType: 	"JSON",
					success : 	(res)=>{
						var html="";
						for(var i =0;i<res.length;i++){
							html += 
							`
							<tr>
								<td>${res[i].name}</td>
								<td>
									<button title="Edit Data Produk" type='button' data-name='${res[i].name}' data-id='${res[i].id}' class='btn btn-primary btn-sm btn-edit'><i class='fas fa-archive'></i></button>
									<button data-id="${res[i].id}" title="Detail Variasi Dan Edit Variasi" class="btn btn-warning btn-stok btn-sm"><i class="fas fa-bars"></i></button>
									<button type='button' data-id='${res[i].id}' class='btn btn-danger btn-sm btn-delete'><i class='fas fa-eraser'></i></button>
								</td>
							</tr>
							`;
						}
						$("#tbproduct").html(html);
					} 
				});
			}
			$(".btn-add").click(function(){
				var name 	=	$("#nameProduct").val();
				var price 	=	$("#priceProduct").val();
				var category= 	$("#categoryProduct").val();
				$.ajax({
					url 	: 	"<?= base_url('api/addProduct') ?>",
					type 	: 	"POST",
					dataType: 	"JSON",
					data 	: 	{name:name,category:category},
					success : 	(respon)=>{
						if(respon.success === true){
							$.ajax({
								url 	: "<?= base_url('api/addProductVariant') ?>"+"/"+respon.id,
								type 	: "POST",
								dataType: "JSON",
								data 	: $("#card-variasi").serialize(),
								success : (res)=>{
									console.log(res);
								}
							});
							Swal.fire(
								'Berhasil Di Upload',
								'Data Produk Berhasil Di Upload',
								'success'
							).then((result)=>{
								location.reload();
							});
							tbl_product();
						}else{
							Swal.fire(
								'Duh Gagal',
								respon.data,
								'error'
							);
						}
					} 
				});
			});
			$("#tbproduct").on('click','.btn-delete', function() {
				var id 		=	$(this).data('id');
				Swal.fire({
					title 	: "Yaqueen Mau Dihapus ?",
					text 	: "Kalo Dihapus Data Nda Bisa Kembali",
					icon 	: "warning",
					showCancelButton : true,
				}).then((value)=>{
					if(value.isConfirmed){
						$.ajax({
							url 	: "<?= base_url('api/dProduct') ?>",
							type 	: "POST",
							dataType: "JSON",
							data 	: {id:id},
							success : (res)=>{
								if(res.success == true){
									Swal.fire(
										'Wow! Data Berhasil Dihapus',
										res.data,
										'success'
									);
									tbl_product();
								}
							}   
						});
					}
				});
			});
			$("#tbproduct").on('click','.btn-edit', function() {
				var id 		=	$(this).data('id');
				var name 	=	$(this).data('name');
				$("#nameProductModal").val(name);
				$("#idProduct").val(id);
				$.ajax({
					url 	: "<?= base_url('api/getCatProduk') ?>"+"/"+id,
					type 	: "GET",
					dataType: "JSON",
					success : (ok)=>{
						$("#categoryModal").html(`
						<option value="${ok.id}">${ok.name}</option>
						option
						<?php foreach($category as $cat) : ?>
						<option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
						<?php endforeach; ?>
						`);
					
					}   
				});
				$("#modalProduct").modal('show');
				
			});
			$("#frmproduct").on('click','.btn-edit', function() {
				var id 		=	$("#idProduct").val();
				var name 	=	$("#nameProductModal").val();
				var cat 	=	$("#categoryModal").val();
				$.ajax({
					url 	: "<?= base_url('api/updateProduct') ?>", 
					type 	: "POST",
					dataType: "JSON",
					data 	: {name:name,cat:cat,id:id},
					success : (res)=>{
						if(res.success === true){
							Swal.fire(
								'Sukses Di Update',
								res.data,
								'success'
							).then((value)=>{
								location.reload();
							});
						}
					}  
				});
			});
			// Variant
			$("#tbproduct").on('click','.btn-stok',function(){
				var id 		=	$(this).data('id');
				$("#modalVariantProduct").modal('show');
				//console.log(id);
				$(".modalVariant").load(`<?= base_url('api/getVarIdProduct/') ?>/${id}`);
			});
			$(".add-variant").click(function() {
				$("#card-variasi").append(`
					<div class="card wrap-variant">
					<button type="button" class="btn-x"><i class="fas fa-times"></i></button>
						<div class="card-body">
							<div class="form-group row">
								<div class="col-lg-12">
									<select class="form-control" id="variantProduct" name="variant[]">
										<option>-- Pilih salah satu --</option>
										<?php foreach($variant as $var) : ?>
											<option value="<?= $var['id'] ?>"><?= $var['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<input type="number" class="form-control" id="priceProduct" name="price[]">
							</div>
						</div>
					</div>
				`);
			});
			$("#card-variasi").on('click','.btn-x',function(){
				$(this).parent('.wrap-variant').remove();
			});
			$("#frmvariant").on('click','.btn-edit', function() {
				$.ajax({
					url 	: "<?= base_url('api/updateProductVar') ?>",
					type 	: "POST",
					dataType: "JSON",
					data 	: $("#frmvariant").serialize(),
					success : (res)=>{
						console.log(res);
						tbl_product();
						Swal.fire(
							'Sukses Di Update',
							'Kamu Berhasil MengUpdate Data Variant Product',
							'success'
						);
					} 
				});
			});
		});
	</script>
<?= $this->endSection() ?>