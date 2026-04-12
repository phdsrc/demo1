<?php


describe('api: users.list', function () {
    it('returns results', function () {
        $response = $this->get('/api/users');

        $response->assertStatus(200);

        $data = collect($response->json('data'));
        expect($data->count())->toBe(100);
    });
});


describe('api: users.show', function () {
    it('returns user object', function () {

        expect(
            $this->get('/api/users/1')
        )
            ->hasApiStatus(200)
            ->hasApiKey('id')
            ->hasApiKey('name')
            ->hasApiKey('email');
    });
});

describe('api: users.store', function () {
    it('creates user object', function () {

        $input = [
            'name' => 'Winston Buckridge',
            'first_name' => 'Winston',
            'last_name' => 'Buckridge',
            'role' => 'MANAGER',
            'status' => 'ACTIVE',
            'email' => 'morissette.jules@example.net',
        ];

        expect(
               $this->post('/api/users', $input)
            )
            ->hasApiStatus(201)
            ->hasApiBody(<<<JSON
            {
                "first_name": "Winston",
                "last_name": "Buckridge",
                "email": "morissette.jules@example.net",
                "role": "MANAGER",
                "status": "ACTIVE",
                "name": "Winston Buckridge",
                "updated_at": "2026-04-12T22:16:55.000000Z",
                "created_at": "2026-04-12T22:16:55.000000Z",
                "id": 101
            }
            JSON,
            ignore: [
                'updated_at',
                'created_at',
                'id',
            ]);

    });
});

describe('api: users.update', function () {
    it('updates user object', function () {

        $input = [
            'name' => 'Winston Buckridge',
            'first_name' => 'Winston',
            'last_name' => 'Buckridge',
            'role' => 'MANAGER',
            'status' => 'ACTIVE',
            'email' => 'morissette.jules@example.net',
        ];

        $user = expect(
            $this->post('/api/users', $input)
        )
            ->hasApiStatus(201)
            ->hasApiBody(<<<JSON
            {
                "first_name": "Winston",
                "last_name": "Buckridge",
                "email": "morissette.jules@example.net",
                "role": "MANAGER",
                "status": "ACTIVE",
                "name": "Winston Buckridge",
                "updated_at": "2026-04-12T22:16:55.000000Z",
                "created_at": "2026-04-12T22:16:55.000000Z",
                "id": 101
            }
            JSON,
                ignore: [
                    'updated_at',
                    'created_at',
                    'id',
                ])
            ->value->json();


        expect(
            $this->patch('/api/users/' . data_get($user, 'id'), ['role' => 'ADMIN'])
        )
            ->hasApiStatus(204)

            ->and(
                $this->get('/api/users/' . data_get($user, 'id'))
            )
            ->hasApiStatus(200)
            ->hasApiValue('role', 'ADMIN');


        // tdump($this->post('/api/users', $input)->json());
    });
});


describe('api: users.destroy', function () {
    it('deletes user object', function () {

        expect(
            $this->get('/api/users/1')
        )
            ->hasApiStatus(200)
            ->hasApiKey('id')
            ->hasApiKey('name')
            ->hasApiKey('email')

            ->and(
                $this->delete('/api/users/1')
            )
            ->hasApiStatus(204)

            ->and(
                $this->get('/api/users/1')
            )
            ->hasApiStatus(404);

    });
});
