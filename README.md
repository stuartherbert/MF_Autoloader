MF_Autoloader
=============

**MF_Autoloader** is a component that provides a generic, PHP include_path aware autoloader for use both in the Methodosity Framework and in your own projects.

Installation
------------

You can install MF_Autoloader in two ways:

Via pear:

    stuart@ubuntu:~$ sudo pear channel-discover pear.methodosity.com 
    Adding Channel "pear.methodosity.com" succeeded
    Discovery of channel "pear.methodosity.com" succeeded

    stuart@ubuntu:~$ sudo pear install MF/MF_Autoloader
    downloading MF_Autoloader-0.0.3.tgz ...
    Starting to download MF_Autoloader-0.0.3.tgz (1,973 bytes)
    ....done: 1,973 bytes
    install ok: channel://pear.methodosity.com/MF_Autoloader-0.0.3

From source:

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

Development
-----------

You will need the following dependencies installed first.

* Phing
* d51PearPkg2Task plugin for Phing from domain51.com
* PHPUnit
* xdebug
* pdepend
* phpDocumentor
* phpmd
* phpcpd
* phpcs
* phpcb

This component includes a build.xml file containing several options to make life a little easier.

    stuart@ubuntu:~/MF/MF_Autoloader$ phing
    Buildfile: /home/stuart/MF/MF_Autoloader/build.xml

    MF_Autoloader > help:

         [echo] MF_Autoloader 0.0.3: build.xml targets:
         [echo] 
         [echo] test
         [echo]   Run the component's PHPUnit tests
         [echo] code-review
         [echo]   Run code quality tests (pdepend, phpmd, phpcpd, phpcs)
         [echo] pear-package
         [echo]   Create a PEAR-compatible package
         [echo] install.local
         [echo]   Install this component from source
         [echo]   You must be root to run this target!!
         [echo] publish
         [echo]   Publish the pear package onto the channel server
         [echo] clean
         [echo]   Remove all temporary folders created by this build file

    BUILD FINISHED

    Total time: 0.2625 seconds

License
-------

**This component is released under the new-style BSD license.**

Copyright (c) 2010, Stuart Herbert
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
