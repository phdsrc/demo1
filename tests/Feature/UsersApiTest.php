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
        ];

        expect(
               $this->post('/api/users', $input)
            )
            ->hasApiStatus(201)
            ->hasApiBody(<<<JSON
            {
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
        ];

        $user = expect(
            $this->post('/api/users', $input)
        )
            ->hasApiStatus(201)
            ->hasApiBody(<<<JSON
            {
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
