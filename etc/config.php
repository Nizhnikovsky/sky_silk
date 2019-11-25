<?php


use App\Core\Config;

/**
 * Routing
 */
Config::set('routes', ['default']);
Config::set('adminRoute', 'admin');
Config::set('defaultRoute', 'default');
Config::set('defaultController', 'pages');
Config::set('defaultAction', 'index');

/**
 * Lang
 */
Config::set('languages', ['en', 'ru']);
Config::set('defaultLanguage', 'ru');



/**
 * Debug
 */
Config::set('debug', false);


/**
 * Meta
 */
Config::set('siteName', 'Public Blog');


/**
 * Database
 */
Config::set('db','sqlite');

Config::set('mysql.host', 'localhost:3306');
Config::set('mysql.user', 'root');
Config::set('mysql.password', '');
Config::set('mysql.name', 'mvc');

Config::set('sqlite.filename', 'mvc.db');
/**
 * Redis
 */

Config::set('redis.host', 'localhost');
Config::set('redis.port', 6379);

Config::set('hash','281185101cfbeac7532afd4ac0ad27ee0b44b335f40eecb81ab4a3de915ce77e');
