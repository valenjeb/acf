<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class OEmbed extends FieldBuilder
{
    protected string $type = 'oembed';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'width'  => '',
            'height' => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function width(int $width): self
    {
        return $this->set('width', $width);
    }

    public function height(int $height): self
    {
        return $this->set('height', $height);
    }
}
