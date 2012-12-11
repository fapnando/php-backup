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

namespace BackupTests\Destination;

use Faker\Factory as Faker;
use Mockery;

use Backup;

/**
 * Google Drive Destination
 *
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class GoogleDriveTest extends \PHPUnit_Framework_TestCase
{
    protected $faker;

    public function setUp()
    {
        $this->faker = Faker::create();
    }

    public function testPut()
    {
        $data = $this->faker->paragraph;
        $mime = $this->faker->word;

        $archive = Mockery::mock('\\Backup\\Archive\\ArchiveInterface');
        $archive->shouldReceive('getName')
            ->once()
            ->withNoArgs()
            ->andReturn($data);

        $archive->shouldReceive('getMimeType')
            ->once()
            ->withNoArgs()
            ->andReturn($mime);

        $files = Mockery::mock('\\stdClass');
        $files->shouldReceive('insert')
            ->with(
                \Mockery::type('\\Google_DriveFile'),
                array(
                    'data' => $data,
                    'mimeType' => $mime
                )
            );

        $service = new \stdClass();
        $service->files = $files;

        $googleDrive = new \Backup\Destination\GoogleDrive($service);
        $googleDrive->put($archive);

        $this->assertTrue(true);
    }
}