MF_Autoloader
=============

**MF_Autoloader** is a component that provides a generic, PHP include_path aware autoloader for use both in the Methodosity Framework and in your own projects.

Installation
------------

You can install MF_Autoloader in two ways:

* Via pear:

    stuart@ubuntu:~$ sudo pear channel-discover pear.methodosity.com 
    Adding Channel "pear.methodosity.com" succeeded
    Discovery of channel "pear.methodosity.com" succeeded

    stuart@ubuntu:~$ sudo pear install MF/MF_Autoloader-alpha
    downloading MF_Autoloader-0.0.3.tgz ...
    Starting to download MF_Autoloader-0.0.3.tgz (1,973 bytes)
    ....done: 1,973 bytes
    install ok: channel://pear.methodosity.com/MF_Autoloader-0.0.3

* Manually:

    git clone git@github.com:stuartherbert/MF_Autoloader.git
    cd MF_Autoloader
    phing install.local

Both of these approaches will install the MF_Autoloader code into your system's standard location (usually /usr/share/php).

Usage
-----

Simply include the autoloader, and it will automatically register itself with
spl_autoload():

    <?php
    define('APP_TOPDIR', path/to/your/webapp);
    // optional - APP_LIBDIR
    define('APP_LIBDIR', APP_TOPDIR . '/libraries');
    require_once 'mf.autoloader.php';

    ?>

APP_TOPDIR must point to the root folder of your webapp. APP_LIBDIR is optional (mf.autoloader.php will define it for you if necessary).

After that, any classes that need autoloading, MF_Autoloader will look for them inside APP_LIBDIR first, and then along your PHP include_path.
