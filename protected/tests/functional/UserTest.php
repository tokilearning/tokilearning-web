<?php

class UserTest extends WebTestCase
{
	public $fixtures=array(
		'users'=>'User',
	);

	public function testShow()
	{
		$this->open('?r=administrator\user/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=administrator\user/create');
	}

	public function testUpdate()
	{
		$this->open('?r=administrator\user/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=administrator\user/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=administrator\user/index');
	}

	public function testAdmin()
	{
		$this->open('?r=administrator\user/admin');
	}
}
