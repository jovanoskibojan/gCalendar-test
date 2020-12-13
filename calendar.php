<?php
error_reporting(E_ERROR | E_PARSE);
require __DIR__ . '/vendor/autoload.php';

class Calendar {
    private $client = '';

    function __construct() {
        $this->client = $this->getClient();
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     * @throws Google_Exception
     */
    private function getClient() {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    public function formValidation($formData) {
        $errors = [];
        $hasError = false;

        foreach ($formData as $key => $data) {
            $error = [];
            if(empty($data) && $key != 'note') {
                if($key != 'date') {
                    $hasError = true;
                    $error['status'] = false;
                    $error['field'] = $key;
                    $error['error'] = 'This field should not be empty';
                }
            }
            else {
                $error['status'] = true;
                $error['field'] = $key;
            }
            $errors['errors'][] = $error;
        }

        $phoneNum = preg_replace("/[^0-9]/", "", $formData['phone'] );
        $phoneLength = strlen($phoneNum);
        if ((preg_match("/[^0-9-.()+\/]/", $formData['phone']))) {
            $error = [];
            $hasError = true;
            $error['status'] = false;
            $error['field'] = 'phone';
            $error['error'] = 'Please enter valid phone number';
        }
        else {
            $error['status'] = true;
            $error['field'] = 'phone';
        }
        $errors['errors'][] = $error;

        if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $error = [];
            $hasError = true;
            $error['status'] = false;
            $error['field'] = 'email';
            $error['error'] = 'Please enter valid email address';
        }
        else {
            $error['status'] = true;
            $error['field'] = 'email';
        }
        $errors['errors'][] = $error;

        if(!$hasError) {
            $errors['success'] = true;
        }
        else {
            $errors['success'] = false;
        }
        return $errors;
    }

    public function addToCalendar($data) {
        $client = $this->client;

        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $note = $data['note'];
        $startDate = date('c', strtotime($data['date']. ", " .$data['time'])); //datetimes must be in this format
        $time = new DateTime($startDate);
        $time->add(new DateInterval('PT' . 30 . 'M'));
        $endDate = date("c", strtotime('+30 minutes', $startDate)); //datetimes must be in this format
        $endDate = $time->format('c');; //datetimes must be in this format

        $cal = new Google_Service_Calendar($client);

        if ($client->getAccessToken()) {
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $name,
                'description' => $note,
                'start' => array(
                    'dateTime' => $startDate,
                    'timeZone' => 'America/Los_Angeles',
                ),
                'end' => array(
                    'dateTime' => $endDate,
                    'timeZone' => 'America/Los_Angeles',
                ),'attendees' => array(
                    array('email' => $email),
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'email', 'minutes' => 15),
                        array('method' => 'email', 'minutes' => 10),
                    ),
                ),
            ));

            $calendarId = '8irhh2s9mr6tc860g9lofhv2kk@group.calendar.google.com';
            //  $event = $cal->events->insert($calendarId, $event, array('sendUpdates' => 'all'));
            $event = $cal->events->insert($calendarId, $event);
            $message = [];
            $message['success'] = true;
            $message['link'] = $event->htmlLink;
            return $message;
            // Calendar link:
            // https://calendar.google.com/calendar/u/0?cid=OGlyaGgyczltcjZ0Yzg2MGc5bG9maHYya2tAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ
        }
    }
}

$calendar = new Calendar();
$formResponse = $calendar->formValidation($_POST);
if($formResponse['success']) {
    $formResponse = $calendar->addToCalendar($_POST);
}
echo json_encode($formResponse);