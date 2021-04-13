<?php
// Max Base
// https://github.com/BaseMax/MergeExcelFilesToOnePerColumns
// 2021-04-13

require "excel.php";

$authors = [];
$counts = [];

$files = glob("*.xlsx");
$files_count = 0;
foreach($files as $file) {
	if($file === "" || $file === "." || $file === "..") {
		continue;
	}
	$files_count++;
	// print $file."\n";
	if($xlsx = SimpleXLSX::parse($file) ) {
		$rows = $xlsx->rows();
		// print_r($rows);
		$values = [];
		foreach($rows as $row) {
			if(isset($row[0], $row[1]) && $row[0] !== "" && $row[1] !== "") {
				$row[1] = $row[1];
				$values[] = $row[1];
			}
		}
		// print_r($values);
		$counts[] = (int) count($rows);
		$authors[] = $values;
	} else {
		echo SimpleXLSX::parseError();
	}
}

// print_r($authors);

// $m = max($counts);
// $c = count($authors);

// for($i=1;$i<=$c;$i++) {
// 	for($j=1;$j<=$m;$j++) {
// 		if(isset($authors[$i-1][$j])) {
// 			print $authors[$i-1][$j];
// 		}
// 		print "\t";
// 	}
// 	print "\n";
// }

for($j=0;$j<500;$j++) {
	$has = false;
	for($i=0;$i<$files_count;$i++) {
		if(isset($authors[$i][$j])) {
			$authors[$i][$j] = trim($authors[$i][$j]);
			if($authors[$i][$j] !== "") {
				$has = true;
				print $authors[$i][$j];
				print "\t";
			}
		}
	}
	if($has === true) {
		print "\n";
	}
}
