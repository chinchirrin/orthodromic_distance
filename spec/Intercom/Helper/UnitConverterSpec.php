<?php

namespace spec\Intercom\Helper;

use Intercom\Helper\UnitConverter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnitConverterSpec extends ObjectBehavior
{
    function it_converts_degrees_to_radians()
    {
        $degrees = 1;
        $this->degreesToRadians($degrees)
            ->shouldReturn(pi()/180);

        $degrees = 53.3498;
        $this->degreesToRadians($degrees)
            ->shouldBeApproximately(0.9311, 1.0e-4);
    }

    function it_gracefully_handles_invalid_inputs()
    {
        $this->degreesToRadians(null)
            ->shouldReturn(null);

        $this->degreesToRadians('null')
            ->shouldReturn(null);

        $this->degreesToRadians([])
            ->shouldReturn(null);
    }
}

