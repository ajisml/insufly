<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
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
			'name_full'			=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	100
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('pelanggan');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
