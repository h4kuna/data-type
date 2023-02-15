# Gps

Accept any gps format and transform to array decimal degrees. Output look like:

```php
[0 => latitude, 1 => longitude] // deprecated use key lat and long 
```

Accept formats:

- 50.4113628N, 14.9032000E
- 50.4113628, 14.9032000
- N 50°24.68177', E 14°54.19200'
- 50°24'40.906"N, 14°54'11.520"E
- N50.0835494°E14.4341414°

Output is:

```php
use h4kuna\DataType\Location\Gps;

Gps::fromString('N 50°24.68177\', E 14°54.19200\'');
// ['lat' => 50.4113628, 'long' => 14.9032000);
```
