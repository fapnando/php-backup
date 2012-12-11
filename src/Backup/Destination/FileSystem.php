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

namespace Backup\Destination;

/**
 * Backup FileSystem Destination
 *
 * Save the backup to the local filesystem
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class FileSystem implements DestinationInterface
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Put
     *
     * @param ArchiveInterface $archive archive to save
     *
     * @return void
     */
    public function put($archive)
    {
        $path = $this->path . DIRECTORY_SEPARATOR . $archive->getName();
        $file = new \SplFileObject($path, 'w+');
        $file->fwrite($archive->toString());
    }
}