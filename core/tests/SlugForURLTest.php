<?php

use org\openacalendar\curatedlists\models\CuratedListModel;
use models\GroupModel;
use models\AreaModel;
use models\EventModel;
use models\VenueModel;
use models\TagModel;

/**
 *
 * @package Core
 * @link http://ican.openacalendar.org/ OpenACalendar Open Source Software
 * @license http://ican.openacalendar.org/license.html 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class SlugForUrlTest extends \BaseAppTest {

    protected $testSetMaxLength = 30;

	function dataForTestSet() {
		return array(
				array(1,'cat','1-cat'),
				array(2,'@cat','2-cat'),
				array(3,'cat dog','3-cat-dog'),
				array(4,'','4'),
				array(5,'café','5-cafe'),
				array(6,'cafe meetup - bob\'s group','6-cafe-meetup-bobs-group'),
				array(7,'  cafe meetup ','7-cafe-meetup'),
				array(8,'abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz','8-abcdefghijklmnopqrstuvwxyz-abc'),
			);
	}
	
	/**
     * @dataProvider dataForTestSet
     */
	function testSet1($slug, $text, $result) {
        $this->app['config']->slugMaxLength = $this->testSetMaxLength;
		$area = new AreaModel();
		$area->setSlug($slug);
		$area->setTitle($text);
		$this->assertEquals($result, $area->getSlugForUrl());
	}

	/**
     * @dataProvider dataForTestSet
     */
	function testSet2($slug, $text, $result) {
        $this->app['config']->slugMaxLength = $this->testSetMaxLength;
		$group = new GroupModel();
		$group->setSlug($slug);
		$group->setTitle($text);
		$this->assertEquals($result, $group->getSlugForUrl());
	}

	/**
     * @dataProvider dataForTestSet
     */
	function testSet3($slug, $text, $result) {
        $this->app['config']->slugMaxLength = $this->testSetMaxLength;
		$venue = new VenueModel();
		$venue->setSlug($slug);
		$venue->setTitle($text);
		$this->assertEquals($result, $venue->getSlugForUrl());
	}

	/**
     * @dataProvider dataForTestSet
     */
	function testSet4($slug, $text, $result) {
        $this->app['config']->slugMaxLength = $this->testSetMaxLength;
		$event = new EventModel();
		$event->setSlug($slug);
		$event->setSummary($text);
		$this->assertEquals($result, $event->getSlugForUrl());
	}

	/**
     * @dataProvider dataForTestSet
     */
	function testSet5($slug, $text, $result) {
        $this->app['config']->slugMaxLength = $this->testSetMaxLength;
		$curatedlist = new CuratedListModel();
		$curatedlist->setSlug($slug);
		$curatedlist->setTitle($text);
		$this->assertEquals($result, $curatedlist->getSlugForUrl());
	}

	/**
     * @dataProvider dataForTestSet
     */
	function testSet6($slug, $text, $result) {
        $this->app['config']->slugMaxLength = $this->testSetMaxLength;
		$tag = new TagModel();
		$tag->setSlug($slug);
		$tag->setTitle($text);
		$this->assertEquals($result, $tag->getSlugForUrl());
	}

    protected $testClassMaxLength = 30;

    function dataForTestClass() {
        return array(
            array('cat','cat'),
            array('@cat','cat'),
            array('cat dog','cat-dog'),
            array('',''),
            array('café','cafe'),
            array('cafe meetup - bob\'s group','cafe-meetup-bobs-group'),
            array('  cafe meetup ','cafe-meetup'),
            array('abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz','abcdefghijklmnopqrstuvwxyz-abc'),
        );
    }

    /**
     * @dataProvider dataForTestClass
     */
    function testClass1($text, $result) {
        $this->app['config']->slugMaxLength = $this->testClassMaxLength;
        $slugify = new Slugify($this->app);
        $this->assertEquals($result, $slugify->process($text));
    }

}

