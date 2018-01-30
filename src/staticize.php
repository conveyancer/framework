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

class staticize {

    protected static $name;

    protected static $app;

    protected static $class;

    public static $resolvedInstance = [];

    public static function getAppRoot() {
        return self::resolveAppInstance(static::getAppAccessor());
    }

    protected static function getAppAccessor() {
        throw new \RuntimeException("外观没有实现getAppAccessor方法");
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
        //P([get_class(), get_called_class(), __NAMESPACE__]);
        $name = self::getAppAccessor();
        P($name);
        // $class    = 'conveyancer\\' . self::$class . '\\' . self::$class;
        // $instance = new $class();
        // switch (count($args)) {
        // case 0:
        //     $instance->$method();
        //     break;
        // case 1:
        //     $instance->$method($args[0]);
        //     break;
        // case 2:
        //     $instance->$method($args[0], $args[1]);
        //     break;
        // case 3:
        //     $instance->$method($args[0], $args[1], $args[2]);
        //     break;
        // case 4:
        //     $instance->$method($args[0], $args[1], $args[2], $args[3]);
        //     break;
        // default:
        //     call_user_func_array([$instance, $method], $args);
        //     break;
        // }
    }
}