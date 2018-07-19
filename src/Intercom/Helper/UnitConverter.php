<?php

namespace Intercom\Helper;

class UnitConverter
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
}
