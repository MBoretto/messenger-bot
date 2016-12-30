<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Update.
 * @method string       getObject()     Value will be page
 * @method Entry[]      getEntry()      Entry containing event data
 */
class Update extends BaseObject implements HasRelations
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'entry' => Entry::class,
        ];
    }
}
