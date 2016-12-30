<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Recipient.
 * @method string      getId()         Recipient user ID
 */
class Recipient extends BaseObject implements HasRelations
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
