<?php
namespace Intercom\SocialEvents;

use Intercom\DataProvider\ICustomersProvider;
use Intercom\Geolocation\ICoordDistanceCalculator;

/**
 * Helper class for planning company events.
 */
class Planner
{
    /**
     * @var     ICustomersProvider
     */
    private $data_provider;

    /**
     * @var     ICoorDistanceCalculator
     */
    private $dist_calculator;

    /**
     * @var     array
     */
    private $office_location;

    /**
     * @param   ICustomersProvider
     * @param   ICoordDistanceCalculator
     */
    public function __construct(
        ICustomersProvider $data_provider,
        ICoordDistanceCalculator $dist_calculator
    ) {
        $this->data_provider = $data_provider;
        $this->dist_calculator = $dist_calculator;

        $this->office_location = [53.339428, -6.257664];
    }

    /**
     * Helper method for loading customers and filter those within the given
     * radius.
     *
     * @param   float   $radius
     * @return  array
     */
    public function gatherPotentialInviteesWithinRadius($radius)
    {
        $customers = $this->data_provider->records();

        array_walk($customers, [$this, 'addDistanceCol']);
        $to_be_invited = array_filter($customers, function (array $customer) use ($radius) {
            return $customer['dist_to_office'] <= $radius;
        });

        // Filter only name and user_id
        array_walk($to_be_invited, function (&$customer) {
            $customer = array_intersect_key($customer, ['name' => '' , 'user_id' => '']);
        });

        // Sort by user_id
        $sortby_col = array_column($to_be_invited, 'user_id');
        array_multisort($sortby_col, SORT_ASC, SORT_NUMERIC, $to_be_invited);

        return $to_be_invited;
    }

    /**
     * Updates the given `data` array (by reference), adding the computed distance
     * between the gps coord given in the data and the office location.
     *
     * @param   array   $data
     * @return  void
     */
    public function addDistanceCol(array &$data)
    {
        $gps_coord = [
            (float) $data['latitude'],
            (float) $data['longitude']
        ];

        $distance = $this->dist_calculator
                         ->calculateDistance($this->office_location, $gps_coord);
        $data['dist_to_office'] = $distance;
    }
}

