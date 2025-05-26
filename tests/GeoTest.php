<?php

namespace Kirby\Geo;

use PHPUnit\Framework\TestCase;

class GeoTest extends TestCase
{
	public function testDistance(): void
	{
		$mannheim = Geo::point(49.4883333, 8.4647222);
		$hamburg  = Geo::point(53.553436, 9.992247);
		$distance = Geo::distance($mannheim, $hamburg);

		$this->assertSame(464.15696938977845, $distance);
	}

	public function testDistanceInMiles(): void
	{
		$mannheim = Geo::point(49.4883333, 8.4647222);
		$hamburg  = Geo::point(53.553436, 9.992247);
		$distance = Geo::distance($mannheim, $hamburg, 'mi');

		$this->assertSame(288.4144863048072, $distance);
	}

	public function testDistanceSamePoint(): void
	{
		$a        = Geo::point(49.4883333, 8.4647222);
		$b        = Geo::point(49.4883333, 8.4647222);
		$distance = Geo::distance($a, $b);

		$this->assertSame(0.0, $distance);
	}

	public function testKilometersToMiles(): void
	{
		// int
		$mi = Geo::kilometersToMiles(1);
		$this->assertSame(0.621371, $mi);

		// float
		$mi = Geo::kilometersToMiles(1.5);
		$this->assertSame(0.9320565000000001, $mi);
	}

	public function testMilesToKilometers(): void
	{
		// int
		$km = Geo::milesToKilometers(1);
		$this->assertSame(1.60934, $km);

		// float
		$km = Geo::milesToKilometers(1.5);
		$this->assertSame(2.41401, $km);
	}

	public function testNiceDistance(): void
	{
		$mannheim = Geo::point(49.4883333, 8.4647222);
		$hamburg  = Geo::point(53.553436, 9.992247);
		$distance = Geo::niceDistance($mannheim, $hamburg);

		$this->assertSame('464.16 km', $distance);
	}

	public function testNiceDistanceInMiles(): void
	{
		$mannheim = Geo::point(49.4883333, 8.4647222);
		$hamburg  = Geo::point(53.553436, 9.992247);
		$distance = Geo::niceDistance($mannheim, $hamburg, 'mi');

		$this->assertSame('288.41 mi', $distance);
	}

	public function testPoint(): void
	{
		$lat = 49.4883333;
		$lng = 8.4647222;

		$point = Geo::point($lat, $lng);

		$this->assertInstanceOf(Point::class, $point);
		$this->assertSame($lat, $point->lat());
		$this->assertSame($lng, $point->lng());
	}
}
