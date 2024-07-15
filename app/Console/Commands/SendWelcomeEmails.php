<?php


namespace App\Console\Commands;

use App\Mail\WelcomeEmail;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendWelcomeEmails extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome emails to users who registered in the last 20 hours';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = 'luis2014gbp@gmail.com';
        $now = Carbon::now();
        $twentyHoursAgo = $now->subHours(20);

        // Buscar usuários que foram criados nas últimas 20 horas
        $users = User::where('created_at', '>=', $twentyHoursAgo)->get();

        foreach ($users as $user) {
            // Enviar e-mail fictício
            // Aqui você pode usar uma classe de mailable para enviar um e-mail real
            Mail::to($user->email)->send(new WelcomeEmail($user));

            // Exibir mensagem no console para monitoramento
            $this->info("E-mail de boas-vindas enviado para: {$email}");
        }

        return 0;
    }
}


