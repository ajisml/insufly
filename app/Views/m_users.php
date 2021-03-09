<?= $this->extend('_partials/template') ?>

<?= $this->section('s-body') ?>
	<div class="section-body">
		<div class="card">
			<div class="card-header">
				<h4>Kelola Pengguna</h4>
				<button class="btn btn-primary btn-sm btn-add" type="button"><i class="fas fa-plus"></i></button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Nama Pelanggan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="tblbuyer"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
	$(document).ready(function() {
		tb_buyer();
		function tb_buyer(argument) {
			$.ajax({
				type 	: "GET",
				url 	: "<?= base_url('api/getBuyyer') ?>",
				dataType: "JSON",
				async 	: false,
				success : (res)=>{
					var html="";
					for(var i = 0; i < res.length; i++){
						html +=
						`
						<tr>
							<td>${res[i].name_full}</td>
							<td>
								<button type="button" class="btn btn-primary btn-sm btn-edit" data-id="${res[i].id}" data-name="${res[i].name_full}"><i class="fas fa-edit"></i></button>
								<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${res[i].id}" data-name="${res[i].name_full}"><i class="fas fa-eraser"></i></button>
							</td>
						</tr>
						`;
					}
					$("#tblbuyer").html(html);
				}
			});
		}
		$(".btn-add").click(function(){
			Swal.fire({
			  title: 'Masukan Nama Pelanggan',
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/addBuyer') ?>",
			   	type 	: "POST",
			   	dataType: "JSON",
			   	data 	: {name:name},
			   	success : (ok)=>{

			   	}
			   });
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.isConfirmed) {
			  	tb_buyer();
			    Swal.fire(
			    	'Sukses Disimpan',
			    	'Data Berhasil Disimpan',
			    	'success',
			    );
			  }
			});
		});
		$("#tblbuyer").on('click','.btn-delete',function() {
			var id 		=	$(this).data('id');
			Swal.fire({
				title 	: "Yaqueen Mau Dihapus Nih ?",
				text 	: "Kalo Bener, Berarti Kamu Setuju Kalo Ada Nda Bisa Kembali Lagi",
				icon 	: "warning",
				showCancelButton : true,  
			}).then((value)=>{
				if(value.isConfirmed){
					$.ajax({
						type 	: 	"POST",
						url 	: 	"<?= base_url('api/deleteBuyyer') ?>",
						dataType: 	"JSON",
						data 	: 	{id:id},
						success : 	(respon)=>{
							if(respon.success === true){
								tb_buyer();
								Swal.fire(
									'Data Sukses Dihapus',
									respon.data,
									'success'
								);
							}
						}
					});
				}
			});
		});
		$("#tblbuyer").on('click','.btn-edit', function(){
			var name 	=	$(this).data('name');
			var id 		=	$(this).data('id')
			Swal.fire({
			  title: 'Ubah Nama '+name,
			  input: 'text',
			  inputAttributes: {
			    autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Simpan',
			  showLoaderOnConfirm: true,
			  preConfirm: (name) => {
			   $.ajax({
			   	url 	: "<?= base_url('api/updateBuyer') ?>",
			   	type 	: "POST",
			   	dataType: "JSON",
			   	data 	: {name:name,id:id},
			   	success : (ok)=>{

			   	}
			   });
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.isConfirmed) {
			  	tb_buyer();
			    Swal.fire(
			    	'Sukses Diubah',
			    	'Data Berhasil Diubah',
			    	'success',
			    );
			  }
			});
		});
	});
</script>
<?= $this->endSection() ?>