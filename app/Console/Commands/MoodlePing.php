<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MoodlePing extends Command
{
    protected $signature = 'moodle:ping';
    protected $description = 'Ping Moodle REST API using core_webservice_get_site_info';

    public function handle(): int
    {
        $base = rtrim(config('services.moodle.base_url'), '/');
        $token = config('services.moodle.token');

        $res = Http::asForm()->post("{$base}/webservice/rest/server.php", [
            'wstoken' => $token,
            'wsfunction' => 'core_webservice_get_site_info',
            'moodlewsrestformat' => 'json',
        ]);

        $this->info('HTTP: ' . $res->status());
        $this->line($res->body());

        return $res->ok() ? self::SUCCESS : self::FAILURE;
    }
}
