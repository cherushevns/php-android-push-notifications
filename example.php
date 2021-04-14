$url = "https://fcm.googleapis.com/fcm/send";
$tokens = array('token1', 'token2'); // your devices tokens (limit 500)
$serverKey = 'ApiKey'; // Server Api Key from Firebase Console
$notification = array(
  'title' => $title, // message title
  'body' => $body, // message body
  'sound' => 'default', // sound
);
$arrayToSend = array(
  'registration_ids' => $tokens, 
  'notification' => $notification,
  'priority '=> 'high'
);
$json = json_encode($arrayToSend);
$headers = array(
  'Content-Type: application/json',
  'Authorization: key='. $serverKey
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if (!$response) {
  var_dump('CURL error: ' . curl_error($ch));
  die();
}

curl_close($ch);

$result = json_decode($response, true);
if ((int)$result['success'] == 1)
{
  echo 'Notifications sended successfully!';
}
else
{
  foreach ($result['results'] as $key => $data)
  {
    var_dump($data['error'] . ' for key ' . $tokens[$key]);
    die();
  }
}
