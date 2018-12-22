<?php

namespace App\Console\Commands;

use DB;
use Hash;
use Illuminate\Console\Command;

class InitializeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize application with default data';

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
        $this->createGroups();
        $this->createEnvironments();

        $this->createUnitAreas();
        $this->createUnitTypes();
        $this->createUnits();

        $this->createUsers();
    }

    private function createGroups()
    {
        $groups = [
            [
                'name' => 'Academic',
            ],
            [
                'name' => 'Administrative',
            ]
        ];

        DB::table('application_groups')->delete();
        foreach ($groups as $group) {
            $group['created_at'] = now();
            DB::table('application_groups')->insert($group);
        }
    }

    private function createEnvironments()
    {
        $environments = [
            [
                'name' => 'Development',
                'code'  => 'dev',
                'sort_order' => 1
            ],
            [
                'name' => 'Pre-acceptance testing',
                'code'  => 'pat',
                'sort_order' => 5
            ],
            [
                'name' => 'Production',
                'code'  => 'prod',
                'sort_order' => 10
            ]
        ];

        DB::table('environments')->delete();
        foreach ($environments as $environment) {
            $environment['created_at'] = now();
            DB::table('environments')->insert($environment);
        }
    }

    private function createUnitAreas()
    {
        $areas = [
            [
                'name' => 'Social Sciences',
                'sort_order' => 1,
            ],
            [
                'name' => 'Sciences',
                'sort_order' => 2,
            ],
            [
                'name' => 'Humanities',
                'sort_order' => 3,
            ]
        ];


        DB::table('unit_areas')->delete();
        foreach ($areas as $area) {
            $area['created_at'] = now();
            DB::table('unit_areas')->insert($area);
        }
    }

    private function createUnitTypes()
    {
        $types = [
            [
                'name' => 'Department',
                'code' => 'Department',
                'sort_order' => 1,
            ],
            [
                'name' => 'Extra-departmental Unit A',
                'code' => 'EDU:A',
                'sort_order' => 2,
            ],
            [
                'name' => 'Extra-departmental Unit B',
                'code' => 'EDU:B',
                'sort_order' => 3,
            ],
            [
                'name' => 'Extra-departmental Unit C',
                'code' => 'EDU:C',
                'sort_order' => 4,
            ],
            [
                'name' => 'Extra-departmental Unit D',
                'code' => 'EDU:D',
                'sort_order' => 5,
            ],
            [
                'name' => 'College',
                'code' => 'College',
                'sort_order' => 6,
            ]
        ];

        DB::table('unit_types')->delete();
        foreach ($types as $type) {
            $type['created_at'] = now();
            DB::table('unit_types')->insert($type);
        }
    }

    private function createUnits()
    {
        $dept = \App\UnitType::where('name', 'Department')->first();

        $soc = \App\UnitArea::where('name', 'Social Sciences')->first();
        $sci = \App\UnitArea::where('name', 'Sciences')->first();
        $hum = \App\UnitArea::where('name', 'Humanities')->first();

        $social_science_depts = [
            ['code' => 'ANT', 'name' => 'Anthropology' ],
            ['code' => 'HIS', 'name' => 'History' ],
            ['code' => 'POL', 'name' => 'Political Science' ],
        ];

        $science_depts = [
            ['code' => 'CHM', 'name' => 'Chemistry'],
            ['code' => 'CSB', 'name' => 'Cell and System Biology'],
            ['code' => 'EEB', 'name' => 'Ecology and Evolutionary Biology']
        ];


        DB::table('units')->delete();

        foreach ($social_science_depts as $unit) {
            $unit['short_name'] = $unit['name'];
            $unit['area_id'] = $soc->id;
            $unit['type_id'] = $dept->id;
            $unit['created_at'] = now();
            DB::table('units')->insert($unit);
        }

        foreach ($science_depts as $unit) {
            $unit['short_name'] = $unit['name'];
            $unit['area_id'] = $sci->id;
            $unit['type_id'] = $dept->id;
            $unit['created_at'] = now();
            DB::table('units')->insert($unit);
        }
    }

    private function createUsers()
    {
        $user =
            [
                'name' => 'Alejandro Lynch',
                'email' => 'alejandro.lynch@gmail.com',
                'password' => Hash::make('dashBoard')
            ];

        DB::table('users')->delete();
        DB::table('users')->insert($user);
    }
}
