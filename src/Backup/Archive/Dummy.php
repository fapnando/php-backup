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
 * @version  1.0
 * @link     http://github.com/adambrett/php-backup
 */

namespace Backup\Archive;

/**
 * Dummy Backup Archive
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Dummy implements ArchiveInterface
{
    public $name = '';

    /**
     * __construct
     *
     * @param string $name Name for the archive.
     *
     * @return void
     */
    public function __construct($name = 'text.txt')
    {
        $this->name = $name;
    }

    /**
     * AddDirectory
     *
     * @param string $directoryName Name of the directory to add.
     *
     * @return void
     */
    public function addEmptyDirectory($directoryName)
    {
        return null;
    }

    /**
     * AddFileFromString
     *
     * @param string $fileName     name and path to file in archive.
     * @param string $fileContents content for file.
     *
     * @return void
     */
    public function addFileFromString($fileName, $fileContents)
    {
        return null;
    }

    /**
     * GetName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * GetMimeType
     *
     * Return the mime type of the archive for Destinations that
     * require it.
     *
     * @return string
     */
    public function getMimeType()
    {
        return 'text/plain';
    }

    /**
     * ToString
     *
     * Return the archive itself in string/binary format ala PHPs
     * file_get_contents()
     *
     * @return string
     */
    public function toString()
    {
        return 'Hello World.';
    }
}