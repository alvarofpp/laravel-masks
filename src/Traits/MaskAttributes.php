<?php

namespace Alvarofpp\Masks\Traits;

use Illuminate\Support\Str;

trait MaskAttributes
{
    /**
     * Takes the masks for each attribute.
     * [$attribute => $mask]
     *
     * @return array
     */
    public function getMasks()
    {
        if (property_exists($this, 'masks')) {
            return $this->masks;
        }
        return [];
    }

    /**
     * Takes the mask suffix used.
     *
     * @return string
     */
    public function getMaskSuffix()
    {
        if (property_exists($this, 'maskSuffix')) {
            return $this->maskSuffix;
        }
        return '_masked';
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

        return Str::endsWith($key, $this->getMaskSuffix())
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
        return Str::replaceLast($this->getMaskSuffix(), '', $key);
    }

    /**
     * Takes the key of the attribute with masked value.
     *
     * @param $key
     * @return string
     */
    private function getKeyWithMask($key)
    {
        return Str::snake($key) . $this->getMaskSuffix();
    }
}
