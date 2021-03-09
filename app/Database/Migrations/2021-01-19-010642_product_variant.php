<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductVariant extends Migration
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
			'product_id'		=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'sub_variant_id'	=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'price'				=>
			[
				'type'			=>	'DOUBLE'
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('product_variant');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
