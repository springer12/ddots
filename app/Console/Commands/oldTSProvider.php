<?php

namespace App\Console\Commands;

use App\Problem;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class oldTSProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start_testing_problems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daemon for old testing system';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $login    = $this->ask('login: ');
        $password = $this->secret('password: ');



        $client = new Client(['base_uri' => url('/')]);
        $auth = ['login' => $login, 'password' => $password];
        $api_token = json_decode((string)$client->request('POST', 'testing-system-api/auth', ['json' => $auth])->getBody())->api_token;
        $this->info('token: ' . $api_token);

        $solutions_to_proccess = [];

        while (true) {

            while (true) {
                try {
                    $id = json_decode((string)$client->get('testing-system-api/solutions/latest-new', ['query' => ['api_token' => $api_token]])
                        ->getBody())->id;
                } catch (\Exception $e) {
                    break;
                    $this->error('error latest-new');
                }
                if($id) {
                    $solutions_to_proccess[$id] = $id;
                }

            }
            if(!empty($solutions_to_proccess)) {
                foreach ($solutions_to_proccess as $id => $solutions_to_procces) {
                    if(is_file(base_path('var/results/' . (int)substr($this->solutionIdToString($id), 0, 3) . '/' . $this->solutionIdToString($id)))) {

                        $report = file_get_contents(base_path('var/results/' . (int)substr($this->solutionIdToString($id), 0, 3) . '/' . $this->solutionIdToString($id)));
                        $client->post('testing-system-api/solutions/' . $id . '/report', ['json' => $report]);
                        $client->patch('testing-system-api/solutions/' . $id, ['json' => ['state' => 'tested', 'api_token' => $api_token]]);
                        unset($solutions_to_procces[$id]);
                    } else {
                        $this->info("no solution : \t" . base_path('var/results/' . (int)substr($this->solutionIdToString($id), 0, 3) . '/' . $this->solutionIdToString($id)));
                    }
                }
                unset($solutions_to_procces);
            }
        }
    }

    private function solutionIdToString($id) {
        switch ($id) {
            case $id < 10:
                return '00000' . $id;
            case $id < 100:
                return '0000' . $id;
            case $id < 1000:
                return '000' . $id;
            case $id < 10000:
                return '00' . $id;
            case $id < 100000:
                return '0' . $id;
            default:
                return $id;
        }
    }
}
