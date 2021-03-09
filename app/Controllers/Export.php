<?php namespace App\Controllers;

	use CodeIgniter\Controller;
	use App\Models\globalModel;
	use Mpdf\Mpdf;

	class Export extends BaseController
	{
	    public function __construct()
	    {
	        $this->model 		=	new globalModel();
	        helper('inv');
	    }
	    // PDF
	    public function pdf($code)
	    {
	    	if(!empty($code)){
	    		$getTrx 		=	$this->model->getTrx($code,"code_invoice");
				$html 			=	"";
				$no 			=	1;
				$getInv			=	$this->model->getInvoice($code);
				$getBuyer 		=	$this->model->getBuyyer($getInv['pelanggan_id']);
				$subtotal 		=	0;
				foreach($getTrx as $trx){
					$discount 	=	(($trx['price_product']*$trx['disc'])/100);
					$disc 		=	$trx['price_product'] - $discount;
					$subtotal 	+=	$disc;
	    			$html 		.=
	    			"
					<tr>
						<td> ". $no++ ."</td>
						<td>".$trx['name_buyer']."</td>
						<td>".$trx['name_product']."</td>
						<td>".$trx['variant']." - ".$trx['sub_variant']."</td>
						<td>".$trx['category']."</td>
						<td>".$trx['qty']."</td>
						<td>Rp.".number_format($trx['price_product'],0,',','.')."</td>
						<td>".$trx['disc']."%</td>
						<td>Rp.".number_format($disc,0,',','.')."</td>
					</tr>
	    			";
	    		}
	    		$mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'format' => 'A4-L']);
				$mpdf->WriteHTML("
				<table width='100%'>
					<tr>
						<th colspan='3' style='text-align:left'>
							<h2>NAYMA HIJAB STORE</h2>
						</th>
						<th colspan='2' style='text-align:right'>INVOICE</th>
					</tr>
					<tr>
						<td colspan='3'></td>
						<td style='text-align:right'>INVOICE NO :</td>
						<td style='text-align:right'>".htmlspecialchars($code)."</td>
					</tr>
					<tr>
						<td colspan='3'></td>
						<td style='text-align:right'>TANGGAL :</td>
						<td style='text-align:right'>".$getInv['date_at']."</td>
					</tr>
					<tr>
						<td colspan='3'></td>
						<td style='text-align:right'>AGEN :</td>
						<td style='text-align:right'>".$getBuyer['name_full']."</td>
					</tr>
					
				</table>
				<table border='1' width='100%' cellpadding='10px' cellspacing='0'>
					<thead>
						<tr>
							<th>#</th>
							<th>NAMA PEMESAN</th>
							<th>PRODUK</th>
							<th>VARIASI</th>
							<th>KATEGORI</th>
							<th>QTY</th>
							<th>HARGA</th>
							<th>DISKON</th>
							<th>TOTAL</th>
						</tr>
					</thead>
					<tbody>
					".$html."
						<tr>
							<th colspan='5'></th>
							<th colspan='2' style='text-align:right'>SUBTOTAL</th>
							<th colspan='2'>Rp.".number_format($subtotal,0,',','.')."</th>
						</tr>
					</tbody>
				</table>
	    			");
	    		$mpdf->Output('oke.pdf','I');
	    		exit;
	    	}
	    }


	}
