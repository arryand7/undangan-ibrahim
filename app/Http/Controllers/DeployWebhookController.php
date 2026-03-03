<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeployWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $event = (string) $request->header('X-GitHub-Event', '');
        $payload = $request->getContent();
        $secret = (string) config('services.github.webhook_secret', '');

        if ($secret === '') {
            Log::error('GitHub deploy webhook is not configured: missing GITHUB_WEBHOOK_SECRET.');

            return response()->json(['message' => 'Webhook not configured.'], 500);
        }

        $signature = (string) $request->header('X-Hub-Signature-256', '');
        if (!$this->isValidSignature($signature, $payload, $secret)) {
            Log::warning('Invalid GitHub webhook signature.', [
                'event' => $event,
                'ip' => $request->ip(),
            ]);

            return response()->json(['message' => 'Invalid signature.'], 401);
        }

        if ($event === 'ping') {
            return response()->json(['message' => 'pong']);
        }

        if ($event !== 'push') {
            return response()->json(['message' => 'Event ignored.'], 202);
        }

        $expectedRepo = (string) config('services.github.repository');
        $payloadRepo = (string) data_get($request->json()->all(), 'repository.full_name', '');
        if ($expectedRepo !== '' && $payloadRepo !== $expectedRepo) {
            return response()->json(['message' => 'Repository ignored.'], 202);
        }

        $expectedBranch = (string) config('services.github.deploy_branch', 'main');
        $payloadRef = (string) data_get($request->json()->all(), 'ref', '');
        if ($payloadRef !== "refs/heads/{$expectedBranch}") {
            return response()->json(['message' => 'Branch ignored.'], 202);
        }

        $deployScript = (string) config('services.github.deploy_script');
        if ($deployScript === '' || !is_file($deployScript) || !is_executable($deployScript)) {
            Log::error('Deploy script is not executable or missing.', ['script' => $deployScript]);

            return response()->json(['message' => 'Deploy script unavailable.'], 500);
        }

        $cmd = sprintf(
            '/usr/bin/sudo -n %s %s > /dev/null 2>&1 &',
            escapeshellarg($deployScript),
            escapeshellarg($expectedBranch)
        );

        exec($cmd, $out, $status);
        if ($status !== 0) {
            Log::error('Failed to trigger deploy command from webhook.', ['status' => $status]);

            return response()->json(['message' => 'Failed to trigger deploy.'], 500);
        }

        return response()->json(['message' => 'Deploy triggered.'], 202);
    }

    private function isValidSignature(string $signatureHeader, string $payload, string $secret): bool
    {
        if (!str_starts_with($signatureHeader, 'sha256=')) {
            return false;
        }

        $signature = substr($signatureHeader, 7);
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }
}
