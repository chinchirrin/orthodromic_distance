<?php

namespace Intercom\Helper;

class UnitConverter
{
    /**
     * Returns the give $degrees into radians units if a valid value is provided,
     * null otherwise
     *
     * @param   float       $degrees
     * @return  float|null
     */
    public function degreesToRadians($degrees)
    {
        if (!is_numeric($degrees)) {
            return null;
        }

        $radians = $degrees * pi() / 180.0;

        return $radians;
    }
}
