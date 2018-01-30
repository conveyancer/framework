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
/**
 * 框架基础配置文件
 */
class kernel {

    public $driver;

    public $staticize;

    public $register;

    public $drives;

    public $namespace = 'conveyancer';

    public $class = '';

    public function start() {
        #获取驱动列表
        $this->drives = $this->getDeviceList(VENDOR_DIR . DS . 'conveyancer');
        #自动加载类
        //staticize::setApplication($this);
        spl_autoload_register(array($this, 'autoload'));

        // #绑定核心工厂驱动
        // $this->bindDrives();
        // #设置连接器
        // connector::setApplication($this);
        // #启动服务
        // $this->boot();
        // #启动路由
        // routes::start();

    }

    public function autoload($class) {
        P("加载：" . $class);
        #通过外观类加载系统服务
        $file  = str_replace('\\', '/', $class);
        $build = basename($file);
        if (isset($this->drives[$build])) {
            P($build . md5($build));
            $this->class = $build;
            $statics     = 'conveyancer\framework\staticize';
            $name        = 'conveyancer\staticize\\' . $build . md5($build);
            return class_alias($name, $class);
            // unset($clas);
            // #设置驱动设备别名
            // //return class_alias($name, $class);\\
            $dir  = "server" . DS . "connector";
            $name = $this->setConnector($dir, $build);
            //$build = '\\' . str_replace("/", "\\", $dir) . '\\' . $name;
            $build = '\conveyancer\framework\\' . $build;
            #设置驱动设备别名
            return class_alias($build, $class);
        }
    }

    /**
     * 创建链接文件
     * @param string $value [description]
     */
    public function setConnector($dir = '', $class) {
        $name      = $class . md5($class);
        $path      = ROOT_DIR . DS . $dir . DS . $name . '.php';
        $connector = <<<CON
<?php
namespace server\\connector;
use \\conveyancer\\framework\\staticize;
class $name extends staticize{
    protected static function getAppAccessor() {
        return '$class';
    }
}
CON;
        to_mkdir($path, $connector, true, true);
        return $name;
    }

    /**
     * 获取驱动列表.
     *
     * @param string $dir 驱动目录
     *
     * @return array 驱动列表
     */
    public function getDeviceList($dir) {
        $path = array(' . ', ' .  . ', ' . htaccess', ' . DS_Store', 'controllers', 'config', 'framework');
        $ext  = array("php", "html", "htm");
        $list = array();
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (($file = readdir($handle)) !== false) {
                    if (!in_array($file, $path) && !in_array(pathinfo($file, PATHINFO_EXTENSION), $ext)) {
                        $list[$file] = VENDOR_DIR . DS . FRAMEWORK . DS . $file;
                    }
                }
                closedir($handle);
            }
        }
        return $list;
    }

}