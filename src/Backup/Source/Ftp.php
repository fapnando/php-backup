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

use Backup\Exception;

/**
 * Backup FTP Source
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Ftp implements SourceInterface
{
    protected $ftp;

    public function __construct($server, $username, $password, $port = 21)
    {
        $this->connect($server, $port);
        $this->login($username, $password);
    }

    public function __destruct()
    {
        ftp_close($this->ftp);
    }

    public function connect($server, $port)
    {
        $this->ftp = ftp_connect($server, $port);

        if ($this->ftp === false) {
            throw new Exception\UnableToConnect();
        }

        ftp_pasv($this->ftp, true);
    }

    public function login($username, $password)
    {
        $success = ftp_login($this->ftp, $username, $password);

        if ($success === false) {
            throw new Exception\InvalidLoginDetails();
        }
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
        $tempHandle = fopen('php://temp', 'r+');

        $found = ftp_fget($this->ftp, $tempHandle, $filename, FTP_BINARY, 0);
        if ($found === false) {
            throw new Exception\FileNotFound();
        }

        $fstats = fstat($tempHandle);

        if ($fstats['size'] === 0) {
            return '';
        }

        fseek($tempHandle, 0);
        return fread($tempHandle, $fstats['size']);
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
        $contents = ftp_nlist($this->ftp, $directory);

        $cwd = array_search('.', $contents);
        if ($cwd !== false) {
            unset($contents[$cwd]);
        }

        $parent = array_search('..', $contents);
        if ($parent !== false) {
            unset($contents[$parent]);
        }

        sort($contents);
        return array_values($contents);
    }

    public function isDirectory($directory)
    {
        $cwd = ftp_pwd($this->ftp);
        if (!@ftp_chdir($this->ftp, $directory)) {
            return false;
        }

        ftp_chdir($this->ftp, $cwd);
        return true;
    }
}