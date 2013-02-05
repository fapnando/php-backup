php-backup
==========

[![Build Status](https://travis-ci.org/adambrett/php-backup.png?branch=master)](https://travis-ci.org/adambrett/php-backup?branch=master)

php-backup is a general-purpose, easily-extensible file transfer and archive library for PHP.  It is framework agnostic, allowing you to use it with your framework of choice (or none at all).

It will allow you to transfer a directory and its contents from one place to another without having to worry about the finer details.  The library consists of 4 component parts:

1. [Sources](#sources)
2. [Destinations](#destinations)
3. [Archives](#archives)
4. [The Backup Class](#thebackupclass)

Installation:
-------------

php-backup should be installed using [Composer](http://getcomposer.org). This installer is the community's de-facto standard for distributing and installing PHP components.

Install composer in your project:

    curl -s https://getcomposer.org/installer | php

Create a file named composer.json in the root of your project and include the following:

    {
        "require": {
            "adambrett/php-backup": "*"
        }
    }

Then install via composer:

    php composer.phar install

After installation, you will find php-backup inside your local vendor directory, which is normally `./vendor/`.

Updating:
---------

Update via composer:

    php composer.phar update

Documentation
-------------

Basic usage is as follows:

    <?php

    // composer autoloader
    require_once __DIR__ . '/vendor/autoload.php';

    $source = new \Backup\Source\Ftp(
        $server,
        $username,
        $password,
        $port // optional, defaults to 21
    );

    $destination = new \Backup\Destination\FileSystem('/srv/backup');

    $backup = new Backup\Backup(
        $source,
        $destination,
        new \Backup\Archive\Zip()
    );

    $backup->run();

### Sources

A source is required to implement `\Backup\Source\SourceInterface()` so all are interchangeable without much hassle.  Creating your own sources should be fairly trivial as the interface only has 3 required methods.

### Destinations

As with sources, destinations are required to implement `\Backup\Destination\Interface()`, again so all destinations are interchangeable.  The ultimate aim being any source or destination can be switched out with ease to enable backup from FTP, MySQL, Dropbox, Local Filesystem, whereever, to anything that is accessible from PHP, such as FTP, Amazon S3, Dropbox, Google Drive etc.

### Archives

Archives are probably the most complex part of the library, but only in that they have the most methods to implement if you want to create a custom archive.  Hopefully over time all of the major formats will get covered so the need to implement them yourself will be less and less.

### The Backup Class

The Backup Class or "runner" is where the logic of the backup happens, hopefully this won't need to be modified much, as long as you pass it a valid source, destination, and archive it should perform its job happily.

Development Environment
-----------------------

If you want to patch or enhance this component, you will first need to fork the git repository, clone your local copy, and create a suitable development environment.  Make sure you have PHPUnit installed system-wide then:

    composer update --dev

Please issue any pull requests against the develop branch.
