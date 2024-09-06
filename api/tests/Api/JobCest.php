<?php

namespace App\Tests\Api;

use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class JobCest
{
    public const JOBS_JSON_TYPE = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'createdAt' => 'string',
    ];

    public const JOB_JSON_TYPE = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'createdAt' => 'string',
        'offers' => [[
            'id' => 'integer',
            'jobber' => [
                'id' => 'integer',
                'name' => 'string',
            ],
            'amount' => 'int|float',
            'status' => 'string',
        ]],
    ];

    public function tryToGetJobs(ApiTester $I): void
    {
        $I->sendGet('/jobs');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesJsonType(self::JOBS_JSON_TYPE);
    }

    public function tryToGetJob(ApiTester $I): void
    {
        $I->sendGet('/jobs/1');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesJsonType(self::JOB_JSON_TYPE);
    }

    public function tryToCreateJob(ApiTester $I): void
    {
        $I->sendPost('/jobs', [
            'title' => 'Job test',
            'description' => 'This is a test',
        ]);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseMatchesJsonType(self::JOBS_JSON_TYPE);
    }
}
