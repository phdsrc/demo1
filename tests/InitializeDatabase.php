<?php

namespace Tests;

trait InitializeDatabase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public string $seeder = \Database\Seeders\DatabaseSeeder::class;

    // public function beforeRefreshingDatabase(): void

    // protected function initializeDatabase(): \PDO
}
