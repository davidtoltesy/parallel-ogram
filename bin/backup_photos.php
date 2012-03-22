<?php

	$root = dirname(dirname(__FILE__));
	ini_set("include_path", "{$root}/www:{$root}/www/include");

	set_time_limit(0);

	# Honestly, it feels a bit weird to do this in a backfill script
	# and I bet there will be enough administrivia around backups
	# (maybe?) that they will need to be moved in to their own table
	# but for now... it works. (20120321/straup)

	include("include/init.php");

	loadlib("backfill");
	loadlib("instagram_photos_import");

	function _backup($insta_user, $more=array()){
		$rsp = instagram_photos_import_for_user($insta_user);
		dumper($rsp);
	}

	$sql = "SELECT * FROM InstagramUsers WHERE backup_photos=1";
	backfill_db_users($sql, '_backup');

	exit();
?>