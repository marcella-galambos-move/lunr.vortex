<?php

/**
 * This file contains the GCMResponseGetStatusTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the get_status function of the GCMResponse class.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseGetStatusTest extends GCMResponseTest
{

    /**
     * Unit test data provider.
     *
     * @return Array $data array of endpoints statuses / status result
     */
    public function endpointDataProvider()
    {
        $data = [];

        // return unknown status if no status set
        $data[] = [ [], PushNotificationStatus::UNKNOWN  ];

        // return unknown status if endpoint absent
        $data[] = [
            [
                'endpoint1' => PushNotificationStatus::INVALID_ENDPOINT,
            ],
            PushNotificationStatus::UNKNOWN,
        ];
        $data[] = [
            [
                'endpoint1' => PushNotificationStatus::ERROR,
                'endpoint2' => PushNotificationStatus::INVALID_ENDPOINT,
                'endpoint3' => PushNotificationStatus::SUCCESS,
            ],
            PushNotificationStatus::UNKNOWN,
        ];

        // return endpoint own status if present
        $data[] = [
            [
                'endpoint_param' => PushNotificationStatus::INVALID_ENDPOINT,
            ],
            PushNotificationStatus::INVALID_ENDPOINT,
        ];
        $data[] = [
            [
                'endpoint1'      => PushNotificationStatus::ERROR,
                'endpoint_param' => PushNotificationStatus::SUCCESS,
                'endpoint2'      => PushNotificationStatus::TEMPORARY_ERROR,
            ],
            PushNotificationStatus::SUCCESS,
        ];

        return $data;
    }

    /**
     * Test the get_status() behavior.
     *
     * @param Array   $statuses Endpoints statuses
     * @param Integer $status   Expected function result
     *
     * @dataProvider endpointDataProvider
     * @covers       Lunr\Vortex\GCM\GCMResponse::get_status
     */
    public function testGetStatus($statuses, $status)
    {
        $this->set_reflection_property_value('statuses', $statuses);

        $result = $this->class->get_status('endpoint_param');

        $this->assertEquals($status, $result);
    }

}

?>
