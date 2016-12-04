<?php

namespace MBoretto\MessengerBot\Objects;

use MBoretto\MessengerBot\Objects\HasRelations;

/**
 * Class Message.
 *
 *
 * @method string           getMid()                    Message ID
 * @method number           getSeq()                    Message sequence number
 * @method string           getText()                   Text of message
 * @method Attachments[]     getAttachments()           Array containing attachment data
 * @method QuickReply       getQuickReply()             Optional custom data provided by the sending app
 */
class Message extends BaseObject implements HasRelations
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }

    /**
     * (Optional). For text messages, the actual UTF-8 text of the message.
     *
     * @return string
     */
    public function getText()
    {
        return $this->get('text');
    }

    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType()
    {
        $types = [
            'text',
            'audio',
            'document',
            'photo',
            'sticker',
            'video',
            'voice',
            'contact',
            'location',
            'venue',
            'new_chat_member',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }
}
