<?php

// =========================================================================
//
// tests/bootstrap.php
//		A helping hand for running our unit tests
//
//		Created for the Methodosity Framework
//
// Author	Stuart Herbert
//		(stuart@stuartherbert.com)
//
// Copyright	(c) 2010 Stuart Herbert
//		Released under the New BSD license
//
// =========================================================================

// step 1: create the APP_TOPDIR constant that all MF components require
define('APP_TOPDIR', realpath(dirname(__FILE__));

// step 2: make APP_LIBDIR point to this component's src directory, so that
//         we load the code from the local copy
define('APP_LIBDIR', APP_TOPDIR . '/src'));

// step 3: find the autoloader, and install it
if (file_exists(APP_LIBDIR . '/mf.autoloader.php'))
	require_once(APP_LIBDIR . '/mf.autoloader.php');
else
	require_once('mf.autoloader.php');

// all done
