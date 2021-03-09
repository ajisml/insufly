<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubVariasi extends Migration
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
				'constraint'	=>	11
			],
		]);
		$this->forge->addKey('id',true);
		$this->forge->createTable('sub_variant');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
