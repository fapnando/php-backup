<?php
/**
 * Backup
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @version  0.1
 * @link     http://github.com/adambrett/php-backup
 */

namespace Backup;

/**
 * Autoload
 *
 * Provides a PSR-0 autoloader if not using Composer.
 *
 * @category Autoloader
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Autoload
{
    /**
     * The project's base directory
     *
     * @var string
     */
    static protected $base;

    /**
     * The project's base namespace
     *
     * @var string
     */
    static protected $namespace;

    /**
     * Register autoloader
     *
     * @return void
     */
    static public function register()
    {
        self::$base = dirname(__FILE__) . '/../';
        self::$namespace = self::parseBaseNamespace(__CLASS__);

        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Autoload classname
     *
     * @param string $className The class to load
     *
     * @return void
     */
    static public function autoload($className)
    {
        $className = ltrim($className, '\\');

        if (strpos($className, self::$namespace) !== 0) {
            return false;
        }

        $fileName  = '';
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        include self::$base . $fileName;
    }

    /**
     * Parse Base Namespace
     *
     * @param string $className The class to parse
     *
     * @return string
     */
    static protected function parseBaseNamespace($className)
    {
        if (strpos($className, '\\') !== false) {
            $parts = explode('\\', $className);
        } else {
            $parts = explode('_', $className);
        }

        return array_shift($parts);
    }
}