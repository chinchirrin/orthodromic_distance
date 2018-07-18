<?php
namespace Intercom\Geolocation;

interface ICoordDistanceCalculator
{
    public function calculateDistance(array $from, array $to);
}

