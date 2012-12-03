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

    public function testRun()
    {
        $path = $this->faker->word;
        $list = $this->faker->words(5);
        $contents = $this->faker->paragraphs(5);

        $source = Mockery::mock('Backup\\Source\\SourceInterface');
        $source->shouldReceive('directoryList')
            ->once()
            ->with($path)
            ->andReturn($list);

        for ($i = 0; $i < 5; $i++) {
            $source->shouldReceive('getFileContents')
                ->once()
                ->with($list[$i])
                ->andReturn($contents[$i])
                ->ordered();

            $source->shouldReceive('isDirectory')
                ->once()
                ->with($list[$i])
                ->andReturn(false)
                ->ordered();
        }

        $archive = Mockery::mock('Backup\\Archive\\ArchiveInterface');
        $archive->shouldReceive('addEmptyDirectory')
            ->once()
            ->with($path)
            ->andReturn(true);

        for ($i = 0; $i < 5; $i++) {
            $archive->shouldReceive('addFileFromString')
                ->with($list[$i], $contents[$i])
                ->andReturn(true)
                ->ordered();
        }

        $destination = Mockery::mock('Backup\\Destination\\DestinationInterface');
        $destination->shouldReceive('put')
            ->once()
            ->with($archive)
            ->andReturn(true);


        $backup = new Backup\Backup($source, $destination, $archive);

        $this->assertTrue($backup->run($path));
    }

    // public function testRunAddsFilesToArchive()
    // {
    //     $fixture = $this->faker->words(5);

    //     $source = Mockery::mock('Source\\SourceInterface');
    //     $source->shouldReceive('directoryList')
    //         ->once()
    //         ->with($path)
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