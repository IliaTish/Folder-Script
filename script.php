<?php
	declare(strict_types=1);
	
	const default_margin = 25;

	function isCli(): bool {
		return defined('STDIN') || (substr(PHP_SAPI, 0, 3) == 'cgi' && getenv('TERM'));
	}

	function isDot(string $folder): bool {
		if($folder === "." || $folder === ".."){
			return true;
		}
		return false;
	}

	function printDirectoryToConsole(string $directory,int $space = 0): void {
		echo str_repeat("\t",$space).$directory."\n";
	}

	function printDirectoryToBrowser(string $directory,int $space = 0): void{
		$margin = default_margin*$space;
		echo "<p style=\"margin-left: ".$margin."px\">".$directory."</p>";
	}

	function printDirectory(string $directory,int $space = 0): void {
		if(isCli()){
			printDirectoryToConsole($directory,$space);
		}
		else{
			printDirectoryToBrowser($directory,$space);
		}
	}

	function scanDirectories(string $currentDir,int $space = 1): void {
		$folder_array = scandir($currentDir);
		foreach ($folder_array as $key => $folder) {
			if(!isDot($folder)){
				$newDir = $currentDir."/".$folder;
				if(is_dir($newDir) && !is_link($newDir)){
					printDirectory($newDir,$space);
					scanDirectories($newDir,$space+1);
				}
				else{
					printDirectory($newDir,$space);
				}
			}
		}
	}

	printDirectory(__DIR__);
	scanDirectories(__DIR__);