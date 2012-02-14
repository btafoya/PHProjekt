<?php
/**
 * Unit test
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License version 3 as published by the Free Software Foundation
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * @category   PHProjekt
 * @package    UnitTests
 * @subpackage Calendar2
 * @copyright  Copyright (c) 2011 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.1
 * @version    Release: @package_version@
 * @author     Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 */

require_once 'Sabre.autoload.php';

/**
 * Tests Calendar2 Model
 *
 * @category   PHProjekt
 * @package    UnitTests
 * @subpackage Calendar2
 * @copyright  Copyright (c) 2011 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.1
 * @version    Release: @package_version@
 * @author     Simon Kohlmeyer <simon.kohlmeyer@mayflower.de>
 * @group      calendar2
 * @group      calendar
 * @group      model
 * @group      calendar-model
 * @group      calendar2-model
 */
class Calendar2_Models_Calendar2_Test extends FrontInit
{
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/../../common.xml');
    }

    public function testFromVObject()
    {
        Zend_Controller_Front::getInstance()->setRequest(new Zend_Controller_Request_Http());

        $calendarId = '1';
        $objectUri = '693F6D66-92C6-47B8-8E97-C799B758FAE4';
        $calendarData = <<<HERE
BEGIN:VCALENDAR
CALSCALE:GREGORIAN
PRODID:-//Apple Inc.//iOS 5.0.1//EN
VERSION:2.0
BEGIN:VTIMEZONE
TZID:Africa/Luanda
BEGIN:STANDARD
DTSTART:19110525T235956
RDATE:19110525T235956
TZNAME:WAT
TZOFFSETFROM:+005204
TZOFFSETTO:+0100
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
CREATED:20111209T225301Z
DESCRIPTION:Some notes about testing things.
DTEND;TZID=Africa/Luanda:20111208T191500
DTSTAMP:20111209T225308Z
DTSTART;TZID=Africa/Luanda:20111205T184500
LAST-MODIFIED:20111209T225301Z
LOCATION:Test location
SEQUENCE:0
SUMMARY:Test title
TRANSP:OPAQUE
UID:693F6D66-92C6-47B8-8E97-C799B758FAE4
END:VEVENT
END:VCALENDAR
HERE;
        $calBackend = new Calendar2_CalDAV_CalendarBackend();
        $calBackend->createCalendarObject($calendarId, $objectUri, $calendarData);

        $event = new Calendar2_Models_Calendar2();
        $event = $event->fetchByUid('693F6D66-92C6-47B8-8E97-C799B758FAE4');

        $this->assertEquals(1, count($event), 'Too many events returned by fetchByUid');
        $event = $event[0];


        $reflection = new ReflectionClass($event);
        $data       = $reflection->getProperty('_data');
        $data->setAccessible(true);
        $data       = $data->getValue($event);

        $this->assertEquals('2011-12-05 17:45:00', $data['start']);
        $this->assertEquals('2011-12-08 18:15:00', $data['end']);
        $this->assertEquals('Test title', $event->summary);
        $this->assertEquals('Some notes about testing things.', $event->description);
        $this->assertEquals('Test location', $event->location);
        $this->assertEquals('', $event->rrule);
        $this->assertEquals('693F6D66-92C6-47B8-8E97-C799B758FAE4', $event->uid);
    }
}
