<?php

namespace SagePHP\Test;

use SagePHP\Configuration\PhpIni;
use SagePHP\File\File;
use SagePHP\Exception\NotFoundException;

class PhpIniFileTest extends \PHPUnit_Framework_TestCase
{
    private $iniFile;

    protected function setUp()
    {
        $this->fixturePath = __DIR__ . "/../../fixtures/php-ini-file-fixture.ini";

        $this->fileContents = file_get_contents($this->fixturePath);

        $this->iniFile = new PhpIni(new \SagePHP\Component\Parser\Ini\Ini);
        $this->iniFile->setContent($this->fileContents);
    }

    public function testSetContentWithFileInterface()
    {
        $iniFile = new PhpIni(new \SagePHP\Component\Parser\Ini\Ini);
        $iniFile->setContent(new File($this->fixturePath));

        $this->assertEquals($this->fileContents, $iniFile->getRawContent());
    }

    public function testSetContentWithSPLFileInfo()
    {

        $iniFile = new PhpIni(new \SagePHP\Component\Parser\Ini\Ini);
        $iniFile->setContent(new \SPLFileInfo($this->fixturePath));

        $this->assertEquals($this->fileContents, $iniFile->getRawContent());
    }

    public function testSetContentWithPath()
    {

        $iniFile = new PhpIni(new \SagePHP\Component\Parser\Ini\Ini);
        $iniFile->setContent(realpath($this->fixturePath));

        $this->assertEquals($this->fileContents, $iniFile->getRawContent());
    }

    public function testSetContentWithString()
    {

        $iniFile = new PhpIni(new \SagePHP\Component\Parser\Ini\Ini);
        $iniFile->setContent(file_get_contents($this->fixturePath));

        $this->assertEquals($this->fileContents, $iniFile->getRawContent());
    }




    public function testhasWithoutSectionAndWrongKey()
    {
        $this->assertFalse($this->iniFile->has('zxdcfvgbhnjkml,.'));
    }

    /**
     * @dataProvider getValidKeys
     */
    public function testhasWithSectionAndWithMagicKey($key, $section)
    {
        $this->assertTrue($this->iniFile->has($key, $section));
    }


    public function testhasWithoutSectionAndWithWrongey()
    {
        $this->assertFalse($this->iniFile->has('sdrfghjknlm'));
        $this->assertFalse($this->iniFile->has('sdrfgh.jknlm'));
    }

    public function testhasWithSectionAndWithWrongKey()
    {
        $this->assertFalse($this->iniFile->has('fsfsfsdf', 'esrdxfcghvjbkn'));
    }

    /**
     * @dataProvider getValidKeys
     */
    public function testGetWithoutSection($key, $section, $result)
    {
        $this->assertEquals($result, $this->iniFile->get($key));
    }

    /**
     * @dataProvider getValidKeys
     */
    public function testGetWithSection($key, $section, $result)
    {
        $this->assertEquals($result, $this->iniFile->get($key, $section));
    }

    public function getValidKeys()
    {
        return array(
            array('ldap.max_links' , 'ldap' , '-1'),
            array('soap.wsdl_cache_limit' , 'soap' , '5'),
            array('mssql.secure_connection' , 'MSSQL' , 'Off'),
            array('enable_dl' , null , 'Off'),
            array('fastcgi.logging' , null , '0'),
            array('cgi.rfc2616_headers' , null , '0'),
            array('arg_separator.input' , null , '";&"'),
            array('zend.multibyte' , null , 'Off'),
            array('highlight.html' , null , '#000000'),
            array('zlib.output_compression_level' , null , '-1'),
            array('user_ini.filename' , null , '".user.ini"'),
            array('cli_server.color' , 'CLI Server' , 'On'),
            array('date.timezone' , 'Date' , 'Europe/Amsterdam'),
            array('iconv.output_encoding' , 'iconv' , 'ISO-8859-1'),
            array('filter.default' , 'filter' , 'unsafe_raw'),
            array('intl.error_level' , 'intl' , 'E_WARNING'),
            array('sqlite.assoc_case' , 'sqlite' , '0'),
            array('sqlite3.extension_dir' , 'sqlite3' , ''),
            array('pcre.backtrack_limit' , 'Pcre' , '100000'),
            array('pdo_odbc.connection_pooling' , 'Pdo' , 'strict'),
            array('pdo_mysql.default_socket' , 'Pdo_mysql' , ''),
            array('phar.readonly' , 'Phar' , 'On'),
            array('mail.add_x_header' , 'mail function', 'On'),
            array('sql.safe_mode' , 'SQL' , 'Off'),
            array('odbc.default_db' , 'ODBC' , 'Not yet implemented'),
            array('ibase.allow_persistent' , 'Interbase' , '1'),
            array('mysql.allow_local_infile' , 'MySQL' , 'On'),
            array('mysqli.max_persistent' , 'MySQLi' , '-1'),
            array('mysqlnd.collect_statistics' , 'mysqlnd' , 'On'),
            array('oci8.privileged_connect' , 'OCI8' , 'Off'),
            array('pgsql.allow_persistent' , 'PostgreSQL' , 'On'),
            array('sybct.allow_persistent' , 'Sybase-CT' , 'On'),
            array('bcmath.scale' , 'bcmath' , '0'),
            array('session.save_handler' , 'Session' , 'files'),
            array('mssql.allow_persistent' , 'MSSQL' , 'On'),
            array('assert.warning' , 'Assertion' , 'On'),
            array('com.typelib_file' , 'COM' , ''),
            array('mbstring.language' , 'mbstring' , 'Japanese'),
            array('gd.jpeg_ignore_warning' , 'gd' , '0'),
            array('exif.encode_unicode' , 'exif' , 'ISO-8859-15'),
            array('tidy.default_config' , 'Tidy' , '/usr/local/lib/php/default.tcfg'),
            array('soap.wsdl_cache_enabled' , 'soap' , '1'),
            array('sysvshm.init_mem' , 'sysvshm' , '10000'),
            array('ldap.max_links' , 'ldap' , '-1'),
            array('mcrypt.algorithms_dir' , 'mcrypt' , ''),
            array('dba.default_handler' , 'dba' , ''),
        );
    }
}
