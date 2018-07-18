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
}

