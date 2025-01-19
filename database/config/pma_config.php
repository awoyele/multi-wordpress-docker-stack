<?php
/**
 * phpMyAdmin sample configuration
 */

/* Directories for saving/loading files from server */
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

/* Authentication type */
$cfg['Servers'][$i]['auth_type'] = 'cookie';

/* Server parameters */
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['AllowNoPassword'] = false;

/* Tabs display */
$cfg['ShowPhpInfo'] = true;

/* Other settings */
$cfg['MaxRows'] = 50;
$cfg['SendErrorReports'] = 'never';
$cfg['ShowDatabasesNavigationAsTree'] = true;
