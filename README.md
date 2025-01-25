# Kirby GEO Plugin

This plugin adds basic geo search and conversion functionalities to Kirby

## Geo Class Option

### Geo::point($lat, $lng)

Creates a new Kirby Geo Point

Example:

```php
Geo::point(49.4883333, 8.4647222);
Geo::point('49.4883333, 8.4647222');
Geo::point([49.4883333, 8.4647222]);
Geo::point(['lat' => 49.4883333, 'lng' => 8.4647222]);
```

Afterwards you can get the latitude and longitude values of the point like this:

```php
$point = Geo::point(49.4883333, 8.4647222);
echo $point->lat();
echo $point->lng();
```

### Geo::distance($pointA, $pointB)

Returns the distance between two geo points.

```php
$mannheim = Geo::point(49.4883333, 8.4647222);
$hamburg  = Geo::point(53.553436, 9.992247);

echo 'The distance between Mannheim and Hamburg is: ' . Geo::distance($mannheim, $hamburg);
```

You can also return the distance in miles instead of kilometers

```php
echo 'The distance between Mannheim and Hamburg is: ' . Geo::distance($mannheim, $hamburg, 'mi');
```

### Geo::niceDistance($pointA, $pointB)

Returns the distance between two geo points in a human readable way (i.e. 461.32 km)

```php
$mannheim = Geo::point(49.4883333, 8.4647222);
$hamburg  = Geo::point(53.553436, 9.992247);

echo 'The distance between Mannheim and Hamburg is: ' . Geo::niceDistance($mannheim, $hamburg);
```

You can also return the "nice distance" in miles instead of kilometers

```php
echo 'The distance between Mannheim and Hamburg is: ' . Geo::niceDistance($mannheim, $hamburg, 'mi');
```

### Geo::kilometersToMiles($km)

Converts kilometers into miles:

```php
echo Geo::kilometersToMiles(1000);
```

### Geo::milesToKilometers($mi)

Converts miles into kilometers:

```php
echo Geo::milesToKilometers(1000);
```

## Radius Filter

The plugin automatically adds a new filter for all collections, which can be used to do a radius search:

```php
$addresses = page('addresses')->children()->filterBy('location', 'radius', [
  'lat'    => 49.4883333,
  'lng'    => 8.4647222,
  'radius' => 10
]);
```

To make this work, the location field for each address page must be in the following format:

```
location: {lat},{lng}
```

or with a real life example:

```
location: 49.4883333,8.4647222
```

You can also filter in miles

```php
$addresses = page('addresses')->children()->filterBy('location', 'radius', [
  'lat'    => 49.4883333,
  'lng'    => 8.4647222,
  'radius' => 10,
  'unit'   => 'mi'
]);
```

## Field Methods

The plugin also adds a set of field methods, which can be handy to work with locations

### $field->coordinates()

Converts a field with the value format {lat},{lng} into a valid Kirby Geo Point Object:

```php
$page->location()->coordinates()->lat();
$page->location()->coordinates()->lng();
```

### $field->distance($point)

Calculates the distance between a location field and another Kirby Geo Point:

```php
$hamburg = Geo::point(53.553436, 9.992247);

echo $page->location()->distance($hamburg);
```

Of course you can run this in miles again:

```php
$hamburg = Geo::point(53.553436, 9.992247);

echo $page->location()->distance($hamburg, 'mi');
```

### $field->niceDistance($point)

Returns the distance in a more human friendly format:

```php
$hamburg = Geo::point(53.553436, 9.992247);

echo $page->location()->niceDistance($hamburg);
```

## What’s Kirby?
- **[getkirby.com](https://getkirby.com)** – Get to know the CMS.
- **[Try it](https://getkirby.com/try)** – Take a test ride with our online demo. Or download one of our kits to get started.
- **[Documentation](https://getkirby.com/docs/guide)** – Read the official guide, reference and cookbook recipes.
- **[Issues](https://github.com/getkirby/kirby/issues)** – Report bugs and other problems.
- **[Feedback](https://feedback.getkirby.com)** – You have an idea for Kirby? Share it.
- **[Forum](https://forum.getkirby.com)** – Whenever you get stuck, don't hesitate to reach out for questions and support.
- **[Discord](https://chat.getkirby.com)** – Hang out and meet the community.
- **[Mastodon](https://mastodon.social/@getkirby)** – Spread the word.
- **[Bluesky](https://bsky.app/profile/getkirby.com)** – Spread the word.

---

## License

<http://www.opensource.org/licenses/mit-license.php>

## Credits

[Bastian Allgeier](https://getkirby.com)
