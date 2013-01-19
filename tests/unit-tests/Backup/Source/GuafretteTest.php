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

namespace BackupTests\Source;

use Faker\Factory as Faker;
use Mockery;

use Backup;

/**
 * Gaufrette Source
 *
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class GaufretteTest extends \PHPUnit_Framework_TestCase
{
    public static $faker;

    public function testImplementsInterface()
    {
        $this->assertInstanceOf('\\Backup\\Source\\SourceInterface', $this->ftp);
    }

    public function testDirectoryList()
    {
        $directory = $this->faker->word;

        $adapter = Mockery::mock('stdClass')
            ->expects('keys')
            ->once()
            ->with($directory)
            ->andReturn(true);

        $gaufrette = new Backup\Gaufrette($adapter);

        $this->assertTrue($gaufrette->directoryList($directory));
    }

    public function testGetFileContents()
    {
        $filename = $this->faker->word;

        $adapter = Mockery::mock('stdClass')
            ->expects('read')
            ->once()
            ->with($filename)
            ->andReturn(true);

        $gaufrette = new Backup\Gaufrette($adapter);

        $this->assertTrue($gaufrette->getFileContents($filename));
    }

    public function testIsDirectory()
    {
        $path = $this->faker->word;

        $adapter = Mockery::mock('stdClass')
            ->expects('isDirectory')
            ->once()
            ->with($path)
            ->andReturn(true);

        $gaufrette = new Backup\Gaufrette($adapter);

        $this->assertTrue($gaufrette->getFileContents($path));
    }
}
