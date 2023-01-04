<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class GoogleMap extends FieldBuilder
{
    protected string $type = 'google_map';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'center_lat' => '',
            'center_lng' => '',
            'zoom'       => '',
            'height'     => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function centerLat(string $lat): self
    {
        return $this->lat($lat);
    }

    public function lat(string $lat): self
    {
        return $this->set('center_lat', $lat);
    }

    public function centerLng(string $lng): self
    {
        return $this->lng($lng);
    }

    public function lng(string $lng): self
    {
        return $this->set('center_lng', $lng);
    }

    public function zoom(int $zoom): self
    {
        return $this->set('zoom', $zoom);
    }

    public function height(int $height): self
    {
        return $this->set('height', $height);
    }
}
