<?php
require_once('base.php');
require_once(getBasePath('lib/functions.php'));
useDeLocale();

session_start();

if (!isAllowed(true)) {
    die("not allowed");
}

$input = substr($_POST['text'], 1, -1);
$result = getAnswerFromAI($input);
foreach ($result->choices as $choice) {
    echo sprintf('<li>%s</li>', substr(trim($choice->text), 1, -1));
}

function getAnswerFromAI($input)
{
    if (empty($input)) {
        return json_encode('No input given.');
    }

    $config['open_api_key'] = configValue("OpenAI", "apikey");

    $prompt = "Mache daraus einen griffigen Slogan für ein grünes Wahlplakat {$input}";

    $payload = '{
        "model": "text-davinci-003",
        "prompt": "' . $prompt . '",
        "temperature": 1,
        "max_tokens": 100,
        "top_p": 1,
        "frequency_penalty": 0,
        "presence_penalty": 0,
        "stop": ["You:"]
        }';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $config['open_api_key'],
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        return json_decode('Could not reach AI. It says: ' . curl_error($ch));
    }

    curl_close($ch);

    $result_json = json_decode($result);
    if (!empty($result_json->error)) {
        return json_encode($result_json->error->message);
    }

    return json_decode($result);
}
