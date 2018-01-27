<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Shops cell
 */
class ShopsCell extends Cell
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

    public function selectbox($form, $field_name, $label)
    {
        $table = $this->loadModel('Shops');
        $shops = $table->find('list', ['id', 'name'])
            ->orderAsc('zip')
            ->orderAsc('name')
            ->toArray();

        $this->set(compact(['form', 'field_name', 'label', 'shops']));
    }
}
