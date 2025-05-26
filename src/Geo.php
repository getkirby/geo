<?php

namespace Kirby\Geo;

/**
 * Kirby Geo Class
 *
 * @package   Kirby Geo
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      https://getkirby.com
 * @copyright Bastian Allgeier
 * @license MIT
 */
class Geo
{
	/**
	 * Calculates the distance between to Kirby Geo Points
	 *
	 * @param null|string $unit ("km", "mi")
	 */
	public static function distance(
		Point|string $a,
		Point|string $b,
		string $unit = 'km'
	): float {
		if (is_string($a) === true) {
			$a = static::point($a);
		}

		if (is_string($b) === true) {
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
	 */
	public static function kilometersToMiles(float $kilometers): float
	{
		return $kilometers * 0.621371;
	}

	/**
	 * Converts Miles to Kilometers
	 */
	public static function milesToKilometers(float $miles): float
	{
		return $miles * 1.60934;
	}

	/**
	 * Calculates the distance between to Kirby Geo Points
	 * and returns the result in a a human readable format
	 *
	 * @param null|string $unit ("km", "mi")
	 */
	public static function niceDistance(
		Point|string $a,
		Point|string $b,
		string $unit = 'km'
	): string {
		$distance = static::distance($a, $b, $unit);
		return number_format($distance, 2) . ' ' . strtolower($unit);
	}

	/**
	 * Creates a new Kirby Geo Point object
	 *
	 * @see \Kirby\Geo\Point::make
	 */
	public static function point(...$args): Point
	{
		return Point::make(...$args);
	}
}
