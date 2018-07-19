<?php
namespace Intercom;

class Factory
{
    public function create($fqcn)
    {
        switch($fqcn) {
        case 'Intercom\DataProvider\JSONFileReader':
            $filename = __DIR__ . '/../../misc/customers.json';
            try {
                $instance = new $fqcn($filename);
            } catch (\Exception $exception) {
                $message = $exception->getMessage();
                throw new \Exception('Unable to load customers data. ' . $message);
            }

            break;
        case 'Intercom\Geolocation\GreatCircleDistanceCalculator':
            $unit_converter = $this->create(\Intercom\Helper\UnitConverter::class);
            $instance = new $fqcn($unit_converter);
            break;
        case 'Intercom\Helper\UnitConverter':
            $instance = new $fqcn();
            break;
        case 'Intercom\SocialEvents\Planner':
            $data_provider = $this->create(\Intercom\DataProvider\JSONFileReader::class);
            $dist_calculator = $this->create(\Intercom\Geolocation\GreatCircleDistanceCalculator::class);
            $instance = new $fqcn($data_provider, $dist_calculator);

            break;
        }

        return $instance;
    }
}

