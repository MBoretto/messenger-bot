<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Messaging.
 *
 *
 * @method Sender             getSender()        Sender user ID
 * @method Receiver           getReceiver()      Receiver user ID
 * @method int                getTimestamp()     (Optional).
 * @method Message            getMessage()       (Optional). Message Object
 * @method Postback                              (Optional).
 * @method Option                                 (Optional).
 * @method AccountLinking                        (Optional).
 * @method Delivery                              (Optional).
 * @method Read                                  (Optional).
 * @method CheckoutUpdate                        (Optional).
 * @method Payment                               (Optional).
 */
class Messaging extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'sender'               => Sender::class,
            'recipient'            => Recipient::class,
            'message'              => Message::class,
        ];
    }

    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType()
    {
        $types = [
            'message',
            'postback',
            'optin',
            'account_linking',
            'delivery',
            'read',
            'checkout_update',
            'payment',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }
}
