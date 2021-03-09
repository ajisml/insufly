<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Invoice extends Migration
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
			'pelanggan_id'		=>
			[
				'type'			=>	'INT',
				'constraint'	=>	11
			],
			'code_invoice'		=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	255
			],
			'other_cut'			=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	255
			],
			'date_at'			=>
			[
				'type'			=>	'DATE'
			],
			'note'				=>
			[
				'type'			=>	'VARCHAR',
				'constraint'	=>	150
			],
			'total'				=>
			[
				'type'			=>	'DOUBLE'
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('invoice');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
