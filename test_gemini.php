<?php

use Illuminate\Support\Facades\Http;

$apiKey = 'AIzaSyA7wCSCSKPecLhBdApJkSkWuweTYo0NLSs';
$userMessage = 'Apa itu terumbu karang?';

$systemPrompt = "Anda adalah AI Assistant yang ahli tentang biota laut, terumbu karang, dan ekosistem laut. Jawab pertanyaan dalam Bahasa Indonesia dengan informasi yang akurat dan mudah dipahami.";

$fullMessage = $systemPrompt . "\n\nPertanyaan pengguna: " . $userMessage;

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey;

echo "URL: " . $url . "\n\n";

$payload = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $fullMessage
                ]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'topK' => 40,
        'topP' => 0.95,
        'maxOutputTokens' => 1024,
    ],
];

echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . "\n\n";

$response = Http::timeout(30)->post($url, $payload);

echo "Status: " . $response->status() . "\n";
echo "Response: " . $response->body() . "\n";
echo "Success: " . ($response->successful() ? 'Yes' : 'No') . "\n";

if ($response->successful()) {
    $data = $response->json();
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        echo "\nAI Response: " . $data['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "\nUnexpected response format.\n";
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
