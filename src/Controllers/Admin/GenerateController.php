<?php

namespace Azuriom\Plugin\Blog\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GenerateController extends Controller
{
    public function generate(Request $request)
    {
        $data = $this->validate($request, [
            'topic' => ['required', 'string', 'max:500'],
            'lang' => ['required', 'string', 'max:10'],
        ]);

        $apiKey = setting('blog.openai_key');

        if (! $apiKey) {
            return response()->json([
                'error' => trans('blog::admin.ai.no_key'),
            ], 422);
        }

        $model = setting('blog.openai_model', 'gpt-4o-mini');
        $lang = $data['lang'];
        $topic = $data['topic'];

        $prompt = "Write a blog article in {$lang} about: {$topic}. "
            ."Return a JSON object with these exact keys: "
            ."\"title\" (catchy title), "
            ."\"slug\" (url-friendly slug), "
            ."\"description\" (short summary, max 200 chars), "
            ."\"content\" (full HTML article with h2, h3, p tags, well structured). "
            ."Only return valid JSON, no markdown fencing.";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional blog writer. Always respond with valid JSON only.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => trans('blog::admin.ai.api_error'),
            ], 500);
        }

        $raw = $response->json('choices.0.message.content', '');
        $raw = preg_replace('/^```json\s*|```\s*$/m', '', trim($raw));

        $result = json_decode($raw, true);

        if (! $result || ! isset($result['title'], $result['content'])) {
            return response()->json([
                'error' => trans('blog::admin.ai.parse_error'),
            ], 500);
        }

        return response()->json($result);
    }
}
