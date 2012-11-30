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
 * Backup Destination Interface
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
interface ArchiveInterface
{
    /**
     * __construct
     *
     * @param string $name Name for the archive.
     *
     * @return void
     */
    public function __construct($name);

    /**
     * AddDirectory
     *
     * @param string $directoryName Name of the directory to add.
     *
     * @return void
     */
    public function addEmptyDirectory($directoryName);

    /**
     * AddFileFromString
     *
     * @param string $fileName     name and path to file in archive.
     * @param string $fileContents content for file.
     *
     * @return void
     */
    public function addFileFromString($fileName, $fileContents);
}