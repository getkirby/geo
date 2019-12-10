<?php

namespace Kirby\Geo;

use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    public function test__construct()
    {
        // float values
        $lat = 49.4883333;
        $lng = 8.4647222;

        $point = new Point($lat, $lng);

        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());
        $this->assertSame($lng, $point->long());

        // string values
        $point = new Point((string)$lat, (string)$lng);

        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());
        $this->assertSame($lng, $point->long());

        // invalid point
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid Geo Point values');

        $point = new Point('foo', 'bar');
    }

    public function testMake()
    {
        $lat = 49.4883333;
        $lng = 8.4647222;

        // $lat, $lng
        $point = Point::make($lat, $lng);

        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());

        // "$lat, $lng"
        $point = Point::make("$lat, $lng");

        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());

        // [$lat, $lng]
        $point = Point::make([$lat, $lng]);

        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());

        // ['lat' => $lat, 'lng' => $lng]
        $point = Point::make(['lat' => $lat, 'lng' => $lng]);

        $this->assertSame($lat, $point->lat());
        $this->assertSame($lng, $point->lng());
    }
}
