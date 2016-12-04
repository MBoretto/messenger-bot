<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Sender.
 *
 *
 * @method string      getId()        Sender user ID
 */
class Sender extends BaseObject implements HasRelations
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
