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

namespace Backup\Source\Database;

use Backup\Exception;

/**
 * Backup MySQL Source
 *
 * @category Backup
 * @package  Backup
 * @author   Adam Brett <adam@adambrett.co.uk>
 * @license  New BSD LICENSE
 * @link     https://github.com/adambrett/php-backup
 */
class MySQL implements SourceInterface
{
    protected $connection;
    protected $databases;

    public function __construct(\mysqli $connection, $databases = array())
    {
        $this->connection = $connection;

        if (is_string($databases)) {
            $databases = array($databases);
        }
        $this->databases = $databases;
    }

    /**
     * Get a Backup File
     *
     * @param string $database name to backup
     *
     * @return string contents of the dump
     */
    public function dump($database)
    {
        $tempHandle = fopen('php://temp', 'r+');

        fwrite($tempHandle, "SET NAMES utf8;\n");
        fwrite($tempHandle, "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n");
        fwrite($tempHandle, "SET FOREIGN_KEY_CHECKS=0;\n");
        fwrite($tempHandle, "# ----------------------------------------\n\n");

        foreach ($this->tables($database) as $table) {
            $result = $this->connection->query("SHOW CREATE TABLE `$database`.`$table`");
            $row = $result->fetch_assoc();
            $result->close();

            if (isset($row['Create View'])) {
                fwrite($tempHandle, "DROP VIEW IF EXISTS `$table`;\n\n");
                fwrite($tempHandle, $row['Create View'] . ";\n\n");
            } else {
                fwrite($tempHandle, "DROP TABLE IF EXISTS `$table`;\n\n");
                fwrite($tempHandle, $row['Create Table'] . ";\n\n");

                $data = $this->data($database, $table);
                if (!empty($data)) {
                    fwrite($tempHandle, $data . ";\n\n");
                }
            }

            fwrite($tempHandle, "# ----------------------------------------\n\n");
        }


        $fstats = fstat($tempHandle);

        if ($fstats['size'] === 0) {
            return '';
        }

        fseek($tempHandle, 0);
        return fread($tempHandle, $fstats['size']);
    }

    public function databases()
    {
        if (empty($this->databases)) {
            $this->databases = array();

            $result = $this->connection->query('SHOW DATABASES');
            while ($database = $result->fetch_row()) {
                $this->databases[] = $database[0];
            }

            $result->close();
        }

        return $this->databases;
    }

    public function tables($database)
    {
        $tables = array();

        $result = $this->connection->query("SHOW TABLES FROM `$database`");
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
        $result->close();

        return $tables;
    }

    public function data($database, $table)
    {
        $numeric = array();
        $result = $this->connection->query("SHOW COLUMNS FROM `$database`.`$table`");
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $column = $row['Field'];
            $columns[] = '`' . str_replace('`', '``', $column) . '`';
            $numeric[$column] = preg_match(
                '#BYTE|COUNTER|SERIAL|INT|LONG|CURRENCY|REAL|MONEY|FLOAT|DOUBLE|DECIMAL|NUMERIC|NUMBER#i',
                $row['Type']
            ) === 1;
        }
        $result->close();

        $columns = '(' . implode(', ', $columns) . ')';

        $values = array();
        $result = $this->connection->query("SELECT * FROM `$database`.`$table`", MYSQLI_USE_RESULT);

        while ($row = $result->fetch_assoc()) {
            $tmp = '(';
            foreach ($row as $key => $value) {
                if ($value === null) {
                    $tmp .= "NULL";
                } elseif ($numeric[$key]) {
                    $tmp .= $value;
                } else {
                    $tmp .= "'" . $this->connection->real_escape_string($value) . "'";
                }
                $tmp .= ', ';
            }
            $tmp = substr($tmp, 0, -2) . ')';

            $values[] = $tmp;
        }

        $result->close();

        if (empty($values)) {
            return false;
        }

        return "INSERT INTO `$table` $columns VALUES\n" . implode(",\n", $values);
    }
}