<?php

class AnnouncementTest extends WebTestCase
{
	public $fixtures=array(
		'announcements'=>'Announcement',
	);

	public function testShow()
	{
		$this->open('?r=administrator/announcement/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=administrator/announcement/create');
	}

	public function testUpdate()
	{
		$this->open('?r=administrator/announcement/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=administrator/announcement/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=administrator/announcement/index');
	}

	public function testAdmin()
	{
		$this->open('?r=administrator/announcement/admin');
	}
}
