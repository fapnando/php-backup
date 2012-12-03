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

namespace BackupTests;

use Faker\Factory as Faker;
use Mockery;

use Backup;

/**
 * Backup
 *
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class BackupTest extends \PHPUnit_Framework_TestCase
{
    protected $faker;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->faker = Faker::create();
    }

    /**
     * RunCallsSourceReadDirTest
     *
     * @return void
     */
    public function testRunCallsSourceReadDirTest()
    {
        $list = $this->faker->words(5);

        $source = Mockery::mock('Source\\SourceInterface');
        $source->shouldReceive('readDir')
            ->once()
            ->withNoArgs()
            ->andReturn($list);

        $destination = Mockery::mock('Destination\\DestinationInterface');
        $archive = Mockery::mock('Archive\\ArchiveInterface');

        $backup = new Backup\Backup($source, $destination, $archive);

        $this->assertTrue($backup->run());
    }

    public function testRunGetsFileContents()
    {
        $list = $this->faker->words(5);
        $contents = $this->faker->paragraphs(5);

        $source = Mockery::mock('Source\\SourceInterface');
        $source->shouldReceive('readDir')
            ->once()
            ->withNoArgs()
            ->andReturn($list);

        for ($i = 0; $i < 5; $i++) {
            $source->shouldReceive('getFileContents')
                ->once()
                ->with($list[$i])
                ->andReturn($contents[$i])
                ->ordered();
        }

        $destination = Mockery::mock('Destination\\DestinationInterface');
        $archive = Mockery::mock('Archive\\ArchiveInterface');

        $backup = new Backup\Backup($source, $destination, $archive);

        $this->assertTrue($backup->run());
    }

    // public function testRunAddsFilesToArchive()
    // {
    //     $fixture = $this->faker->words(5);

    //     $source = Mockery::mock('Source\\SourceInterface');
    //     $source->shouldReceive('readDir')
    //         ->once()
    //         ->withNoArgs()
    //         ->andReturn($fixture);

    //     $destination = Mockery::mock('Destination\\DestinationInterface');
    //     $archive = Mockery::mock('Archive\\ArchiveInterface');
    //     $archive->shouldReceive('')

    //     $backup = new Backup($source, $destination, $archive);

    //     $this->assertTrue($backup->run());
    // }

    // public function testRunPassesArchiveToDestination()
    // {

    // }
}