<?php
// Max Base
// https://github.com/BaseMax/MergeExcelFilesToOnePerColumns
// 2021-04-13

require "excel.php";
require "excel-create.php";

$authors = [];
$counts = [];
$data = [];

$files = glob("*.xlsx");
$files_count = 0;
// foreach($files as $file) {
for($i=1;$i<=65;$i++) {
	$file = $i.".xlsx";
	if($file === "" || $file === "." || $file === "..") {
		continue;
	}
	// if($files_count > 5) {
	// 	// break;
	// }
	$files_count++;
	// print $file."\n";
	if($xlsx = SimpleXLSX::parse($file) ) {
		$rows = $xlsx->rows();
		// print_r($rows);
		$values = [];
		foreach($rows as $row) {
			if(isset($row[1])) {
				$values[] = $row[1];
			}
			else {
				$values[] = "";
			}
		}
		// print_r($values);
		$counts[] = (int) count($values);
		$authors[] = $values;
		// exit();
		// $values = [];
		// foreach($rows as $row) {
		// 	print_r($row);
		// 	if(isset($row[0], $row[1]) && $row[0] !== "" && $row[1] !== "") {
		// 		$row[1] = $row[1];
		// 		$values[] = $row[1];
		// 	}
		// }
		// // print_r($values);
		// $counts[] = (int) count($values);
		// $authors[] = $values;
		// exit();
	} else {
		echo SimpleXLSX::parseError();
	}
}

// print_r($authors);

$m = max($counts);
// print $m."\n";
// exit();
$c = count($authors);
// print count($authors[0])."\n";
// exit();

for($i=1;$i<=$m;$i++) {
	$data[$i-1] = [];
}

for($i=1;$i<=$m;$i++) {
	for($j=1;$j<=$c;$j++) {
		$data[$i-1][$j-1] = "";
		if(isset($authors[$j-1][$i-1])) {
			$data[$i-1][$j-1] = $authors[$j-1][$i-1];
		}
	}
}
// print_r($data);
// exit();

// for($i=1;$i<=$c;$i++) {
// 	for($j=1;$j<=$m;$j++) {
// 		if(isset($authors[$i-1][$j])) {
// 			print $authors[$i-1][$j];
// 		}
// 		print "\t";
// 	}
// 	print "\n";
// }

// exit();

// for($j=0;$j<500;$j++) {
// 	$has = false;
// 	for($i=0;$i<$files_count;$i++) {
// 		print $i."\t";
// 		if(isset($authors[$i][$j])) {
// 			$authors[$i][$j] = trim($authors[$i][$j]);
// 			if($authors[$i][$j] !== "") {
// 				$has = true;
// 				print $authors[$i][$j];
// 				print "\t";
// 			}
// 		}
// 	}
// 	if($has === true) {
// 		print "\n";
// 	}
// }

$xlsx = SimpleXLSXGen::fromArray($data);
$xlsx->saveAs('res.xlsx');

