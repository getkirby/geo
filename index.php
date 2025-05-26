<?php

/**
 * Autoloader for all Kirby GEO Classes
 */

use Kirby\Cms\Collection;
use Kirby\Content\Field;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Geo\Geo;
use Kirby\Geo\Point;

load([
	'kirby\\geo\\geo'   => __DIR__ . '/src/Geo.php',
	'kirby\\geo\\point' => __DIR__ . '/src/Point.php'
]);

/**
 * Creates a class alias for the GEO class, to make it more usable
 */
class_alias('Kirby\\Geo\\Geo', 'Geo');

/**
 * Plugin Definition
 */
Kirby::plugin('getkirby/geo', [
	'collectionFilters' => [
		/**
		 * Adds a new radius filter to all collections
		 */
		'radius' => function (
			Collection $collection,
			Field $field,
			array $options
		): Collection {
			$origin = Geo::point($options['lat'] ?? null, $options['lng'] ?? null);
			$radius = (int)($options['radius'] ?? null);
			$unit   = $options['unit'] ?? 'km' === 'km' ? 'km' : 'mi';

			if ($radius === 0) {
				throw new Exception('Invalid radius value for radius filter. You must specify a valid integer value');
			}

			foreach ($collection->data as $key => $item) {
				$value = $collection->getAttribute($item, $field);

				// skip invalid points
				if (
					is_string($value) === false &&
					$value instanceof Field === false
				) {
					unset($collection->$key);
					continue;
				}

				try {
					$point = Geo::point((string)$value);
				} catch (InvalidArgumentException) {
					unset($collection->$key);
					continue;
				}

				$distance = Geo::distance($origin, $point, $unit);

				if ($distance > $radius) {
					unset($collection->$key);
				}
			}

			return $collection;
		}
	],

	'fieldMethods' => [
		/**
		 * Adds a new field method "coordinates",
		 * which can be used to convert a field with
		 * comma separated lat and long values to a Kirby Geo Point
		 */
		'coordinates' => function (Field $field): Point {
			return Geo::point($field->value());
		},

		/**
		 * Adds a new field method "distance",
		 * which can be used to calculate the distance between a
		 * field with comma separated lat and long values and a
		 * valid Kirby Geo Point
		 */
		'distance' => function (
			Field $field,
			Point $point,
			string $unit = 'km'
		): float {
			return Geo::distance($field->coordinates(), $point, $unit);
		},

		/**
		 * Same as distance, but will return a human readable version
		 * of the distance instead of a long float
		 */
		'niceDistance' => function (
			Field $field,
			Point $point,
			string $unit = 'km'
		): string {
			return Geo::niceDistance($field->coordinates(), $point, $unit);
		},
	],
]);
