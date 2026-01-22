<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MoodleClient
{
    public function call(string $function, array $params = []): array
    {
        $base = rtrim(config('services.moodle.base_url'), '/');
        $token = config('services.moodle.token');

        $res = Http::asForm()->post("{$base}/webservice/rest/server.php", array_merge([
            'wstoken' => $token,
            'wsfunction' => $function,
            'moodlewsrestformat' => 'json'
        ], $params));

        $data = $res->json();

        if (!$res->ok()) {
            throw new \RuntimeException("Moodle HTTP {$res->status()}: {$res->body()}");
        }

        if (is_array($data) && isset($data['exception'])) {
            throw new \RuntimeException("Moodle exception {$data['errorcode']}: {$data['message']}");
        }

        return $data ?? [];
    }

    public function createCourse(string $fullname, string $shortname, string $summary): int
    {
        $categoryId = (int) config('services.moodle.category_id');

        $result = $this->call('core_course_create_courses', [
            'courses' => [
                [
                    'fullname' => $fullname,
                    'shortname' => $shortname,
                    'categoryid' => $categoryId,
                    'summary' => $summary
                ]
            ]
        ]);

        $id = $result[0]['id'] ?? null;

        if (!$id) {
            throw new \RuntimeException('No course id returned by Moodle.');
        }

        return (int) $id;
    }

    public function getCourseById(int $id): ?array
    {
        $result = $this->call('core_course_get_courses_by_field', [
            'field' => 'id',
            'value' => $id,
        ]);

        return $result['courses'][0] ?? null;
    }

    public function getCourseByShortname(string $shortname): ?array
    {
        $result = $this->call('core_course_get_courses_by_field', [
            'field' => 'shortname',
            'value' => $shortname,
        ]);

        return $result['courses'][0] ?? null;
    }
}
