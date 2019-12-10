<?php

namespace Kirby\Geo;

use PHPUnit\Framework\TestCase;

class GeoTest extends TestCase
{
    public function testDistance()
    {
        $mannheim = Geo::point(49.4883333, 8.4647222);
        $hamburg  = Geo::point(53.553436, 9.992247);
        $distance = Geo::distance($mannheim, $hamburg);

        $this->assertSame(464.1569693897881, $distance);
    }

    public function testDistanceInMiles()
    {
        $mannheim = Geo::point(49.4883333, 8.4647222);
        $hamburg  = Geo::point(53.553436, 9.992247);
        $distance = Geo::distance($mannheim, $hamburg, 'mi');

        $this->assertSame(288.41448630481324, $distance);
    }

    public function testKilometersToMiles()
    {
        // int
        $mi = Geo::kilometersToMiles(1);
        $this->assertSame(0.621371, $mi);

        // float
        $mi = Geo::kilometersToMiles(1.5);
        $this->assertSame(0.9320565000000001, $mi);
    }

    public function testMilesToKilometers()
    {
        // int
        $km = Geo::milesToKilometers(1);
        $this->assertSame(1.60934, $km);

        // float
        $km = Geo::milesToKilometers(1.5);
        $this->assertSame(2.41401, $km);
    }

    public function testNiceDistance()
    {
        $mannheim = Geo::point(49.4883333, 8.4647222);
        $hamburg  = Geo::point(53.553436, 9.992247);
        $distance = Geo::niceDistance($mannheim, $hamburg);

        $this->assertSame('464.16 km', $distance);
    }

    public function testNiceDistanceInMiles()
    {
        $mannheim = Geo::point(49.4883333, 8.4647222);
        $hamburg  = Geo::point(53.553436, 9.992247);
        $distance = Geo::niceDistance($mannheim, $hamburg, 'mi');

        $this->assertSame('288.41 mi', $distance);
    }

    public function testPoint()
    {
        $lat = 49.4883333;
        $lng = 8.4647222;

        $point = Geo::point($lat, $lng);

        $this->assertInstanceOf('Kirby\Geo\Point', $point);
        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());
    }
}
