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

        $to_be_invited = $this->filterCustomersWithinRadius($customers, $radius);

        // Filter only name and user_id
        $to_be_invited = $this->filterColumns($to_be_invited, ['name' => '' , 'user_id' => '']);

        // Sort by user_id
        $to_be_invited = $this->sortArrayByColumn($to_be_invited, 'user_id');

        return $to_be_invited;
    }

    /**
     * It filters out customers whose `dist_to_office` value is greater than the
     * given radius.
     *
     * @param   array   $customers
     * @param   float   $radius
     * @return  array
     */
    public function filterCustomersWithinRadius(array $customers, $radius)
    {
        array_walk($customers, [$this, 'addDistanceCol']);
        $to_be_invited = array_filter($customers, function (array $customer) use ($radius) {
            return $customer['dist_to_office'] <= $radius;
        });

        return $to_be_invited;
    }

    /**
     * Remove columns from `data` array that are not in the whitelist_cols array
     *
     * @param   array   $data
     * @param   array   $whitelist_cols
     * @return  array
     */
    public function filterColumns(array $data, array $whitelist_cols)
    {
        // Filter given keys in whitelist_cols
        array_walk($data, function (&$customer) use ($whitelist_cols) {
            $customer = array_intersect_key($customer, $whitelist_cols);
        });

        return $data;
    }

    /**
     * Sorts the array of assoc arrays by the given key (column name)
     *
     * @param   array   $data
     * @param   string  $key
     * @return  array
     */
    public function sortArrayByColumn(array $data, $key)
    {
        $sortby_col = array_column($data, $key);
        array_multisort($sortby_col, SORT_ASC, SORT_NUMERIC, $data);

        return $data;
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

