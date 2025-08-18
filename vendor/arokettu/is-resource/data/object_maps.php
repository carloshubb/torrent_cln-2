<?php

// top key is PHP_VERSION_ID for the resource change introduction

// child arrays are maps 'new class name' => 'old resource type string'

return array(
    50600 => array(
        'gmp' => array(
            'GMP' => 'GMP integer',
        ),
    ),
    70200 => array(
        'hash' => array(
            'HashContext' => 'Hash Context'
        ),
    ),
    80000 => array(
        'curl' => array(
            'CurlHandle' => 'curl',
            'CurlMultiHandle' => 'curl_multi',
            'CurlShareHandle' => 'curl_share',
        ),
        'enchant' => array(
            'EnchantBroker' => 'enchant_broker',
            'EnchantDictionary' => 'enchant_dict',
        ),
        'gd' => array(
            'GdImage' => 'gd',
        ),
        'openssl' => array(
            'OpenSSLAsymmetricKey' => 'OpenSSL key',
            'OpenSSLCertificate' => 'OpenSSL X.509',
            'OpenSSLCertificateSigningRequest' => 'OpenSSL X.509 CSR',
        ),
        'shmop' => array(
            'Shmop' => 'shmop',
        ),
        'sockets' => array(
            'AddressInfo' => 'AddressInfo',
            'Socket' => 'Socket',
        ),
        'sysvmsg' => array(
            'SysvMessageQueue' => 'sysvmsg queue',
        ),
        'sysvsem' => array(
            'SysvSemaphore' => 'sysvsem',
        ),
        'sysvshm' => array(
            'SysvSharedMemory' => 'sysvshm',
        ),
        'xml' => array(
            'XMLParser' => 'xml',
        ),
        'xmlrpc' => array(
            'XmlRpcServer' => 'xmlrpc server',
        ),
        'xmlwriter' => array(
            'XMLWriter' => 'xmlwriter',
        ),
        'zlib' => array(
            'DeflateContext' => 'zlib.deflate',
            'InflateContext' => 'zlib.inflate',
        ),
    ),
    80100 => array(
        'fileinfo' => array(
            'finfo' => 'file_info',
        ),
        'ftp' => array(
            'FTP\Connection' => 'FTP Buffer',
        ),
        'imap' => array(
            'IMAP\Connection' => 'imap',
        ),
        'ldap' => array(
            'LDAP\Connection' => 'ldap link',
            'LDAP\Result' => 'ldap result',
            'LDAP\ResultEntry' => 'ldap result entry',
        ),
        'pgsql' => array(
            'PgSql\Connection' => 'pgsql link',
            'PgSql\Result' => 'pgsql result',
            'PgSql\Lob' => 'pgsql large object',
        ),
    ),
    80400 => array(
        'odbc' => array(
            'Odbc\Connection' => 'odbc link',
            // 'odbc link persistent' is an instance of Odbc\Connection too, can't differentiate them
            'Odbc\Result' => 'odbc result',
        ),
        'soap' => array(
            'Soap\Url' => 'SOAP URL',
            'Soap\Sdl' => 'SOAP SDL',
        ),
        'dba' => array(
            'Dba\Connection' => 'dba',
        ),
    ),
);
