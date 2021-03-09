<?= $this->extend('_partials/template') ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/vendor/datatables/datatables.min.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 37px;
	}
</style>
<?= $this->endSection() ?>
<?= $this->section('s-body') ?>
<div class="section-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<label for="nameBuyyer">Nama Pemesan</label>
							<select name="buyyer" id="buyyer" class="form-control">
								<option>-- Pilih salah satu --</option>
								<?php foreach($buyer as $buyyer) : ?>
									<option value="<?= $buyyer['id'] ?>"><?= $buyyer['name_full'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover" id="tables">
								<thead>
									<tr>
										<th>Nama Produk</th>
										<th>#</th>
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
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<form method="POST" id="inv">
							<div id="invdata"></div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<label for="note">Note/Ket</label>
							<input type="text" id='note' name="note" placeholder="Example : Invoice PO Sale 1" class="form-control">
						</div>
						<div class="form-group">
						<label for="total">Sub Total</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">
										Rp
									</div>
								</div>
								<input type="number" name="total" id="total" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary btn-block pdf"><i class="fas fa-file-pdf"></i> Export PDF</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	
</div>
<?= $this->endSection() ?>

<?= $this->section('bottom') ?>
<div class="modal fade" id="modalVar" tabindex="-1" role="dialog" aria-labelledby="labelVar" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labelVar">Pilih Variasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="addcartvar">
      	<div class="modal-body">
	      	<div class="form-group">
	      		<div class="selectgroup selectgroup-pills" id="variant"></div>
	      	</div>
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary add-var">Save changes</button>
	      </div>
      </form>
      
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<!-- Library -->
<?= $this->section('library') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url('assets/vendor/datatables/datatables.min.js') ?>"></script>
<script>
	$(document).ready(function() {	
		tbl_product();
		invlist();
		cartPlus();
		function tbl_product(){
			$.ajax({
				url 	: "<?= base_url('api/getProduct') ?>",
				type	: "GET",
				dataType: "JSON",
				success : (res)=>{
					html = "";
					for(var i = 0; i < res.length; i++){
						html +=
						`
						<tr>
							<td>${res[i].name}</td>
							<td><button data-id="${res[i].id}" type="button" class="btn btn-primary btn-sm btn-var"><i class="fas fa-cart-plus"></i></button></td>
						</tr>
						`;
					}
					$("#tbproduct").html(html);
				} 
			});
		}
		function invlist(){
			$.ajax({
				url 	: "<?= base_url('api/getCart/'.$uid) ?>",
				type 	: "GET",
				async   : false,
				dataType: "JSON",
				success : (res)=>{
					var html = "";
					for(var i = 0; i < res.length; i++){
						html +=
						`
						<div class="border rounded border-info p-4 mt-2">
						<a class='btn btn-danger text-white btn-sm btn-close-var' data-id='${res[i].cart_id}'><i class='fas fa-times'></i></a>
							<h5>${res[i].name_product}</h5>
							<a href="#" class="badge badge-primary">${res[i].name_sub_variant}</a>
							<div class="form-group row mt-1">
								<div class="col-6">
									<label for="qty"><b>Jumlah</b></label>
									<input type="number" name="qty[]" class="form-control" id="qty" value="1">
								</div>
								<div class="col-6">
									<label for="disc"><b>Diskon %</b></label>
									<input type="number" id="disc" name="disc[]" class="form-control" value="0">
								</div>
							</div>
							<div class='form-group row'>
								<div class="col-lg-6">
									<label for="variant">Variasi</label>
									<select class="form-control select2" name="variant[]">
										<option>-- Pilih salah satu --</option>
										<?php foreach($variant as $var) : ?>
										<option value="<?= $var['id'] ?>"><?= $var['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-lg-6">
									<label for='nameBuyyer'><b>Nama Pembeli</b></label>
									<input type='text' id='nameBuyyer' name='name_buyyer[]' placeholder='Example : Sukiman' class='form-control'>
								</div>
							</div>
							<input type='hidden' name='price[]' id='price' value='${res[i].price}'>
							<input type='hidden' name='var_id[]' id='var_id' value='${res[i].product_variant_id}'>
							<input type='hidden' name='cart_id[]' id='cart_id' value='${res[i].cart_id}'>
						</div>
						`;
					}
					$("#invdata").html(html);
				}
			});
		}
		function cartPlus(){
			$.ajax({
				url 	:	"<?= base_url('api/countTotal') ?>",
				type 	: 	"POST",
				dataType: 	"JSON",
				data 	: 	$("#inv").serialize(),
				success : 	(res)=>{
					if(res.success === true){
						$("#total").val(res.data);
					}
				}
			});
		}
		$("#invdata").on('keyup','#qty, #disc, #nameBuyyer',function(){
			cartPlus();
		});
		$("#invdata").on('click','.btn-close-var', function() {
			var id = $(this).data('id');
			Swal.fire({
				title : 'Yaqueen Mau Di Hapus ?',
				text  : 'Jika Dihapus Ya Data Nda Bisa Kembali',
				icon  : 'warning',
				showCancelButton : true
			}).then((result)=>{
				if(result.isConfirmed){
					$.ajax({
						url 	: "<?= base_url('api/deleteCart') ?>",
						type 	: "POST",
						dataType: "JSON",
						data 	: {id:id},
						success : (respo)=>{
							console.log(respo);
							invlist();
						}  
					});
				}
			});
		});
		$("#tbproduct").on('click','.btn-var',function(){
			$("#modalVar").modal('show');
			var id 		=	$(this).data('id');
			$.ajax({
				url 	: "<?= base_url('api/postGetVarProduct') ?>",
				type 	: "POST",
				dataType: "JSON",
				data 	: {id:id},
				success : (succ)=>{
					html 	=	"";
					for(var i = 0; i<succ.length; i++){
						html +=
						`
                        <label class="selectgroup-item">
                          <input type="checkbox" id='subvar' data-price='${succ[i].price}' name="product_variant_id[]" value="${succ[i].idvar}" class="selectgroup-input">
                          <span id="subVariant" class="selectgroup-button">${succ[i].name}</span>
                        </label>
						`;
					}
					$("#variant").html(html);
				}  
			});
		});
		$("#addcartvar").on('click','.add-var',function(){
			$.ajax({
				url 	: "<?= base_url('api/addCart') ?>",
				type 	: "POST",
				dataType: "JSON",
				data 	: $("#addcartvar").serialize(),
				success : (ok)=>{
					invlist();
					cartPlus();
					$("#modalVar").modal('hide');
				}   
			});
		});
		$("#tables").DataTable();
		$(".pdf").click(function() {
			$.ajax({
				url 	: "<?= base_url('api/trx') ?>",
				type 	: "POST",
				dataType: "JSON",
				data 	: $("#inv, #buyyer, #note, #total").serialize(),   
				success : (res)=>{
					if(res.success === true){
						Swal.fire('Sukses',res.data,'success').then((value)=>{
							if(value.isConfirmed){
								window.location = res.url;
							}
						});
					}else{
						Swal.fire('Gagal',res.data,'error');
					}
				} 
			});
		});
		$(".select2").select2();
	});
</script>
<?= $this->endSection() ?>