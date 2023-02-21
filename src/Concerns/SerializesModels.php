<?php

namespace Lorisleiva\Actions\Concerns;

use Illuminate\Queue\SerializesModels as BaseSerializesModels;

trait SerializesModels
{
    use BaseSerializesModels {
        __serialize as protected serializeFromBaseSerializesModels;
        __unserialize as protected unserializeFromBaseSerializesModels;
    }

    public function __serialize()
    {
        array_walk($this->attributes, function (&$value) {
            $value = $this->getSerializedPropertyValue($value);
        });

        return $this->serializeFromBaseSerializesModels();
    }

    public function __unserialize(array $values)
    {
        $this->unserializeFromBaseSerializesModels($values);

        array_walk($this->attributes, function (&$value) {
            $value = $this->getRestoredPropertyValue($value);
        });
    }
}
