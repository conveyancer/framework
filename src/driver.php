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
use SplObserver;
use SplSubject;

class driver implements SplObserver {
    private $app;
    private $class;

    public function __construct($app) {
        $this->app = $app;
    }

    public function update(SplSubject $subject) {
        //echo $this->name . ' is reading breakout news <b>' . $subject->getName() . '</b><br>';
    }

    public function getClass() {
        $class = $app->namespace . '\\' . $this->class . '\\' . $this->class;
        return new $class($app);
    }
}