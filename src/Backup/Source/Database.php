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

namespace Backup\Source;

use Backup\Exception;

/**
 * Backup Database Source
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Database implements SourceInterface
{
    protected $adapter;

    public function __construct(Database\SourceInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get a Backup File
     *
     * @param string $database name to backup
     *
     * @return string contents of the dump
     */
    public function getFileContents($database)
    {
        return $this->adapter->dump(substr($database, 1));
    }

    /**
     * DirectoryList
     *
     * @param string $database ignored for MySQL
     *
     * @return array of databases to backup
     */
    public function directoryList($database)
    {
        return $this->adapter->databases();
    }

    /**
     * IsDirectory
     *
     * @param mixed $database ignored for MySQL.
     *
     * @return mixed Value.
     */
    public function isDirectory($database)
    {
        return false;
    }
}