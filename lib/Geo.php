<?php

namespace Kirby\Geo;

use A;

/**
 * Kirby Geo Class
 *
 * @author Bastian Allgeier <bastian@getkirby.com>
 * @license MIT
 * @link https://getkirby.com
 */
class Geo
{
    /**
     * Calculates the distance between to Kirby Geo Points
     *
     * @param \Kirby\Geo\Point|string $a
     * @param \Kirby\Geo\Point|string $b
     * @param null|string $unit ("km", "mi")
     * @return float
     */
    public static function distance($a, $b, string $unit = 'km')
    {
        if (is_a($a, 'Kirby\\Geo\\Point') === false) {
            $a = static::point($a);
        }

        if (is_a($b, 'Kirby\\Geo\\Point') === false) {
            $b = static::point($b);
        }

        $theta = $a->lng() - $b->lng();
        $dist  = sin(deg2rad($a->lat())) * sin(deg2rad($b->lat())) +  cos(deg2rad($a->lat())) * cos(deg2rad($b->lat())) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        if (strtolower($unit) === 'km') {
            return static::milesToKilometers($miles);
        }

        return $miles;
    }

    /**
     * Converts Kilometers to Miles
     *
     * @param int|float $kilometers
     * @return float
     */
    public static function kilometersToMiles(float $kilometers): float
    {
        return $kilometers * 0.621371;
    }

    /**
     * Converts Miles to Kilometers
     *
     * @param int|float $miles
     * @return float
     */
    public static function milesToKilometers(float $miles): float
    {
        return $miles * 1.60934;
    }

    /**
     * Calculates the distance between to Kirby Geo Points
     * and returns the result in a a human readable format
     *
     * @param Kirby\Geo\Point|string $a
     * @param Kirby\Geo\Point|string $b
     * @param null|string $unit ("km", "mi")
     * @return string
     */
    public static function niceDistance($a, $b, string $unit = 'km'): string
    {
        return number_format(static::distance($a, $b, $unit), 2) . ' ' . strtolower($unit);
    }

    /**
     * Creates a new Kirby Geo Point object
     *
     * @see \Kirby\Geo\Point::make
     * @return \Kirby\Geo\Point
     */
    public static function point(...$args)
    {
        return Point::make(...$args);
    }
}
