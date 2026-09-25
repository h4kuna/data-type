# Gps

Accept any common GPS format and transform it to decimal degrees. The result has both numeric and named keys:

```php
[0 => latitude, 1 => longitude, 'lat' => latitude, 'long' => longitude]
```

Numeric keys are deprecated, use `lat` and `long`. South and west are negative. Unknown format, unknown pole or a value over 180 throws `InvalidArgumentsException`.

Accepted formats:

- 50.4113628N, 14.9032000E
- 50.4113628, 14.9032000
- N 50°24.68177', E 14°54.19200'
- 50°24'40.906"N, 14°54'11.520"E
- N50.4113628° E14.9032000°

Whitespace after the comma is optional.

```php
use h4kuna\DataType\Location\Gps;

Gps::fromString('N 50°24.68177\', E 14°54.19200\'');
// [0 => 50.4113628, 1 => 14.9032, 'lat' => 50.4113628, 'long' => 14.9032]

Gps::fromString('50.0835494S, 14.4341414W');
// ['lat' => -50.0835494, 'long' => -14.4341414, ...]

Gps::fromString('Hello'); // throws InvalidArgumentsException
```

`Basic\Strings::toGps()` is a shortcut to this method.
