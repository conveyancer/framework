<?php
/**
 * Conveyancer PHP Framework
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2016-2018 Yan TianZeng<qinuoyun@qq.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://www.ub-7.com
 */
namespace conveyancer\framework;
use SplObjectStorage;
use SplObserver;
use SplSubject;

class register implements SplSubject {
    private $_observers;
    private $_name;
    private $_app;

    public function __construct($name) {
        P(time() . ":" . $name);
        $this->_observers = new SplObjectStorage();
        $this->_name      = $name;
    }

    public function attach(SplObserver $observer) {
        $this->_observers->attach($observer);
    }

    public function detach(SplObserver $observer) {
        $this->_observers->detach($observer);
    }

    public function notify() {
        foreach ($this->_observers as $observer) {
            $observer->update($this);
        }
    }

    public function getName() {
        return $this->_name;
    }

    public function setApp($app = '') {
        $this->_app = $app;
    }

    public function getApp() {
        return $this->_app;
    }
}