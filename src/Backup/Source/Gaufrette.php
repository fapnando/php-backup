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
 * @license  BSD-3-Clause
 * @version  0.1
 * @link     http://github.com/adambrett/php-backup
 */

namespace Backup\Source;

use Backup\Exception;

/**
 * Backup Gaufrette Source
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  BSD-3-Clause
 * @link     https://github.com/adambrett/php-backup
 */
class Gaufrette implements SourceInterface
{
    protected $adapter;

    public function __construct(\Gaufrette\Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get File
     *
     * @param string $filename name / path to file to get
     *
     * @return string contents of the file
     */
    public function getFileContents($filename)
    {
        return $this->adapter->read($filename);
    }

    /**
     * DirectoryList
     *
     * @param string $directory name / path of directory to list contents for
     *
     * @return array of file and directory paths
     */
    public function directoryList($directory)
    {
        return $this->adapter->keys($directory);
    }

    /**
     * IsDirectory
     *
     * Test to see if a path is a directory or a file
     *
     * @param mixed $path path to test.
     *
     * @return bool
     */
    public function isDirectory($path)
    {
        return $this->adapter->isDirectory($path);
    }
}
