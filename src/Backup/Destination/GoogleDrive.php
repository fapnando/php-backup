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

namespace Backup\Destination;

/**
 * Backup Google Drive Destination
 *
 *   $client = new \Google_Client();
 *
 *   $client->setClientId($clientId);
 *   $client->setClientSecret($clientSecret);
 *   $client->setAccessToken($accessToken);
 *
 *   $service = new \Google_DriveService($client);
 *
 *   $destination = new \Backup\Destination\GoogleDrive($service);
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class GoogleDrive implements DestinationInterface
{
    protected $service;

    /**
     * __construct
     *
     * @param \Google_DriveService $service Google drive service instance.
     *
     * @return void
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Put
     *
     * @param ArchiveInterface $archive archive to save
     *
     * @return void
     */
    public function put($archive)
    {
        $file = new \Google_DriveFile();
        $file->setTitle($archive->getName());
        $file->setMimeType($archive->getMimeType());

        $this->service->files->insert(
            $file,
            array(
                'data' => $archive->toString(),
                'mimeType' => $archive->getMimeType()
            )
        );
    }
}