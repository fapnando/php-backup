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

namespace BackupTests\Source;

use Faker\Factory as Faker;
use Mockery;

use Backup;

/**
 * Database Source
 *
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    protected $faker;

    public function testImplementsInterface()
    {
        $adapter = Mockery::mock('\\Backup\\Source\\Database\\SourceInterface');
        $database = new Backup\Source\Database($adapter);

        $this->assertInstanceOf('\\Backup\\Source\\SourceInterface', $database);
    }

    public function testDirectoryListAll()
    {
        $databases = $this->faker->words(3);

        $adapter = Mockery::mock('\\Backup\\Source\\Database\\SourceInterface');

        $adapter->shouldRecieve('databases')
            ->once()
            ->withNoArgs()
            ->andReturn($databases);

        $database = new Backup\Source\Database($adapter);

        $listing = $database->directoryList('/');

        $this->assertCount(count($databases), $listing);

        foreach ($listing as $index => $file) {
            $this->assertEquals($file . '.sql', $database[$index]);
        }
    }

    public function testGetFileContents()
    {
        $databases = $this->faker->words(3);
        $contents = $this->faker->paragraphs(3);

        $adapter = Mockery::mock('\\Backup\\Source\\Database\\SourceInterface');

        $adapter->shouldRecieve('getFileContents')
            ->once()
            ->withNoArgs()
            ->andReturn($databases);

        $database = new Backup\Source\Database($adapter);

        $listing = $database->directoryList('/');

        $this->assertCount(count($databases), $listing);

        foreach ($listing as $index => $file) {
            $this->assertEquals($file . '.sql', $database[$index]);
        }
    }

    public function testIsDirectory()
    {
        $dirname = self::$faker->word . '/';
        mkdir(self::$fixturePath . $dirname, 0777, true);

        $this->assertTrue($this->ftp->isDirectory($dirname));

        $file = $dirname . self::$faker->word . '.txt';
        file_put_contents(
            self::$fixturePath . $file,
            implode("\n\n", self::$faker->paragraphs())
        );

        $this->assertFalse($this->ftp->isDirectory($file));

        unlink(self::$fixturePath . $file);
        rmdir(self::$fixturePath . $dirname);
    }
}
