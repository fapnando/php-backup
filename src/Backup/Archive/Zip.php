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

namespace Backup\Archive;

/**
 * Backup Zip Archive
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Zip implements ArchiveInterface
{
    public $mime = 'application/zip';
    public $name;

    protected $tmpFile;
    protected $archive;

    /**
     * __construct
     *
     * @param string $name Name for the archive.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;

        $this->tmpFile = tempnam(sys_get_temp_dir(), $this->name);
        $this->archive = new \ZipArchive();
        $this->archive->open($this->tmpFile);
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
        $this->archive->addEmptyDir($directoryName);
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
        $this->archive->addFromString($fileName, $fileContents);
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
        return $this->mime;
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
        $this->archive->close();
        $contents = file_get_contents($this->tmpFile);
        unlink($this->tmpFile);
        return $contents;
    }
}