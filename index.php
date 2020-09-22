<?php

/**
 * Autoloader for all Kirby GEO Classes
 */
load([
    'kirby\\geo\\geo'   => __DIR__ . '/lib/Geo.php',
    'kirby\\geo\\point' => __DIR__ . '/lib/Point.php'
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
        'radius' => function ($collection, $field, $options) {
            $origin = Geo::point($options['lat'] ?? null, $options['lng'] ?? null);
            $radius = (int)($options['radius'] ?? null);
            $unit   = $options['unit'] ?? 'km' === 'km' ? 'km' : 'mi';

            if (!$origin) {
                throw new Exception('Invalid geo point for radius filter. You must specify valid lat and lng values');
            }

            if ($radius === 0) {
                throw new Exception('Invalid radius value for radius filter. You must specify a valid integer value');
            }

            foreach ($collection->data as $key => $item) {
                $value = $collection->getAttribute($item, $field);

                // skip invalid points
                if (!is_string($value) && !is_a($value, 'Kirby\\Cms\\Field')) {
                    unset($collection->$key);
                    continue;
                }

                try {
                    $point = Geo::point((string)$value);
                } catch (Exception $e) {
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
        'coordinates' => function ($field) {
            return Geo::point($field->value());
        },

        /**
         * Adds a new field method "distance",
         * which can be used to calculate the distance between a
         * field with comma separated lat and long values and a
         * valid Kirby Geo Point
         */
        'distance' => function ($field, $point, $unit = 'km') {
            if (is_a($point, 'Kirby\\Geo\\Point') === false) {
                throw new Exception('You must pass a valid Geo Point object to measure the distance');
            }

            return Geo::distance($field->coordinates(), $point, $unit);
        },

        /**
         * Same as distance, but will return a human readable version
         * of the distance instead of a long float
         */
        'niceDistance' => function ($field, $point, $unit = 'km') {
            if (is_a($point, 'Kirby\\Geo\\Point') === false) {
                throw new Exception('You must pass a valid Geo Point object to measure the distance');
            }

            return Geo::niceDistance($field->coordinates(), $point, $unit);
        },
    ],
]);
