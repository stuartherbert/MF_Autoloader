<?php

// if the user has defined an APP_LIBDIR, push that to the front of the
// PHP include path
if (defined('APP_LIBDIR'))
{
        // push APP_LIBDIR to the front of PHP's include path, so that we can
        // use PHP's normal require and include functions
        set_include_path(APP_LIBDIR . PATH_SEPARATOR . get_include_path());
}

// autoloader support

/**
 * Implements the normalisation standard from here:
 * http://groups.google.com/group/php-standards/web/psr-0-final-proposal
 *
 * @param <type> $namespaceOrClass
 * @return <type>
 */
function __mf_normalise_classpath($className)
{
        $fileName  = '';
        $lastNsPos = strripos($className, '\\');

        if ($lastNsPos !== false)
        {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        return $fileName . str_replace('_', DIRECTORY_SEPARATOR, $className);
}

/**
 * include a PHP script to bootstrap a namespace
 *
 * for example, if you want to bootstrap MF\WebApp, this function would
 * attempt to include the file MF/WebApp/_init/WebApp.init.php
 *
 * @param string $namespace the namespace to bootstrap
 * @param string $fileExt the suffix of the file to load (default is '.init.php')
 * @return boolean false if the bootstrap file could not be found
 */
function __mf_init_namespace($namespace, $fileExt = '.init.php')
{
        static $loadedNamespaces = array();

        // have we loaded this namespace before?
        if (isset($loadedNamespaces[$namespace]))
        {
                // yes we have - bail
                return;
        }

        $path = str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
        $filename = $path . '/_init/' . end(explode(DIRECTORY_SEPARATOR, $path)) . $fileExt;
        $loadedModules[$namespace] = $filename;

        var_dump($filename);

        __mf_include($filename);
}

/**
 * include a PHP file to bootstrap tests for a namespace
 *
 * for example, if you want to bootstrap tests for MF\\WebApp, this
 * function would include the file MF/WebApp/_init/WebApp.initTests.php
 *
 * This is typically used to load shared tests into a unit test script.
 * It was originally created for MF_Datastore; that is probably the best
 * place to go and look for examples of how it can be useful
 *
 * @param string $namespace the namespace to bootstrap the tests from
 */
function __mf_init_tests($namespace)
{
        __mf_init_namespace($namespace, '.initTests.php');
}

/**
 * Autoloader function
 *
 * Do not call this function directly. PHP calls it for you.
 *
 * @param string $classname
 * @return boolean false if the class could not be found
 */
function __mf_autoload($classname)
{
        if (class_exists($classname) || interface_exists($classname))
        {
                return TRUE;
        }

        // convert the classname into a filename on disk
        $classFile = __mf_normalise_classpath($classname) . '.php';

        return __mf_include($classFile);
}

/**
 * Internal function used by __mf_autoload()
 *
 * @param <type> $filename
 * @return boolean false if the file to include could not be found
 */

function __mf_include($filename)
{
	if (defined('SEARCH_APP_LIBDIR_ONLY'))
	{
		$pathToSearch = array(APP_LIBDIR);
	}
	else
	{
        	$pathToSearch = explode(PATH_SEPARATOR, get_include_path());
	}

        // keep track of what we have tried; this info may help other
        // devs debug their code
        $failedFiles = array();

        foreach ($pathToSearch as $searchPath)
        {
                $fileToLoad = $searchPath . '/' . $filename;
                if (!file_exists($fileToLoad))
                {
                        $failedFiles[] = $fileToLoad;
                        continue;
                }

                require($fileToLoad);
                return TRUE;
        }

        // if we get here, we could not find the requested file
        // we do not die() or throw an exception, because there may
        // be other autoload functions also registered
        return FALSE;
}

// install our autoloader
spl_autoload_register('__mf_autoload');
