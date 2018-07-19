<?php

namespace spec\Intercom\SocialEvents;

use Intercom\SocialEvents\Planner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Intercom\DataProvider\ICustomersProvider;
use Intercom\Geolocation\ICoordDistanceCalculator;

class PlannerSpec extends ObjectBehavior
{
    function let(ICustomersProvider $customer_provider, ICoordDistanceCalculator $dist_calculator)
    {
        $dummy_gps_coords = [1,1];
        $this->beConstructedWith($customer_provider, $dist_calculator, $dummy_gps_coords);
    }

    function it_filters_columns_from_assoc_array()
    {
        $data = [
            ['key1' => 100, 'key2' => 200],
            ['key1' => 101, 'key2' => 201],
            ['key1' => 102, 'key2' => 202],
        ];
        $columns = ['key2' => ''];
        $expected = [
            ['key2' => 200],
            ['key2' => 201],
            ['key2' => 202],
        ];
        $this->filterColumns($data, $columns)
            ->shouldReturn($expected);
    }

    function it_sorts_array_by_given_column()
    {
        $data = [
            ['key1' => 194, 'key2' => 938],
            ['key1' => 823, 'key2' => 349],
            ['key1' => 930, 'key2' => 436],
        ];

        $this->sortArrayByColumn($data, 'key2')
             ->shouldReturn([
                ['key1' => 823, 'key2' => 349],
                ['key1' => 930, 'key2' => 436],
                ['key1' => 194, 'key2' => 938],
            ]);
    }
}

