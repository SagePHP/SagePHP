<?php
namespace SagePHP\Configuration;

use SagePHP\File\FileInterface;
use SagePHP\Component\Parser\Ini\Ini;

/**
 * helper class to handle php.ini files
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 */
class PhpIni
{
    /**
     * maps a section computed from a key with its real section name.
     * Thank you PHP for beeing so fucking coherent, how hard can it be to make the sections all according to the same rules
     * why the fuck soap.xxxx is in the soap section but mssql.xxx is in the MSSQL sectio ans assert.xxx is in the Assertion
     * FUCK YOU PHP!!!!
     *
     * @var array
     */
    private $sectionMap = array(
        'cli_server'    => 'CLI Server',
        'date'          => 'Date',
        'pcre'          => 'Pcre',
        'pdo_odbc'      => 'Pdo',
        'pdo_mysql'     => 'Pdo_mysql',
        'phar'          => 'Phar',
        'mail'          => 'mail function',
        'sql'           => 'SQL',
        'odbc'          => 'ODBC',
        'ibase'         => 'Interbase',
        'mysql'         => 'MySQL',
        'mysqli'        => 'MySQLi',
        'oci8'          => 'OCI8',
        'pgsql'         => 'PostgreSQL',
        'sybct'         => 'Sybase-CT',
        'mssql'         => 'MSSQL',
        'assert'        => 'Assertion',
        'tidy'          => 'Tidy',
        'session'       => 'Session',
        'com'           => 'COM',
        'cgi'           => 'PHP',
        'fastcgi'       => 'PHP',
        'arg_separator' => 'PHP',
        'zend'          => 'PHP',
        'highlight'     => 'PHP',
        'zlib'          => 'PHP',
        'user_ini'      => 'PHP',
    );

    private $rawContent;

    public function __construct(Ini $parser)
    {
        $this->parser = $parser;
        $this->setContent(php_ini_loaded_file());
    }

    /**
     * {@inheritdoc}
     * Accepts a path, a FileInterface object, a SPLFileInfo, or a string with the contents of the file
     *
     * @param string|FileInterface|SPLFileInfo $rawContents
     */
    public function setContent($content)
    {

        if ($content instanceof FileInterface) {
            $content = $content->load();
        }

        if (is_file($content) && is_readable($content)) {
            $content = file_get_contents($content);
        }

        $this->rawContent = $content;
        $this->parser->setContent($this->rawContent);
    }

    /**
     * gets the (probale) section from akey
     *
     * @param  string $key
     *
     * @return string
     */
    private function getSectionFromKey($key)
    {
        $section = null;

        $parts = explode('.', $key);
        if (count($parts) > 1) {
            $section = $parts[0];
        }

        if (array_key_exists($section, $this->sectionMap)) {
            $section = $this->sectionMap[$section];
        }

        if (null === $section) {
            $section ='PHP';
        }

        return $section;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key, $section = null)
    {
        if (null === $section) {
            $section = $this->getSectionFromKey($key);
        }

        return $this->parser->hasKey($key, $section);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $section = null)
    {
        if (null === $section) {
            $section = $this->getSectionFromKey($key);
        }


        return $this->parser->get($key, $section);
    }

    /**
     * Gets the value of rawContent.
     *
     * @return mixed
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Sets the value of rawContent.
     *
     * @param mixed $rawContent the rawContent
     *
     * @return self
     */
    private function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    public function remove ($key, $section)
    {
        if (null === $section) {
            $section = $this->getSectionFromKey($key);
        }

        return $this->parser->remove($key, $section);
    }

    public function set($key, $section)
    {
        if (null === $section) {
            $section = $this->getSectionFromKey($key);
        }

        return $this->parser->set($key, $section);
    }
}
