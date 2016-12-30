<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Attachments.
 * @method string      getType()      image, audio, video, file or location
 * @method string      getPayload()   multimedia or location payload
 */
class Attachments extends BaseObject implements HasRelations
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
