<?php

namespace Iyngaran\LaravelUser\Console;

use Iyngaran\LaravelUser\Actions\CreateUserAction;
use Iyngaran\LaravelUser\Actions\VerifyUserAction;
use Iyngaran\LaravelUser\DTOs\UserData;
use Iyngaran\LaravelUser\Exceptions\RoleNotFoundException;
use Iyngaran\LaravelUser\Repositories\RoleRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    protected $signature = 'create:administrator';

    protected $description = 'The command to create administrator';

    private $_role_repository = null;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        parent::__construct();
        $this->_role_repository = $roleRepository;
    }

    public function handle()
    {
        $userRole = null;
        $name = $this->ask('What is the name of the administrator ?');
        $email = $this->ask('What is the email address ?');
        try {
            $userRole = $this->_role_repository->findByName('administrator');
        } catch (RoleNotFoundException $ex) {
            return $this->error(
                "The user role does not exists.
                                        Please run the seeder to create roles", "\n\n"
            );
        }

        $userPassword = $this->_generatePassword();
        $inputData = [
            'name' => $name,
            'email' => $email,
            'password' => $userPassword,
            'role_ids' => [$userRole->id],
            'extra_permission_ids' => []
        ];

        if ($this->_isValidated($inputData)) {
            $request = new \Illuminate\Http\Request();
            $request->replace($inputData);
            $userData = UserData::fromRequest($request);
            $user = (new CreateUserAction())->execute($userData);
            (new VerifyUserAction())->execute($user);
            $user->update([
                'password_change_at' => now()
            ]);
            $this->info("\n");
            $this->info("The administrator account has been created successfully");
            $this->info("The password is : $userPassword");
            $this->info("\n");

        } else {
            $this->error("Please try again with valid data", "\n\n");
        }
    }

    private function _generatePassword($length = 12)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function _isValidated($inputData)
    {
        $validator = Validator::make(
            $inputData, [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                ], [
                    'name.required' => 'The name is required',
                    'email.required' => 'The email is required',
                    'email.unique' => 'The email address is already exists'
                ]
        );

        if ($validator->fails()) {
            if ($validator->errors()->getMessages()) {
                foreach ($validator->errors()->getMessages() As $messages) {
                    if (isset($messages)) {
                        foreach ($messages as $message) {
                            $this->error($message);
                        }
                    }
                }
            }
            return false;
        }
        return true;
    }
}
