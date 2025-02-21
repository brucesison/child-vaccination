<?php

/*
 * BigBlueButton open source conferencing system - https://www.bigbluebutton.org/.
 *
 * Copyright (c) 2016-2024 BigBlueButton Inc. and by respective authors (see below).
 *
 * This program is free software; you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free Software
 * Foundation; either version 3.0 of the License, or (at your option) any later
 * version.
 *
 * BigBlueButton is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with BigBlueButton; if not, see <https://www.gnu.org/licenses/>.
 */

namespace BigBlueButton\Responses;

use BigBlueButton\TestCase;
use BigBlueButton\TestServices\Fixtures;

/**
 * @internal
 */
class IsMeetingRunningResponseTest extends TestCase
{
    private IsMeetingRunningResponse $running;

    public function setUp(): void
    {
        parent::setUp();
        $fixtures = new Fixtures();

        $xml = $fixtures->fromXmlFile('is_meeting_running.xml');

        $this->running = new IsMeetingRunningResponse($xml);
    }

    public function testIsMeetingRunningResponseContent(): void
    {
        $this->assertEquals('SUCCESS', $this->running->getReturnCode());
        $this->assertTrue($this->running->isRunning());
        $xml = $this->running->getRawXml()->asXML();
        $this->assertIsString($xml);
        $this->assertEquals('<?xmlversion="1.0"?><response><returncode>SUCCESS</returncode><running>true</running></response>', $this->minifyString($xml));
    }

    public function testIsMeetingRunningResponseTypes(): void
    {
        $this->assertEachGetterValueIsString($this->running, ['getReturnCode']);
        $this->assertEachGetterValueIsBoolean($this->running, ['isRunning']);
    }
}
