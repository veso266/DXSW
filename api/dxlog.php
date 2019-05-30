<?php
mb_internal_encoding("windows-1252"); //for special characters (čšž) to display corecly
header('Content-type: text/plain; charset=windows-1252'); //for special characters (čšž) to display corecly

$Datum = $_GET['datum']; //date
$headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Cookie: youCookieGoesHere',
            'Connection: close',
];

$context = [
    'http' => [
        'method' => 'GET',
        'header' => implode("\r\n", $headers),
        'user_agent' => 'Mitjas FMList Parser/1.0 (+https://github.com/veso266/DXSW)',
        'protocol_version' => 1.1,
        'timeout' => 30,
        'ignore_errors' => true,
    ]
];

$result = file_get_contents('https://www.fmlist.org/fi_log_csv.php?datum='.$Datum, false, stream_context_create($context));
if ($result === false) {
    throw new Exception('Unable to connect to FMList');
}
if (empty($result)) {
    throw new Exception($result, getHttpResponseCode($http_response_header));
}

echo $result;
		
function getHttpResponseCode(array $http_response_header)
{
	if (empty($http_response_header[0])) {
		return 0;
	}        
	if (!preg_match('~^HTTP/1\.[01]\s*([0-9]{3})~i', $http_response_header[0], $match)) {
        return 0;
    }
    return $match[1];
}
?>