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
    public function testHelloWord()
    {
        // $source = new Backup\Source\Ftp(
        //     'hosting.adambrett.co.uk',
        //     'chinnbro',
        //     '5wdsq'
        // );

        // $destination = new Backup\Destination\GoogleDrive(
        //     '27373815357.apps.googleusercontent.com',
        //     'zPNylzhLCucKGdHyBR8JnWwT',
        //     '{"access_token":"ya29.AHES6ZSi_BqOvkwROV18kANIZNGiTzV02yTtjyYAhgY-nb9c9nC25g","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/I28TBiqq-hRw-hVbtb8ZiCXnzLvhJ4x48_jGMOUnMVs","created":1354640946}'
        // );

        // $backup = new Backup\Backup(
        //     $source,
        //     $destination,
        //     new Backup\Archive\Zip('test-backup.zip')
        // );

        // $backup->run('/public_html/img/');
    }
}