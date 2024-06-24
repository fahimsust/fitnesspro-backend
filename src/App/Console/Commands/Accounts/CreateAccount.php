<?php

namespace App\Console\Commands\Accounts;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new account';

    private bool $active;

    private mixed $username;
    private mixed $password;
    private mixed $confirmPassword;
    private mixed $email;
    private mixed $firstName;
    private mixed $lastName;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $steps = [
            'username',
            'email',
            'password',
            'confirmPassword',
            'firstName',
            'lastName',
            'active',
        ];

        $bar = $this->output->createProgressBar(count($steps));
        $bar->start();

        foreach ($steps as $index => $step) {
            $this->{$step}();

            $bar->advance();
        }

        Account::create([
            'email' => $this->email,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'status_id' => $this->active
                ? AccountStatus::activeId()
                : AccountStatus::awaitingApprovalId(),
            'site_id' => 1,
        ]);

        $bar->finish();

        $this->newLine()
            ->info(__(
                'Account created for :email!',
                ['email' => $this->email]
            ));
    }

    private function username()
    {
        $this->username = $this->ask(__('Username'));
    }

    private function email()
    {
        $this->email = $this->ask(__('Email'));
    }

    private function password()
    {
        $this->password = $this->ask(__('Password'));
    }

    private function confirmPassword()
    {
        $this->confirmPassword = $this->ask(__('Confirm Password'));

        if ($this->password !== $this->confirmPassword) {
            $this->error(__('Password must match confirm password'));
        }
    }

    private function firstName()
    {
        $this->firstName = $this->ask(__('First Name'));
    }

    private function lastName()
    {
        $this->lastName = $this->ask(__('Last Name'));
    }

    private function active()
    {
        $this->active = $this->confirm(__('Activate on Creation?'));
    }
}
