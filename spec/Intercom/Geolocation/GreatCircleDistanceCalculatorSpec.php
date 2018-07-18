<?php

namespace spec\Intercom\Geolocation;

use Intercom\Geolocation\GreatCircleDistanceCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GreatCircleDistanceCalculatorSpec extends ObjectBehavior
{
    function it_converts_degrees_to_radians()
    {
        $degrees = 53.3498;
        $this->degreesToRadians($degrees)
            ->shouldBeApproximately(0.9311, 1.0e-4);
    }

    function it_calculates_the_distance_between_two_points()
    {
        // Spire in Dublin
        $from = [53.34985936124078, -6.260243651751125];
        // Titanic Belfast
        $to = [54.6081729724316, -5.909649380798328];
        //$this->shouldHaveType(GreatCircleDistanceCalculator::class);
        $this->calculateDistance($from, $to)
            ->shouldBeApproximately(141.78339, 1.0e-5);
    }
}

