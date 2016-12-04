<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Entry.
 *
 *
 * @method string               getId()                     Page ID of page
 * @method int                  getTime()                   Time of update (epoch time in milliseconds)
 * @method Messaging[]          getMessaging()              Array containing objects related to messaging
 */
class Entry extends BaseObject implements HasRelations
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'messaging'              => Messaging::class,
        ];
    }
}
