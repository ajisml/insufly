<?php namespace App\Controllers;

	use CodeIgniter\Controller;
	use App\Models\globalModel;
	use Mpdf\Mpdf;

	class Api extends Controller{
		public function __construct()
		{
		    $this->username		=	session()->get('username');
		    $this->uid 			=	session()->get('id');
		    $this->model 		=	new globalModel();
		    helper('inv');
		}
		// Trx
		public function deleteInvoice()
		{
			if(!$this->request->isAjax()){
				$notif			=
				[
					'success'	=>	406,
					'data'		=>	null
				];
			}else{
				$id 			=	$this->request->getPost('id');
				$getInv 		=	$this->model->getInv($id);
				$deleteTrx 		=	$this->model->deleteTrx($getInv['code_invoice']);
				$deleteInv 		=	$this->model->deleteInv($id);
				if($deleteInv){
					$notif 		=	
					[
						'success'	=>	true,
						'data'		=>	'Data berhasil dihapus'	
					];
				}else{
					$notif 		=	
					[
						'success'	=>	false,
						'data'		=>	null	
					];
				}
			}
			echo json_encode($notif);
		}
		public function trx()
		{
			if($this->request->isAjax()){
				$variantProductID 	=	$this->request->getPost('var_id');
				$cartId 			=	$this->request->getPost('cart_id');
				$variantId 			=	$this->request->getPost('variant');
				$price 				=	$this->request->getPost('price');
	    		$buyerId 			=	$this->request->getPost('buyyer');
	    		$nameBuyer 			=	$this->request->getPost('name_buyyer');
	    		$disc 				=	$this->request->getPost('disc');
	    		$qty 				=	$this->request->getPost('qty');
	    		$note 				=	$this->request->getPost('note');
	    		$total 				=	$this->request->getPost('total');
	    		$count 				=	count($variantProductID);
	    		$codeInv 			=	"NHS".invoice(8);
	    		for($i = 0; $i < $count; $i++){
	    			$data 			=
	    			[
						'product_variant_id'	=>	$variantProductID[$i],
						'variant_id'			=>	$variantId[$i],
	    				'pelanggan_id'			=>	$buyerId,
	    				'name_buyer'			=>	$nameBuyer[$i],
						'qty'					=>	$qty[$i],
						'disc'					=>	$disc[$i],
	    				'code_invoice'			=>	$codeInv
	    			];
	    			$save 			=	$this->model->addTrx($data);
	    		}
	    		$dataInv 			=
	    		[
	    			'pelanggan_id'	=>	$buyerId,
	    			'code_invoice'	=>	$codeInv,
	    			'other_cut'		=>	0,
	    			'date_at'		=>	date('Y-m-d'),
	    			'note'			=>	$note,
	    			'total'			=>	$total,
	    		];
	    		$saveInv 			=	$this->model->addInv($dataInv);
	    		$getInv 			=	$this->model->getInv($saveInv);
	    		if($saveInv){
	    			for($x = 0; $x < $count; $x++){
		    			$deleteCartId =	$this->model->deleteCart($cartId[$x]);
		    		}
	    			$notif 			=
	    			[
	    				'success'	=>	true,
	    				'data'		=>	'Berhasil Disimpan',
						'url'		=>	base_url('export/pdf/'.$getInv['code_invoice']),
	    			];
	    		}else{
	    			$notif 			=
	    			[
	    				'success'	=>	false,
	    				'data'		=>	null,
	    				'url'		=>	null
	    			];
	    		}

			}else{
				$notif 			=
    			[
    				'success'	=>	false,
    				'data'		=>	null,
    				'url'		=>	null
    			];
			}
			echo json_encode($notif);
		}
		// Cart
		public function countTotal()
		{
			if(!$this->request->isAjax()){
				$notif 			=
				[
					'success'	=>	false,
					'data'		=>	null	
				];
			}else{
				if(!empty($this->request->getPost('qty'))){
					$qty 		=	$this->request->getPost('qty');
				}else{
					$qty 		=	"0";
				}
				if(!empty($this->request->getPost('qty'))){
					$disc 			=	$this->request->getPost('disc');
				}else{
					$disc 		=	"0";
				}
				$price 			=	$this->request->getPost('price');
				$count			=	count($qty);
				$total 			=	0;
				for($i = 0; $i < $count; $i++){
					$qtyTotal 	=	$price[$i] * $qty[$i];
					$discs 		=	(($qtyTotal*$disc[$i])/100);
					$totalDisc  = 	$qtyTotal - $discs;
					$total 		+= 	$totalDisc;
				}
					
				$notif 			=
				[
					'success'	=>	true,
					'data'		=>	$total	
				];
			}
			echo json_encode($notif);
		}
		public function deleteCart()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$delete 		=	$this->model->deleteCart($id);
				if($delete){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Dihapus'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Silahkan Coba Lagi'
					];
				}
				echo json_encode($notif);
			}
		}
		public function getCart($id=null)
		{
			if($id !== null){
				$getCart 		=	$this->model->getCart($id);
				echo json_encode($getCart);
			}
		}
		public function addCart()
		{
			if(!empty($this->request->getPost('product_variant_id'))){
				$getId 			=	$this->request->getPost('product_variant_id');
				$countId 		=	count($getId);
				for($i=0;$i<$countId;$i++){
					$data 		=
					[
						'product_variant_id'	=>	$getId[$i],
						'users_id'				=>	$this->uid,
					];
					$save 		=	$this->model->insertUpdateCart($data, null);
				}
				echo json_encode(['success'=>true,'data'=>null]);
			}
		}
		// Buyyer
		public function deleteBuyyer()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$delete 		=	$this->model->deleteBuyyer($id);
				if($delete){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Dihapus'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Gagal Silahkan Coba Lagi'
					];
				}
				echo json_encode($notif);
			}
		}
		public function updateBuyer()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name_full'	=>	$name
				];
				$update 		=	$this->model->CreateUpdateBuyer($data, $id);
				if($update){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Diubah'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Gagal Silahkan Coba Lagi'
					];
				}
				echo json_encode($notif);
			}
		}
		public function getBuyyer()
		{
			$getBuy 			=	$this->model->getBuyyer();
			echo json_encode($getBuy);
		}
		public function addBuyer()
		{
			if(!empty($this->request->getPost('name'))){
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name_full'		=>	$name
				];
				$save 			=	$this->model->CreateUpdateBuyer($data, null);
				if($save){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Disimpan'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Gagal Silahkan Coba Lagi'
					];
				}
				echo json_encode($notif);
			}
		}
		// Category
		public function addCat()
		{
			if(!empty($this->request->getPost('name'))){
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name'		=>	$name
				];
				$save 			=	$this->model->CreateUpdateCat($data, null);
				if($save){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Di Simpan'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Silahkan Coba Lagi'
					];
				}
			}
		}
		public function deleteCat()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$delete 		=	$this->model->deleteCat($id);
				if($delete){
					$data 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Kategori Berhasil Kamu Hapus ~Yo'
					];
				}else{
					$data 		=
					[
						'success'	=>	false,
						'data'		=>	'Terjadi Kesalahan Sistem, Silahkan Coba Lagi'
					];
				}
				echo json_encode($data);
			}
		}
		public function updateCat()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$name 			=	$this->request->getPost('name');
				$data 			=	
				[
					'name'		=>	$name
				];
				$update 		=	$this->model->CreateUpdateCat($data, $id);
				if($update){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Diubah'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Silahkan Coba Lagi'
					];
				}
				echo json_encode($notif);
			}
		}
		public function getCatProduk($id)
		{
			if(!empty($id)){
				$getProduct 		=	$this->model->getProduct($id);
				$getCat 			=	$this->model->getCat($getProduct['category_id']);
				echo json_encode($getCat);
			}
		}
		public function getCat($id=null)
		{
			if($id !== null){
				$getCategory  		=	$this->model->getCat($id);
			}else{
				$getCategory  		=	$this->model->getCat();
			}
			echo json_encode($getCategory);
		}
		// Variant
		public function postGetVarProduct()
		{
			if(!empty($this->request->getPost('id'))){
				$id 				=	$this->request->getPost('id');
				$getProductVar 		=	$this->model->getIdProductVariantJoin($id);
				echo json_encode($getProductVar);
				
			}
		}
		public function addProductVariant($id)
		{
			if($id !== "0"){
				$getPrice 			=	$this->request->getPost('price');
				$getVariant 		=	$this->request->getPost('variant');
				$countVar 			=	count($getVariant);
				for($i=0;$i<$countVar;$i++){
					$data 			=
					[
						'product_id'	=>	$id,
						'sub_variant_id'=>	$getVariant[$i],
						'price'			=>	$getPrice[$i]
					];
					$saveVariant 	=	$this->model->insertProductVariant($data);
					echo json_encode($saveVariant);
				}
			}
			
		}	
		public function addsubvar()
		{
			if(!$this->validate([
				'name'			=>	'required',
			])){
				$notif 			=
				[
					'success'	=>	false,
					'data'		=>	'Maaf Nama dan Harga Wajib Diisi'
				];
			}else{
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name'		=>	$name,
				];
				$save 			=	$this->model->saveSubvar($data);
				if($save){
					$notif 		=
					[
						'success'	=>	true,
						'data'		=>	'Hore! Data Berhasil Ditambah'
					];
				}else{
					$notif 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Silahkan Ulangi Lagi'
					];
				}
			}
			echo json_encode($notif);
		}
		public function deleteVariant()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$delete 		=	$this->model->deleteVariant($id);
				if($delete){
					$data 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Variasi Berhasil Diubah Hore!'
					];
				}else{
					$data 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Silahkan Coba Lagi'
					];
				}
				echo json_encode($data);
			}
		}
		public function addVariant()
		{
			if(!empty($this->request->getPost('name'))){
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name'		=>	$name
				];
				$save 			=	$this->model->addVariant($data);
				if($save){
					echo json_encode(['success'=>true,'data'=>'Berhasil']);
				}else{
					echo json_encode(['success'=>false,'data'=>null]);
				}
			}
		}
		// Product Variant
		public function updateProductVar()
		{
			if(!empty($this->request->getPost('id'))){
				$getId 				=	$this->request->getPost('id');
				$getVar 			=	$this->request->getPost('m_variant');
				$getPrice 			=	$this->request->getPost('m_price');
				$countVar 			=	count($getId);
				for($i=0;$i<$countVar;$i++){
					$data 			=
					[
						'sub_variant_id'	=>	$getVar[$i],
						'price'				=>	$getPrice[$i]
					];
					$updateSubVar 	=	$this->model->updateProductVariant($data, $getId[$i]);
					if($updateSubVar){
						$notif 		=
						[
							'success'	=>	true,
							'data'		=>	'Data Berhasil Di Ubah'
						];
					}
				}
				echo json_encode($notif);
			}
		}
		public function getVarIdProduct($id)
		{
			$getVarProd 		=	$this->model->getIdProductVariant($id);
			$html 				=	"";
			foreach($getVarProd as $var){
				$getSubVar 		=	$this->model->getVar($var['sub_variant_id'],'subvariant');
				$getSubVarAll 	=	$this->model->getVar(null,'subvariant');
				$html 			.=	
				"
				<input type='hidden' name='id[]' value='".$var['id']."'>
				<div class='form-group row'>
					<div class='col-lg-12'>
					<select class='form-control' name='m_variant[]'>
						<option value='".$getSubVar['id']."'>".$getSubVar['name']."</option>
						";
						foreach($getSubVarAll as $allVar){
							$html 			.=	"<option value='".$allVar['id']."'>".$allVar['name']."</option>";
						}
				$html 			.= 	"
					</select></div>
				</div>
				<div class='form-group'>
					<input class='form-control' name='m_price[]' type='number' value='".$var['price']."'>
				</div>
				";
			}
			return $html;
		}
		// Sub Variant
		public function deleteSubVariant()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$delete 		=	$this->model->deleteSubVariant($id);
				if($delete){
					$data 		=
					[
						'success'	=>	true,
						'data'		=>	'Data Variasi Berhasil Hapus Hore!'
					];
				}else{
					$data 		=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Sistem, Silahkan Coba Lagi'
					];
				}
				echo json_encode($data);
			}
		}
		public function editSubVariant()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name'		=>	$name
				];
				$update 		=	$this->model->editSubVariant($data, $id);
				if($update){
					echo json_encode(['success'=>true,'data'=>'Berhasil']);
				}else{
					echo json_encode(['success'=>false,'data'=>null]);
				}
			}
		}
		// End Sub
		public function editVariant()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$name 			=	$this->request->getPost('name');
				$data 			=
				[
					'name'		=>	$name
				];
				$update 		=	$this->model->editVariant($data, $id);
				if($update){
					echo json_encode(['success'=>true,'data'=>'Berhasil']);
				}else{
					echo json_encode(['success'=>false,'data'=>null]);
				}
			}
		}
		public function getVariant($type)
		{
			if($type 			=== "subvariant"){
				$getSub 		=	$this->model->getVar(null, 'subvariant');
				echo json_encode($getSub);
			}elseif($type 		=== "variant"){
				$getVar 		=	$this->model->getVar(null, 'variant');
				echo json_encode($getVar);
			}
		}
		// Produk
		public function getProduct()
		{
			$get 				=	$this->model->getProduct();
			echo json_encode($get);
		}
		public function addProduct()
		{
			if(!empty($this->request->getPost('name'))){
				$name 			=	$this->request->getPost('name');
				$cat 			=	$this->request->getPost('category');
				$data 			=
				[
					'name'		=>	$name,
					'category_id'=>	$cat
				];
				$save 			=	$this->model->createUpdateProduct($data, null);
				if($save){
					$notif 			=
					[
						'success'	=>	true,
						'id'		=>	$save
					];
				}else{
					$notif 			=
					[
						'success'	=>	false,
						'id'		=>	0
					];
				}
				echo json_encode($notif);

			}
		}
		public function dProduct()
		{
			if(!empty($this->request->getPost('id'))){
				$id 			=	$this->request->getPost('id');
				$delete 		=	$this->model->deleteProduct($id);
				$deleteProductVariant 	=	$this->model->deleteProductVariant($id);
				if($delete){
					$data 		=
					[
						'success'	=>	true,
						'data'		=>	'Hore, Data Kamu Berhasil Kamu Hapus'
					];
				}else{
					$data 		=
					[
						'success'	=>	false,
						'data'		=>	'Gagal, Kesalahan Sistem, Silahkan Ulangi Lagi'
					];
				}
				echo json_encode($data);
			}
		}
		public function updateProduct()
		{
			if(!empty($this->request->getPost('id'))){
				$id 				=	$this->request->getPost('id');
				$name 				=	$this->request->getPost('name');
				$cat 				=	$this->request->getPost('cat');
				$data 				=	
				[
					'name'			=>	$name,
					'category_id'	=>	$cat
				];
				$update 			=	$this->model->createUpdateProduct($data, $id);
				if($update){
					$notif 			=
					[
						'success'	=>	true,
						'data'		=>	'Data Berhasil Diubah'
					];
				}else{
					$notif 			=
					[
						'success'	=>	false,
						'data'		=>	'Kesalahan Server, Gagal Silahkan Coba Lagi'
					];
				}
				echo json_encode($notif);
			}
		}
	}