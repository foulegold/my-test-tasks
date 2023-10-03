<?php
class ChatNotificationManager {
    public function notify($message) {}
}

class ChatMessageRepository {
    public function save($message){}
}

class ChatMessage {
    private ?int $id;
    private int $chatId;
    private UserInterface $user;
    private string $text;

    public function __construct($chatId, $user, $text) {
        $this->chatId = $chatId;
        $this->user = $user;
        $this->text = $text;
    }
}

class Chat {
    public int $id;
    private ChatMessageRepository $chatMessageRepository;
    private ChatNotificationManager $chatNotificationManager;

    public function __construct($chatMessageRepository, $chatNotificationManager) {
        $this->chatMessageRepository = $chatMessageRepository;
        $this->chatNotificationManager = $chatNotificationManager;
    }

    public function addMessage($user, $text) {
        $message = new ChatMessage($this->id, $user, $text);
        $this->chatMessageRepository->save($message);
        $this->chatNotificationManager->notify($message);
    }
}





////////////////////////////////////



function getArabicNumberFromRoman(string $romanNumber): int
{
    $dictionary = [
        'I' => 1,
        'IV' => 4,
        'V' => 5,
        'IX' => 9,
        'X' => 10,
        'XL' => 40,
        'L' => 50,
        'XC' => 90,
        'C' => 100,
        'CD' => 400,
        'D' => 500,
        'CM' => 900,
        'M' => 1000,
    ];
    $result = 0;
    $romanNumber = strtoupper($romanNumber);
    for ($i = 0; $i < strlen($romanNumber); $i++) {
        $char = $romanNumber[$i];
        $charNext = $romanNumber[$i + 1];
        if ($charNext && isset($dictionary[$char . $charNext])) {
            $result += $dictionary[$char . $charNext];
            $i++;
        } elseif (isset($dictionary[$char])) {
            $result += $dictionary[$char];
        } else {
            throw new Exception("Wrong symbol '$char'", 500);
        }
    }
    return $result;
}

function getSecondFrequencySymbol(string $str): string
{
    $mostFrequentSymbol = '';
    $secondFrequentSymbol = '';
    $maxCount = 0;
    $secondCount = 0;
    $symbols = [];
    for ($i = 0; $i < strlen($str); $i++) {
        $currentSymbol = $str[$i];
        if (!isset($symbols[$currentSymbol])) $symbols[$currentSymbol] = 0;
        $symbols[$currentSymbol]++;
        if ($symbols[$currentSymbol] > $maxCount) {
            $secondCount = $maxCount;
            $secondFrequentSymbol = $mostFrequentSymbol;
            $maxCount = $symbols[$currentSymbol];
            $mostFrequentSymbol = $currentSymbol;
        } elseif ($symbols[$currentSymbol] > $secondCount) {
            $secondCount = $symbols[$currentSymbol];
            $secondFrequentSymbol = $currentSymbol;
        }
    }
    return $secondFrequentSymbol;
}

function getIP(string $ip) : string
{
    $ch = curl_init('https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Token token123',
        'X-Secret: secret123',
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['ip' => $ip]));
    $res = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($res, true);
    return "{$res['location']['value']}";
}