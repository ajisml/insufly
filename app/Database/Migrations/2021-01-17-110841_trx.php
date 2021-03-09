<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Trx extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11,
				'unsigned'		=>	true,
				'auto_increment'=>	true
			],
			'product_variant_id'=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'variant_id'		=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11	
			],
			'pelanggan_id'		=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'name_buyer'		=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	255
			],
			'qty'				=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'disc'				=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'code_invoice'		=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	255
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('trx');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
