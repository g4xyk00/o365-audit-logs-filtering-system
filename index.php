<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
  body {
      position: relative; 
  }
</style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<div>
<?php
session_start();
$PATH_LOG = "AuditLog.csv"; //Log file in CSV format
$FOPEN = fopen($PATH_LOG, "r");
$ipArray = [];
$emailArray = [];
$userAgentArray = [];
$appIDArray = [];

function displayArray($array, $title){
	echo '<hr/>';
	echo '<h2>'.$title.'</h2>';
	echo '<table class="table table-striped table-hover table-condensed">';
	foreach (array_count_values($array) as $a => $occur){
		echo '<tr>';
		echo '<td width="1000">'.$a.'</td>';
		echo '<td>'.$occur.'</td>';
		echo '</tr>';
	}
	echo '</table>';
}

function displayColumnData($data){
	echo '<td>'.$data.'</td>';
}

function getLogDate($datetime){
	return explode('T', $datetime)[0];
}

function getLogTime($datetime){
	$time = @explode('T', $datetime)[1];
	//$time = @explode(':', $time);
	//$hour = (int)$time[0]+8;
	//return (string)$hour+":"+$time[1]+":"+$time[2];
	return $time;
}
?>
<h1>Office 365 Audit Logs Analysis</h1>
<form class="navbar-form navbar-left">
	<input class="form-control" id="myInput" type="text" placeholder="Search..">
</form>
<br/>
<?php
echo '<table class="table table-striped table-hover table-condensed">';
echo '<tr>';
echo '<th>Date</th>';
echo '<th>Time</th>';
echo '<th>Operation</th>';
echo '<th>Client IP</th>';
echo '<th>User Type</th>';
echo '<th>UserId</th>';
echo '<th>User Agent</th>';
echo '<th>User Agent</th>';
echo '<th>Application ID</th>';
echo '<th>Logon Error</th>';
echo '<th>External Access</th>';
echo '<th>Affected Path</th>';
echo '<th>Affected Subject</th>';
echo '</tr>';
echo '<tbody id="myTableBody">';
$rowCount = 0;

while(!feof($FOPEN)) {
	if($rowCount > 0){
		$current = fgetcsv(($FOPEN))[3]; //Audit Data Column	
		if(strlen(trim($current))>0){
			$obj = json_decode($current);
			$creationTime = @$obj->{'CreationTime'};
			$clientIP = @$obj->{'ClientIP'};
			$operation = @$obj->{'Operation'};
			$userType = @$obj->{'UserType'};
			$userID = @$obj->{'UserId'};
			$userAgent1 = @$obj->ExtendedProperties[0]->Value;
			$userAgent2 = @$obj->{'ClientInfoString'};
			$applicationID = @$obj->{'ApplicationId'};
			$logonError = @$obj->{'LogonError'};
			$externalAccess = (String)@$obj->{'ExternalAccess'};
			$path = @$obj->AffectedItems[2]->ParentFolder->Path;
			$subject = @$obj->AffectedItems[3]->Subject;
			//if(explode(':',$clientIP)[0] == "128.227.142.161"){
			if(strlen($creationTime)>0){
				echo '<tr>';
					displayColumnData(getLogDate($creationTime));
					displayColumnData(getLogTime($creationTime));
					displayColumnData($operation);
					displayColumnData($clientIP);
					array_push($ipArray,str_replace(array("[","]"),"",explode(':',$clientIP)[0]));
					displayColumnData($userType);
					displayColumnData($userID);
					array_push($emailArray,$userID);
					displayColumnData($userAgent1);
					displayColumnData($userAgent2);

					if(strlen(trim($userAgent1))>0){
						array_push($userAgentArray,$userAgent1);
					}

					if(strlen(trim($userAgent2))>0){
						array_push($userAgentArray,$userAgent2);
					}

					if(strlen(trim($applicationID))>0){
						array_push($appIDArray,$applicationID);
					}
					displayColumnData($applicationID);
					displayColumnData($logonError);
					displayColumnData($externalAccess);
					displayColumnData($path);
					displayColumnData($subject);
				echo '</tr>';
			}
			//}
		}
	}
	$rowCount++;
}
echo '</tbody>';
echo '</table>';

displayArray($ipArray, "IP Address");
displayArray($emailArray, "Email");
displayArray($userAgentArray, "User Agent");
displayArray($appIDArray, "Application");
?>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</html>