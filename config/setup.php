<?php
	require('database.php');

	try {
		$db = new PDO($DB_DSN . ';dbname=' . ';charset=utf8', $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('CREATE DATABASE IF NOT EXISTS ' . $DB_NAME . ' CHARACTER SET utf8;
						USE ' . $DB_NAME);
	
	}
	catch (PDOException $e) {
		echo 'Database connection failed: ' . $e->getMessage() . PHP_EOL;
		die();
	}

	$db->query('CREATE TABLE IF NOT EXISTS users (
		user_id INT(6) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		login VARCHAR(40) UNIQUE NOT NULL,
		email VARCHAR(128) UNIQUE NOT NULL,
		password VARCHAR(255) NOT NULL,
		confirmed BOOLEAN NOT NULL
	)');

	$db->query('CREATE TABLE IF NOT EXISTS pictures (
			img_id INT(6) PRIMARY KEY AUTO_INCREMENT NOT NULL,
			uri LONGTEXT NOT NULL,
			pub_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			author_id INT(6) NOT NULL,
			nb_likes INT(6) NOT NULL DEFAULT 0
		)');

	$db->query('CREATE TABLE IF NOT EXISTS comments (
		com_id INT(6) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		img_id INT(6) NOT NULL,
		author_id INT(6) NOT NULL,
		content MEDIUMTEXT NOT NULL
	)');

	$db->query('CREATE TABLE IF NOT EXISTS likes (
		like_id INT(6) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		img_id INT(6) NOT NULL,
		author_id INT(6) NOT NULL
	)');