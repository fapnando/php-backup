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
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @version  0.1
 * @link     http://github.com/adambrett/php-backup
 */

namespace Backup;

/**
 * Backup
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Backup
{
    protected $source;
    protected $destination;
    protected $archive;

    /**
     * Constructor
     *
     * @param Source\SourceInterface           $source      Description.
     * @param Destination\DestinationInterface $destination Description.
     * @param Archive\ArchiveInterface         $archive     Description.
     *
     * @return void
     */
    public function __construct(
        Source\SourceInterface $source,
        Destination\DestinationInterface $destination,
        Archive\ArchiveInterface $archive
    ) {
        $this->source = $source;
        $this->destination = $destination;
        $this->archive = $archive;
    }

    /**
     * Run
     *
     * @param string $path      path to the directory to backup
     * @param bool   $recursive has the function been called recursively?
     *
     * @return void
     */
    public function run($path = '/', $recursive = false)
    {
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }

        $this->archive->addEmptyDirectory($path);
        $files = $this->source->directoryList($path);

        foreach ($files as $file) {
            if ($this->source->isDirectory($path . $file)) {
                $this->run($file, true);
            } else {
                $contents = $this->source->getFileContents($path . $file);
                $this->archive->addFileFromString($path . $file, $contents);
            }
        }

        if (!$recursive) {
            return $this->destination->put($this->archive);
        }

        return true;
    }
}
