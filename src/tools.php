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

class tools implements SplObserver {
    private $name;

    protected static $app;

    protected static $class;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update(SplSubject $subject) {
        self::$class = $subject->getName();
        // echo $this->name . ' 这是转静态化 <b>' . $subject->getName() . '</b><br>';
    }

    public static $resolvedInstance = [];

    public static function getAppRoot() {
        return self::resolveAppInstance(static::getAppAccessor());
    }

    protected static function getAppAccessor() {
        return self::$app->class;
    }

    protected static function resolveAppInstance($name) {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        return static::$resolvedInstance[$name] = static::$app[$name];
    }

    public static function setApplication($app) {
        static::$app = $app;
    }

    public static function __callStatic($method, $args) {
        P("A", __CLASS__);
        $class    = 'conveyancer\tool\tool';
        $instance = new $class();
        switch (count($args)) {
        case 0:
            return $instance->$method();

        case 1:
            return $instance->$method($args[0]);

        case 2:
            return $instance->$method($args[0], $args[1]);

        case 3:
            return $instance->$method($args[0], $args[1], $args[2]);

        case 4:
            return $instance->$method($args[0], $args[1], $args[2], $args[3]);

        default:
            return call_user_func_array([$instance, $method], $args);
        }
    }
}