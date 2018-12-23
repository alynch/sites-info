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
        $this->createApplications();

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
                'name' => 'Quality assurance',
                'code'  => 'qa',
                'sort_order' => 3
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
            ['code' => 'LIN', 'name' => 'Linguistics' ],
            ['code' => 'FRE', 'name' => 'French' ],
            ['code' => 'POL', 'name' => 'Political Science' ],
        ];

        $science_depts = [
            ['code' => 'CHM', 'name' => 'Chemistry'],
            ['code' => 'CSB', 'name' => 'Cell and Systems Biology'],
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

    private function createApplications()
    {
        $academic_applications = [
            [
                'name' => 'Corpora in the Classroom',
                'environments' => [
                    'dev' => 'http://webdev.chass.utoronto.ca/corpora',
                    'prod' => 'https://corpora.chass.utoronto.ca'
                ],
                'units' => [ 'LIN' ]
            ],
            [
                'name' => 'Ontario Dialects',
                'environments' => [
                    'prod' => 'https://ontariodialects.chass.utoronto.ca'
                ],
                'units' => [ 'LIN' ]
            ],
            [
                'name' => 'Cross-Language Articulatory Database',
                'environments' => [
                    'prod' => 'http://clad.chass.utoronto.ca'
                ],
                'units' => [ 'LIN' ]
            ],
            [
                'name' => 'Romance Phonetic Database',
                'environments' => [
                    'prod' => 'http://rpd.chass.utoronto.ca'
                ],
                'units' => [ 'LIN' ]
            ],
            [
                'name' => 'French Placement Test',
                'environments' => [
                    'prod' => 'https://uttf.chass.utoronto.ca'
                ],
                'units' => [ 'FRE' ]
            ],
            [
                'name' => 'Directory of Languages and Linguistics at U of T',
                'environments' => [
                    'prod' => 'https://projects.chass.utoronto.ca/dll/'
                ],
                'units' => [ 'LIN' ]
            ]
        ];

        $admin_applications = [
            [
                'name' => 'Academic Search Requests',
                'environments' => [
                    'dev' => 'https://webdev.chass.utoronto.ca/academicsearches/',
                    'prod' => 'https://asr.chass.utoronto.ca/',
                ],
                'periods' => [
                    [ 'start_month' => 11, 'start_day'=> 1, 'end_month' => 12, 'end_day' => 31 ],
                    [ 'start_month' => 1, 'start_day'=> 1, 'end_month' => 3, 'end_day' => 30 ]
                ]
            ],
            [
                'name' => 'Course evaluations opt-out',
                'environments' => [
                    'prod' => 'https://apsc.chass.utoronto.ca/',
                ]
            ],
            [
                'name' => 'Drama apply',
                'environments' => [
                    'dev' => 'http://dev-drama-apply.chass.utoronto.ca/',
                    'prod' => 'https://drama-apply.chass.utoronto.ca/',
                ]
            ],
            [
                'name' => 'Graduate Admissions',
                'environments' => [
                    'prod' => 'https://admissions.chass.utoronto.ca/',
                ],
                'units' => [ 'ANT', 'HIS', 'POL' ],
                'periods' => [
                    [ 'start_month' => 11, 'start_day'=> 1, 'end_month' => 12, 'end_day' => 31 ],
                    [ 'start_month' => 1, 'start_day'=> 1, 'end_month' => 3, 'end_day' => 30 ]
                ]
            ],
            [
                'name' => 'Petitions',
                'environments' => [
                    'dev' => 'http://newpetitions-dev.iit.artsci.utoronto.ca/',
                    'pat' => 'https://petitions-pat.artsci.utoronto.ca/',
                    'prod' => 'https://petitions.artsci.utoronto.ca/',
                ]
            ],
            [
                'name' => 'College Admissions',
                'environments' => [
                    'prod' => 'https://college-admissions.artsci.utoronto.ca/'
                ],
                'periods' => [
                    [ 'start_month' => 11, 'start_day'=> 15, 'end_month' => 12, 'end_day' => 31 ],
                    [ 'start_month' => 1, 'start_day'=> 1, 'end_month' => 3, 'end_day' => 30 ]
                ]
            ],
            [
                'name' => 'TAships',
                'environments' => [
                    'dev' => 'https://dev.taships.iit.artsci.utoronto.ca/',
                    'pat' => 'https://pat.taships.iit.artsci.utoronto.ca/',
                    'prod' => 'https://taships.iit.artsci.utoronto.ca/'
                ],
                'units' => [ 'ANT', 'HIS', 'EEB', 'LIN', 'CHM', 'POL' ]
            ],
            [
                'name' => 'Timetable',
                'environments' => [
                    'dev' => 'https://dev.timetable-internal.iit.artsci.utoronto.ca/',
                    'prod' => 'https://timetable-internal.iit.artsci.utoronto.ca/'
                ]
            ],
            [
                'name' => 'TV Remote Control',
                'environments' => [
                    'prod' => 'https://tv.chass.utoronto.ca/'
                ]
            ],
            [
                'name' => 'University Arts Women\'s Club',
                'environments' => [
                    'prod' => 'https://groups.chass.utoronto.ca/uawc/'
                ]
            ],
            [
                'name' => 'WordPress Inventory',
                'environments' => [
                    'prod' => 'http://172.16.77/wp_inventory/'
                ]
            ]
        ];

        $environments = \App\Environments::all()->pluck('id', 'code');
        $units = \App\Unit::all()->pluck('id', 'code');

        $acad_group = \App\ApplicationGroups::where('name', 'Academic')->first();
        $admin_group = \App\ApplicationGroups::where('name', 'Administrative')->first();

        DB::table('applications')->delete();


        $academic_applications = collect($academic_applications)->map(function($item) use ($acad_group) {
            $item['group_id'] = $acad_group->id;
            return $item;
        });

        $admin_applications = collect($admin_applications)->map(function($item) use ($admin_group) {
            $item['group_id'] = $admin_group->id;
            return $item;
        });


        $applications = $academic_applications->merge($admin_applications);

        foreach ($applications as $application) {
            $app = \App\Applications::create($application);

            foreach ($application['environments'] as $key => $value) {
                $app->environments()->attach($environments[$key], ['url' => $value]);
            }

            if (isset($application['units'])) {
                foreach ($application['units'] as $key) {
                    $app->units()->attach($units[$key]);
                }
            }

            if (isset($application['periods'])) {
                foreach ($application['periods'] as $key) {
                    $app->timeline()->create($key);
                }
            }
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
