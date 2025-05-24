<?php

namespace Kirby\Geo;

use Kirby\Exception\InvalidArgumentException;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;

/**
 * Kirby Geo Point Class
 *
 * @author Bastian Allgeier <bastian@getkirby.com>
 * @license MIT
 * @link https://getkirby.com
 */
class Point
{
	protected float $lat;
	protected float $lng;

	/**
	 * Creates a new Point object
	 */
	public function __construct(
		string|float $lat,
		string|float $lng
	) {
		if (is_numeric($lat) === false || is_numeric($lng) === false) {
			throw new InvalidArgumentException('Invalid Geo Point values');
		}

		$this->lat = (float)$lat;
		$this->lng = (float)$lng;
	}

	/**
	 * Returns the latitude value of the point
	 */
	public function lat(): float
	{
		return $this->lat;
	}

	/**
	 * Returns the longituted value of the point
	 */
	public function lng(): float
	{
		return $this->lng;
	}

	/**
	 * Returns the longituted value of the point
	 * @see self::lng()
	 */
	public function long(): float
	{
		return $this->lng();
	}

	/**
	 * Static method to create a new Geo Point
	 * This can be used with various combinations of values
	 *
	 * 1.) static::make($lat, $lng)
	 * 2.) static::make("$lat,$lng")
	 * 3.) static::make([$lat, $lng])
	 * 4.) static::make(['lat' => $lat, 'lng' => $lng])
	 */
	public static function make(...$args): static
	{
		$count = count($args);

		if ($count === 2) {
			return new static($args[0], $args[1]);
		}

		if ($count === 1) {
			if (is_string($args[0]) === true) {
				$parts = Str::split($args[0]);

				if (count($parts) === 2) {
					return new static($parts[0], $parts[1]);
				}
			}

			if (is_array($args[0]) === true) {
				$array = $args[0];

				if (isset($array['lat'], $array['lng'])) {
					return new static($array['lat'], $array['lng']);
				}
				if (count($array) === 2) {
					return new static(A::first($array), A::last($array));
				}
			}
		}

		throw new InvalidArgumentException('Invalid Geo Point values');
	}
}
