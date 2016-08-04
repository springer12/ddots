<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TesterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tester {--login=} {--password=} {--count=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate testing solutions via api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $client = new Client(['base_uri' => url('/')]);
        $auth = ['login' => $this->option('login'), 'password' => $this->option('password')];
        $api_token = json_decode((string)$client->request('POST', 'testing-system-api/auth', ['json' => $auth])->getBody())->api_token;
        $this->info('token: ' . $api_token);

        $count = 0;
        while($id = json_decode((string)$client->get('testing-system-api/solutions/latest-new', ['query' => ['api_token' => $api_token]])->getBody())->id && $count < $this->option('count')) {
            $this->info('latest new : ' . print_r($id, true));

            $solution = json_decode((string)$client->get('testing-system-api/solutions/' . $id, ['query' => ['api_token' => $api_token]])->getBody());
            $this->info('solution : ' . print_r($solution, true));

            $code = (string)$client->get('testing-system-api/solutions/' . $id . '/source-code', ['query' => ['api_token' => $api_token]])->getBody();
            $this->info('solution : ' . print_r($code, true));

            $this->info('fake testing...');

            $report = ['status' => 'UE', 'message' => 'what a nice solution', 'tests' => [], 'api_token' => $api_token];
            for ($i = 0; $i < 15; $i++) {
                $report['tests'][] = ['status' => rand(0,1)?'OK':'WA', 'execution_time' => rand(1, 2000), 'memory_peak' => rand(200, 20000)];
            }

            $this->info('reporting...');
            $client->post('testing-system-api/solutions/' . $id . '/report', ['json' => $report]);

            $this->info('updating solution...');

            $client->patch('testing-system-api/solutions/' . $id, ['json' => ['state' => 'tested', 'api_token' => $api_token]]);

            $count++;
        }
    }
}
