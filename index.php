<?php
// Project Name: Office 365 Audit Logs - JSON to CSV Converter
// Last Update: 25-Oct-2024
// Author: g4xyk00

session_start();

/**********************
    Configurations
**********************/

// Input File - Raw CSV file downloaded from O365
$PATH_LOG = "AuditLog.csv"; //Log file in CSV format
$AuditDataColumn = "5"; //Column for AuditData, column F = 5
$inputFile = fopen($PATH_LOG, "r");

// To define Column Name for new CSV
$columnName[0] = "DateTime";
$columnName[1] = "Operation";
$columnName[2] = "Client IP";
$columnName[3] = "User Type";
$columnName[4] = "Workload";
$columnName[5] = "UserId";
$columnName[6] = "User Agent";
$columnName[7] = "User Agent";
$columnName[8] = "Client Process Name";
$columnName[9] = "Application ID";
$columnName[10] = "Logon Error";
$columnName[11] = "External Access";
$columnName[12] = "Mailbox Owner UPN";
$columnName[13] = "Organization Name";
$columnName[14] = "Originating Server";
$columnName[15] = "Affected Path";
$columnName[16] = "Affected Subject";
$columnName[17] = "JSON (Error)";

// Output File
$currentDate = date('Ymd_His');
$fileName = 'AuditData_beautified_'.$currentDate.'.csv';
$outputFile = fopen('php://memory', 'w'); 
fputcsv($outputFile, $columnName); 

// Variables
$rowDataArray = [];

/**********************
   Write Logs in CSV
**********************/

$rowCount = 0;

while(!feof($inputFile)) {
	if($rowCount > 0){
		$current = @fgetcsv(($inputFile))[$AuditDataColumn]; //Audit Data Column
		
		//echo '<pre>'.$rowCount.': '.$current.'</pre>';
		if(strlen(trim($current))>0){
			$obj = json_decode($current);
			
			$rowDataArray[0] = @$obj->{'CreationTime'};
			$rowDataArray[1] = @$obj->{'Operation'};
			$rowDataArray[2] = @$obj->{'ClientIP'};
			$rowDataArray[3] = @$obj->{'UserType'};
			$rowDataArray[4] = @$obj->{'Workload'};
			$rowDataArray[5] = @$obj->{'UserId'};
			$rowDataArray[6] = @$obj->ExtendedProperties[0]->Value;
			$rowDataArray[7] = @$obj->{'ClientInfoString'};
			$rowDataArray[8] = @$obj->{'ClientProcessName'};
			$rowDataArray[9] = @$obj->{'ApplicationId'};
			$rowDataArray[10] = @$obj->{'LogonError'};
			$rowDataArray[11] = @(string)@$obj->{'ExternalAccess'};
			$rowDataArray[12] = @$obj->{'MailboxOwnerUPN'};
			$rowDataArray[13] = @$obj->{'OrganizationName'};
			$rowDataArray[14] = @$obj->{'OriginatingServer'};
			$rowDataArray[15] = @$obj->AffectedItems[2]->ParentFolder->Path;
			$rowDataArray[16] =  @$obj->AffectedItems[3]->Subject;
			$rowDataArray[17] = "";
			
			//if($rowCount > 1 && json_last_error_msg() == 'No error'){
			//if($rowCount > 1 && json_last_error_msg() == 'Syntax error'){
			if($rowCount > 1){
				
				if(json_last_error_msg() != 'No error'){
					$rowDataArray[17] = $current;
				}
				
				fputcsv($outputFile, $rowDataArray);
				$rowDataArray = [];
				//echo '<pre>'.$rowCount.': '.$rowDataArray[0].'</pre>';
				//echo '<pre>'.$rowCount.': '.json_last_error_msg(), PHP_EOL, PHP_EOL.'</pre>'; //To display json_decode error
				//echo '<pre>'.$current.'</pre>';
			}
		}	
	}
	
	$rowCount++;
}

// Move back to beginning of file 
fseek($outputFile, 0); 
     
// Set headers to download CSV file
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $fileName . '";'); 
     
// Output Logs on CSV file 
fpassthru($outputFile); 

exit;
?>
