<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cart extends Migration
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
			'users_id'			=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('cart');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
