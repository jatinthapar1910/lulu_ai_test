<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class TicketClassifier
{
    protected array $categories = ['Billing','Bug','Feature Request','General'];

    public function classify(Ticket $ticket): array
    {
        if (!config('services.openai.enabled')) {
            $category = $this->categories[array_rand($this->categories)];
            return [$category, 0.0];
        }

        try {
            $prompt = "Classify the following ticket into one of these categories: " . implode(',', $this->categories) . "\nSubject: {$ticket->subject}\nBody: {$ticket->body}";
            $response = OpenAI::client()->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);
            $content = $response->choices[0]->message->content ?? '';
            foreach ($this->categories as $cat) {
                if (str_contains(strtolower($content), strtolower($cat))) {
                    return [$cat, 1.0];
                }
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }
        $category = $this->categories[array_rand($this->categories)];
        return [$category, 0.0];
    }
}
