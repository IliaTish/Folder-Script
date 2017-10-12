<?php
	declare(strict_types=1);
	
	const DEFAULT_MARGIN = 25;

	function isCli(): bool {
		return defined('STDIN') || (substr(PHP_SAPI, 0, 3) == 'cgi' && getenv('TERM'));
	}

	function printToConsole(string $directory, int $space = 0): void {
		echo str_repeat("\t", $space).$directory."\n";
	}

	function printToBrowser(string $directory, int $space = 0): void {
		$margin = DEFAULT_MARGIN * $space;
		echo "<p style=\"margin-left: ".$margin."px\">".$directory."</p>";
	}

	function printDirectory(string $directory, bool $cli = true, int $space = 0): void {
		if ($cli) {
			printToConsole($directory, $space);
		}
		else {
			printToBrowser($directory, $space);
		}
	}

	function scanDirectories(string $current_dir, bool $cli = true, int $space = 1): void {
		$folder_array = array_diff(scandir($current_dir),array(".",".."));
		foreach ($folder_array as $key => $folder) {
			$new_dir = $current_dir."/".$folder;
			if (is_dir($new_dir) && !is_link($new_dir)) {
				printDirectory($new_dir, $cli, $space);
				scanDirectories($new_dir, $cli, $space+1);
			}
			else {
				printDirectory($new_dir, $cli, $space);
			}
		}
	}

	$cli = isCli();
	printDirectory(__DIR__,$cli);
	scanDirectories(__DIR__, $cli);