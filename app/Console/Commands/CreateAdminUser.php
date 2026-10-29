<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {--name= : Display name of the admin}
                            {--email= : Login email of the admin}
                            {--password= : Password (omit to be prompted securely)}';

    protected $description = 'Create an admin account, or promote an existing user to admin';

    public function handle(): int
    {
        $email = $this->option('email') ?: text('Admin email', required: true);

        $emailCheck = Validator::make(['email' => $email], ['email' => ['required', 'email', 'max:255']]);

        if ($emailCheck->fails()) {
            $this->error($emailCheck->errors()->first('email'));

            return self::FAILURE;
        }

        $existing = User::where('email', $email)->first();

        if ($existing) {
            if ($existing->is_admin) {
                $this->info("{$email} is already an admin. Nothing changed.");

                return self::SUCCESS;
            }

            if (! $this->confirm("A user with {$email} already exists. Promote them to admin?")) {
                return self::FAILURE;
            }

            $existing->forceFill(['is_admin' => true])->save();
            $this->info("{$email} is now an admin.");

            return self::SUCCESS;
        }

        $name = $this->option('name') ?: text('Admin name', default: 'Administrator', required: true);
        $plain = $this->option('password') ?: password('Password (min 8 characters)', required: true);

        $validator = Validator::make(
            ['name' => $name, 'password' => $plain],
            ['name' => ['required', 'string', 'max:255'], 'password' => ['required', 'string', 'min:8']]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        // The model's "hashed" cast hashes the password.
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $plain,
            'is_admin' => true,
        ]);

        $this->info("Admin account created for {$email}.");

        return self::SUCCESS;
    }
}
