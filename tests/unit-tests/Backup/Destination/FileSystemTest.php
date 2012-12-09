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

namespace BackupTests\Destination;

use org\bovigo\vfs;
use Faker\Factory as Faker;
use Mockery;

use Backup;

/**
 * FileSystem Destination
 *
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class FileSystemTest extends \PHPUnit_Framework_TestCase
{
    protected $vfs;
    protected $faker;
    protected $path;

    public function setUp()
    {
        $this->faker = Faker::create();
        $this->path = $this->faker->word;
        $this->vfs = vfs\vfsStream::setup($this->path);
    }

    public function testFileGetsSaved()
    {
        $filename = $this->faker->word . '.zip';
        $archive = Mockery::mock('Backup\\Archive\\ArchiveInterface');

        $archive->shouldReceive('getName')
            ->once()
            ->withNoArgs()
            ->andReturn($filename);

        $archive->shouldReceive('toString')
            ->once()
            ->withNoArgs()
            ->andReturn($this->faker->paragraph);

        $destination = new Backup\Destination\FileSystem(vfs\vfsStream::url($this->path));

        $this->assertFalse($this->vfs->hasChild($filename));

        $destination->put($archive);

        $this->assertTrue($this->vfs->hasChild($filename));
    }
}