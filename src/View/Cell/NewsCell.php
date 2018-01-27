<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * News cell
 */
class NewsCell extends Cell
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

    public function released($limit = null)
    {
        $this->loadModel('News');
        $news = $this->News->find('released');
        if ($limit) {
            $news->limit($limit);
        }
        $this->set('news', $news);
    }
}
