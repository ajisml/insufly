<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
			'username'			=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	8
			],
			'password'			=>
			[
				'type'			=>	'TEXT'
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
