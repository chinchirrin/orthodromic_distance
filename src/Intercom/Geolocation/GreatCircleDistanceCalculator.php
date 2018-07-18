<?php

namespace Intercom\Geolocation;

class GreatCircleDistanceCalculator implements ICoordDistanceCalculator
{
    /**
     * @param   float   $degrees
     * @return  float
     */
    public function degreesToRadians($degrees)
    {
        $radians = $degrees * pi() / 180.0;

        return $radians;
    }

    public function calculateDistance(array $from, array $to)
    {
        return 0;
    }
}

