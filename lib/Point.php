<?php

namespace Kirby\Geo;

use A;
use Exception;
use Str;

/**
 * Kirby Geo Point Class
 *
 * @author Bastian Allgeier <bastian@getkirby.com>
 * @license MIT
 * @link https://getkirby.com
 */
class Point
{
    /**
     * Latitude
     *
     * @var float
     */
    protected $lat;

    /**
     * Longitude
     *
     * @var float
     */
    protected $lng;

    /**
     * Creates a new Point object
     *
     * @param string $lat
     * @param string $lng
     */
    public function __construct(string $lat, string $lng)
    {
        if (is_numeric($lat) === false || is_numeric($lng) === false) {
            throw new Exception('Invalid Geo Point values');
        }

        $this->lat = (float)$lat;
        $this->lng = (float)$lng;
    }

    /**
     * Returns the latitude value of the point
     *
     * @return float
     */
    public function lat()
    {
        return $this->lat;
    }

    /**
     * Returns the longituted value of the point
     *
     * @return float
     */
    public function lng()
    {
        return $this->lng;
    }

    /**
     * Returns the longituted value of the point
     *
     * @return float
     */
    public function long()
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
     *
     * @return Kirby\Geo\Point
     */
    public static function make(...$args)
    {
        $count = count($args);

        switch ($count) {
            case 1:
                if (is_string($args[0]) === true) {
                    $parts = Str::split($args[0]);
                    if (count($parts) === 2) {
                        return new static($parts[0], $parts[1]);
                    }
                } elseif (is_array($args[0]) === true) {
                    $array = $args[0];

                    if (isset($array['lat'], $array['lng'])) {
                        return new static($array['lat'], $array['lng']);
                    } elseif (count($array) === 2) {
                        return new static(A::first($array), A::last($array));
                    }
                }
            break;
            case 2:
                return new static($args[0], $args[1]);
            break;
        }

        throw new Exception('Invalid Geo Point values');
    }
}
