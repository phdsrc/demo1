<?php
namespace App\Services;


use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class UserService
{
    /**
     * @param $method
     * @param $existing
     * @return Collection
     */
    public function getValidationRules($method='POST', $existing=null): Collection
    {
        if ($method === 'PATCH') {
            $required = 'sometimes|';
        } else {
            $required = 'required|';
        }

        return collect([
            'first_name' => $required .'string|max:255',
            'last_name' => $required .'string|max:255',
            'email' => $required .'email|unique:users,email',
            //'email' => 'email|unique:users,email,' . $user->id,
            'role' => $required .'string|in:ADMIN,MANAGER,USER',
            'status' => $required .'string|in:ACTIVE,INACTIVE,PENDING',
        ]);
    }

    /**
     * @param $attributes
     * @return User
     */
    public function create($data): User
    {
        $rules = $this->getValidationRules();
        $validator = Validator::make($data, $rules->toArray());
        $validated = $validator->validate();

        // @todo add Business Logic
        $validated['name'] = $validated['first_name'].' '.$validated['last_name'];
        $validated['password'] = '';

        return User::create($validated);
    }

    /**
     * @param User $user
     * @param $attributes
     * @return bool
     */
    public function update(User $user, $data, $method): bool
    {
        $rules = $this->getValidationRules($method);
        $validator = Validator::make($data, $rules->toArray());
        $validated = $validator->validate();

        // @todo add Business Logic

        return $user->update($validated);
    }
}
