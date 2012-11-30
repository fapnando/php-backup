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

namespace Backup\Source;

/**
 * Backup Source Interface
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
interface SourceInterface
{
    /**
     * Get File
     *
     * @param string $filename name / path to file to get
     *
     * @return string contents of the file
     */
    public function getFileContents($filename);

    /**
     * DirectoryList
     *
     * @param string $directory name / path of directory to list contents for
     * @param bool   $recursive recursively list or not.
     *
     * @return array of file and directory paths
     */
    public function directoryList($directory, $recursive = false);
}