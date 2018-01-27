<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Messages cell
 */
class MessagesCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
    }

    public function unread($from_id = null, $to_id = null)
    {
        $table = $this->loadModel('Messages');
        $message = $table->find('unreadCount', compact('from_id', 'to_id'))->first();
        $this->set('count', $message->count);
    }
}
