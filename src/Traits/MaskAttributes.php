<?php

namespace Alvarofpp\Masks\Traits;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Str;

trait MaskAttributes
{
    /**
     * MaskAttributes constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if (! property_exists($this, 'maskSuffix')) {
            $this->maskSuffix = '_masked';
        }

        if (! property_exists($this, 'masks')) {
            $this->masks = [];
        }
    }

    /**
     * Takes the masks for each attribute.
     * [$attribute => $mask]
     *
     * @return array
     */
    public function getMasks()
    {
        return $this->masks;
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if (! $this->masksIsEmpty()) {
            foreach ($this->getMasks() as $key => $mask) {
                $newKey = $this->getKeyWithMask($key);
                $attributes[$newKey] = mask($mask, $this->$key);
            }
        }

        return $attributes;
    }

    /**
     * Append attributes to query when building a query.
     *
     * @param  array|string  $attributes
     * @return $this
     */
    public function append($attributes)
    {
        dd($attributes);
        return parent::append($attributes);
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $attributes = parent::getAttribute($key);

        if (is_null($attributes) && $this->CheckKeyIsValid($key)) {
            $originalAttribute = $this->getKeyWithoutMask($key);
            $attributes = mask($this->getMasks()[$originalAttribute], $this->$originalAttribute);
        }

        return $attributes;
    }

    /**
     * Checks to see if the key is valid.
     *
     * @param $key
     * @return bool
     */
    private function CheckKeyIsValid($key)
    {
        if ($this->masksIsEmpty()) {
            return false;
        }

        return Str::endsWith($key, $this->maskSuffix)
            && key_exists($this->getKeyWithoutMask($key), $this->getMasks());
    }

    /**
     * Checks to see if the mask vector is empty.
     *
     * @return bool
     */
    private function masksIsEmpty()
    {
        return count($this->getMasks()) == 0;
    }

    /**
     * Takes the key from the original attribute.
     *
     * @param $key
     * @return string
     */
    private function getKeyWithoutMask($key)
    {
        return Str::replaceLast($this->maskSuffix, '', $key);
    }

    /**
     * Takes the key of the attribute with masked value.
     *
     * @param $key
     * @return string
     */
    private function getKeyWithMask($key)
    {
        return Str::snake($key) . $this->maskSuffix;
    }
}
