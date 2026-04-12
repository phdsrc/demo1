<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(\Tests\InitializeDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('hasApiStatus', function ($code) {

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->value;
    $response->assertStatus($code);
    return $this;
});

expect()->extend('hasApiBody', function (string $expected, $ignore) {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->value;

    $generated = collect($response->json())
        ->sortKeysRecursive()
        ->toArray();

    $fixed = collect(json_decode($expected, true))
        ->sortKeysRecursive()
        ->toArray();

    if ($ignore) {
        foreach ($ignore as $path => $fields) {
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    data_forget($generated, $path . '.' . $field);
                    data_forget($fixed, $path . '.' . $field);
                }
            } else {
                data_forget($generated, $fields);
                data_forget($fixed, $fields);

            }
        }
    }
    expect(count($generated))->toBeGreaterThan(0)
        ->and($generated)->toBe($fixed);

    return $this;
});

expect()->extend('hasApiKey', function (string $key) {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->value;

    $resolved = data_get($response->json(), $key, '__NULL__');
    if ($resolved === '__NULL__') {
        \PHPUnit\Framework\Assert::assertTrue(false, '"'. $key.'" does not exist in '. json_encode($response->json()));
    } else {
        \PHPUnit\Framework\Assert::assertTrue(true);
    }

    return $this;
});

expect()->extend('hasApiValue', function (string $key, string $expected) {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->value;

    expect(data_get($response->json(), $key))->toBe($expected);

    return $this;
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/


\Illuminate\Support\Collection::macro('sortKeysRecursive', function () {
    $items = $this->all();

    $sortRecursive = function (&$array) use (&$sortRecursive) {
        ksort($array);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $sortRecursive($value);
            }
        }
    };

    $sortRecursive($items);

    return new \Illuminate\Support\Collection($items);
});


function tdump(mixed $data)
{
    if (is_array($data) || is_object($data)) {
        print_r(json_encode($data, JSON_PRETTY_PRINT));
    } else {
        print_r($data);
    }
    print "\n";
    expect(1)->toBe(0);
}
