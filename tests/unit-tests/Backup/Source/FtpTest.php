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
 * FTP Source
 *
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class FtpTest extends \PHPUnit_Framework_TestCase
{
    public static $faker;
    public static $fixtures;
    public static $fixturePath;

    public static $server;
    public static $pipes;

    protected $ftp;

    /**
     * SetUp Before Class
     *
     * Run test ftp server and create some dummy files.  We can use
     * the same dummy server for all tests safely as we're only making
     * reads and not writes.
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        self::$faker = Faker::create();

        self::$fixturePath = realpath(__DIR__) . '/fixtures/' . self::$faker->word . '/';

        if (!file_exists(self::$fixturePath)) {
            mkdir(self::$fixturePath, 0777, true);
        }

        for ($i = 0; $i < 5; $i++) {
            $filename = self::$fixturePath . self::$faker->word . '.txt';
            $contents = implode("\n\n", self::$faker->paragraphs());

            file_put_contents($filename, $contents);
            self::$fixtures[$filename] = $contents;
        }

        // server will return files in alpha order
        // but faker will generate in a random order
        ksort(self::$fixtures);

        self::$server = proc_open(
            'python ' . realpath(
                __DIR__ . '/../../../vendor/basic_ftpd.py'
            ),
            array(
                array('pipe', 'r'),
                array('pipe', 'w'),
                array('pipe', 'w')
            ),
            self::$pipes,
            self::$fixturePath
        );

        // wait 1 second for the server to start otherwise we'll
        // get an unable to connect error on the first test
        sleep(1);
    }

    /**
     * TearDown
     *
     * Executed after every test, shuts down the python ftp server
     *
     * @return void
     */
    public static function tearDownAfterClass()
    {
        proc_terminate(self::$server);

        foreach (scandir(self::$fixturePath) as $file) {
            if (in_array($file, array('.', '..'))) continue;

            unlink(self::$fixturePath . $file);
        }

        rmdir(self::$fixturePath);
        rmdir(dirname(self::$fixturePath));
    }

    /**
     * SetUp
     *
     * Run before every test
     *
     * @return void
     */
    public function setUp()
    {
        $this->ftp = new Backup\Source\Ftp(
            'localhost',
            'user',
            '12345',
            3334
        );
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf('\\Backup\\Source\\SourceInterface', $this->ftp);
    }

    public function testDirectoryList()
    {
        $listing = $this->ftp->directoryList('/');

        $this->assertCount(count(self::$fixtures), $listing);

        $filenames = array_keys(self::$fixtures);
        foreach ($listing as $index => $file) {
            $this->assertEquals(basename($filenames[$index]), basename($file));
        }
    }

    public function testGetFileContents()
    {
        foreach (self::$fixtures as $filename => $contents) {
            $remoteContent = $this->ftp->getFileContents(basename($filename));
            $this->assertEquals($contents, $remoteContent);
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
