<?php
namespace App\DataBase;

class Config
{
    /**
     * @var string
     */
    private $dsn;

    /**
     * @var string
     */
    private $dbname;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Config constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            if (property_exists(Config::class, $key)) {
                $method = 'set' . ucfirst($key);
                call_user_func_array(array($this, $method), array($value));
            }
        }
        $this->buildDsn();
        $this->fixDefaultOptions();
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @param string $dsn
     */
    public function setDsn($dsn): void
    {
        $this->dsn = $dsn;
    }

    /**
     * Format the real dsn by combining many parameters
     *
     * @return void
     */
    public function buildDsn(): void
    {
        if ($this->dsn == 'mysql') {
            $this->dsn = 'mysql:dbname=' . $this->dbname . ';host=' . $this->host;
        } elseif ($this->dsn == 'sqlite' && $this->host == 'memory') {
            $this->dsn = 'sqlite::memory:';
        }
    }

    /**
     * @return string
     */
    public function getDbname(): string
    {
        return $this->dbname;
    }

    /**
     * @param string $dbname
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    private function fixDefaultOptions()
    {
        $defaultOptions = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];
        $this->options = $defaultOptions + $this->options;
    }
}
