<?php
namespace Intercom\Geolocation;

use Intercom\Helper\UnitConverter;

/**
 * Computes the distance between two GPS coords using the Great Circle technique
 */
class GreatCircleDistanceCalculator implements ICoordDistanceCalculator
{
    const EARTH_RADIUS = 6371;

    /**
     * @var     \Intercom\Helper\UnitConverter
     */
    private $unit_converter;

    public function __construct(UnitConverter $unit_converter)
    {
        $this->unit_converter = $unit_converter;
    }

    /**
     * Computes the distance between two GPS coords
     *
     * @param   array   $from
     * @param   array   $to
     * @return  float
     */
    public function calculateDistance(array $from, array $to)
    {
        $from = array_map([$this->unit_converter, 'degreesToRadians'], $from);
        $to = array_map([$this->unit_converter, 'degreesToRadians'], $to);

        list($lat1, $lon1) = $from;
        list($lat2, $lon2) = $to;

        $delta = $this->computeDeltaWithVincentyFormula($lat1, $lon1, $lat2, $lon2);
        $distance = self::EARTH_RADIUS * $delta;

        return $distance;
    }

    /**
     * Computes the absolute difference between two given values
     *
     * @param   float   $val1
     * @param   float   $val2
     * @param   float
     */
    public function absoluteDiff($val1, $val2)
    {
        $delta_long = abs(abs($val1) - abs($val2));

        return $delta_long;
    }

    /**
     * Performs the cosines computation to be fed to the spherical law of
     * cosines, needed for the distance calculation.
     *
     * @param   float   $lat1
     * @param   float   $lon1
     * @param   float   $lat2
     * @param   float   $lon2
     * @return  float
     */
    public function cosines($lat1, $lon1, $lat2, $lon2)
    {
        $delta_long = $this->absoluteDiff($lon1, $lon2);
        $lat_sins = sin($lat1) * sin($lat2);
        $latlon_cos = cos($lat1) * cos($lat2) * cos($delta_long);

        return $lat_sins + $latlon_cos;
    }

    /**
     * Computes the delta sigma value using the Vincenty formula.
     *
     * @param   float   $lat1
     * @param   float   $lon1
     * @param   float   $lat2
     * @param   float   $lon2
     * @return  float
     */
    public function computeDeltaWithVincentyFormula($lat1, $lon1, $lat2, $lon2)
    {
        // computes term x
        $term_x = $this->cosines($lat1, $lon1, $lat2, $lon2);
        // computes term y
        $lon_delta = $this->absoluteDiff($lon1, $lon2);
        $addend1 = pow(cos($lat2) * sin($lon_delta), 2);
        $addend2 = pow((cos($lat1) * sin($lat2)) - (sin($lat1) * cos($lat2) * cos($lon_delta)), 2);
        $term_y = sqrt($addend1 + $addend2);

        $delta = atan2($term_y, $term_x);

        return $delta;
    }
}

