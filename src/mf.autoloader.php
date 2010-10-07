<?php

// ========================================================================
// Step 1: Setup key global constants
//
// ------------------------------------------------------------------------

// APP_TOPDIR must always be defined by the caller.
//
// We deliberately do not try to set APP_TOPDIR ourselves.  The caller must
// define APP_TOPDIR to prove that their PHP script is one that is meant
// to be accessed deliberately from a web browser.

if (!defined('APP_TOPDIR'))
{
        throw new Exception('APP_TOPDIR not defined');
}

if (!defined('APP_LIBDIR'))
{
        define('APP_LIBDIR', APP_TOPDIR . '/libraries');
}

// push APP_LIBDIR to the front of PHP's include path, so that we can
// use PHP's normal require and include functions
set_include_path(APP_LIBDIR . PATH_SEPARATOR . get_include_path());

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

function __mf_init_tests($namespace)
{
        __mf_init_namespace($namespace, '.initTests.php');
}

function __mf_autoload($classname)
{
        if (class_exists($classname) || interface_exists($classname))
        {
                return FALSE;
        }

        // convert the classname into a filename on disk
        $classFile = __mf_normalise_classpath($classname) . '.php';

        return __mf_include($classFile);
}

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

spl_autoload_register('__mf_autoload');

?>
