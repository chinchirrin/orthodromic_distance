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

