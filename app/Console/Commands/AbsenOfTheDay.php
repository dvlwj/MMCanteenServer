<?php

namespace App\Console\Commands;

use App\User;
use App\Absen;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class AbsenOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absen:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Absen pagi dan siang perhari';

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
        $this->pagi();
        $this->siang();
    }

    private function pagi()
    {
        $status = "pagi";
        $time = date('Y-m-d');
        $makan = DB::select(DB::raw("SELECT c.id AS siswa_id, c.name AS siswa_name, 'makan' AS keterangan, '".$time."' AS _date, '".$status."' as status, d.id AS is_null FROM siswas AS c LEFT JOIN (SELECT a.id, a.name, b.keterangan, b.time FROM siswas AS a LEFT JOIN absens AS b ON a.id = b.siswa_id WHERE b.time = '".$time."' AND b.status = '".$status."') AS d ON d.id = c.id WHERE d.id is null AND c.".$status." = 'aktif';"));

        $user = User::select('id')->where('username','system')->first();
        $check = $makan != null ? $makan : 'kosong';

        if($check != 'kosong')
        {
            foreach($makan as $m)
            {
                $absen = new Absen([
                    'user_id' => $user->id,
                    'siswa_id' => $m->siswa_id,
                    'time' => $m->_date,
                    'status' => $m->status,
                    'keterangan' => 'makan'
                ]);

                $absen->save();
            }
        }

        $this->info('Absen of the Day has created for morning');
    }

    private function siang()
    {
        $status = "siang";
        $time = date('Y-m-d');
        $makan = DB::select(DB::raw("SELECT c.id AS siswa_id, c.name AS siswa_name, 'makan' AS keterangan, '".$time."' AS _date, '".$status."' as status, d.id AS is_null FROM siswas AS c LEFT JOIN (SELECT a.id, a.name, b.keterangan, b.time FROM siswas AS a LEFT JOIN absens AS b ON a.id = b.siswa_id WHERE b.time = '".$time."' AND b.status = '".$status."') AS d ON d.id = c.id WHERE d.id is null AND c.".$status." = 'aktif';"));

        $user = User::select('id')->where('username','system')->first();
        $check = $makan != null ? $makan : 'kosong';

        if($check != 'kosong')
        {
            foreach($makan as $m)
            {
                $absen = new Absen([
                    'user_id' => $user->id,
                    'siswa_id' => $m->siswa_id,
                    'time' => $m->_date,
                    'status' => $m->status,
                    'keterangan' => 'makan'
                ]);

                $absen->save();
            }
        }

        $this->info('Absen of the Day has created for afternoon');
    }
}
