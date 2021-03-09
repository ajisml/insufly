<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
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
			'name'				=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	255
			],
			'category_id'		=>	
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('product');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
