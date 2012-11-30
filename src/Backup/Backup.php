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
 * @category Tests
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @version  1.0
 * @link     http://github.com/adambrett/php-backup
 */

namespace Backup;

/**
 * Backup
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class Backup
{
    protected $source;
    protected $destination;

    /**
     * Constructor
     *
     * @param Source\SourceInterface           $source      Description.
     * @param Destination\DestinationInterface $destination Description.
     *
     * @return void
     */
    public function __construct(
        Source\SourceInterface $source,
        Destination\DestinationInterface $destination
    ) {
        $this->source = $source;
        $this->destination = $destination;
    }

    /**
     * Run
     *
     * @return void
     */
    public function run()
    {

    }
}