<?php namespace App\Controllers;

	use App\Models\globalModel;
	

class Home extends BaseController
{
	public function __construct()
	{
	    $this->username 	=	session()->get('username');
	    $this->uid 			=	session()->get('id');
	    $this->model 		=	new globalModel();
	}
	public function index()
	{
		return view('welcome_message');
	}
	public function dashboard()
	{
		$data 					=
		[
			'title'				=>	'Dashboard'
		];
		echo view('dash', $data);
	}
	public function users()
	{
		$data 					=
		[
			'title'				=>	'Kelola Pengguna'
		];
		echo view('m_users', $data);
	}
	// Category
	public function cat()
	{
		$data 					=
		[
			'title'				=>	'Kelola Kategori'
		];
		echo view('m_cat', $data);
	}
	// Product
	public function product()
	{
		$data 					=
		[
			'title'				=>	'Kelola Produk',
			'vars'				=>	$this->model->getVar(null, "variant"),
			'variant'			=>	$this->model->getVar(null, "subvariant"),
			'category'			=>	$this->model->getCat()
		];
		echo view('m_product', $data);
	}
	// Variant
	public function variant()
	{
		$data 					=	
		[
			'title'				=>	'Kelola Variasi'
		];
		echo view('m_variant', $data);
	}
	// Users
	public function signin()
	{
		$data 					=
		[
			'title'				=>	'Masuk'
		];
		echo view('users/login', $data);
	}
	// Invoice
	public function c_inv()
	{
		$data 					=
		[
			'title'				=>	'Buat Invoice',
			'uid'				=>	$this->uid,
			'variant'			=>	$this->model->getVar(null, "variant"),
			'buyer'				=>	$this->model->getBuyyer(),
		];
		echo view('c_invoice', $data);
	}
	public function inv()
	{
		$data 					=
		[
			'title'				=>	'Invoice',
			'invoice'			=>	$this->model->getInv(),
		];
		echo view('list_invoice', $data);
	}
	//--------------------------------------------------------------------

}
