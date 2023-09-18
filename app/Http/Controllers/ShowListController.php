<?php

namespace App\Http\Controllers;

use App\Helpers\Paginate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ShowListController extends Controller
{

    public function index()
    {
        $characters = $this->loadJSON('evo-task-data-new.json');  // Call common function to load selected JSON file
        $characters = Paginate::paginate($characters, 25);

        return Response::json($characters);
    }

    public function indexPages($page)
    {
        $characters = $this->loadJSON('evo-task-data-new.json');  // Call common function to load selected JSON file
        $characters = Paginate::paginate($characters, 25, $page);

        return Response::json($characters);
    }

    public function characterDetail($actorId)
    {
        $characters = $this->loadJSON('evo-task-data-new.json');

        foreach ($characters as $key => $value) {
            if ($value['id'] == $actorId) {
                return Response::json($value);
            }
        }
        return [];
    }


    public function dashBoard(Request $request)
    {
        $characters = collect($this->loadJSON('evo-task-data-new.json'));

        return Response::json([
            'bestThree' => $this->getHighestAppearance($characters),
            'statusMost' => $this->groupByStatus($characters),
            'location' => $this->locationWithHumans($characters),
            'mostMale' => $this->mostMale($characters),
            'originDisplay' => $this->originList($characters),
        ]);
    }


    function getHighestAppearance($characters)
    {
        $dataDB = $characters->sortBy(function ($data) {
            return count($data['episode']);
        })->values();
        $sumc = $dataDB->sortByDesc('episode');

        $firstThree = [];
        $cnt = 1;
        foreach ($sumc as $key => $value) {
            if ($cnt > 3) break;
            array_push(
                $firstThree,
                [
                    "id" => $value['id'],
                    "name" => $value['name'],
                    "status" => $value['status'],
                    "species" => $value['species'],
                    "type" => $value['type'],
                    "gender" => $value['gender'],
                    "origin" => $value['origin'],
                    "location" => $value['location'],
                    "image" => $value['image'],
                    "episode" => count($value['episode']),
                    "url" => $value['url'],
                    "created" => $value['created'],
                ]
            );
            $cnt++;
        }

        return $firstThree;
    }

    function groupByStatus($characters)
    {
        $dataDB = collect($characters)
            ->groupBy('status')
            ->map(function (Collection $collection, $day) {
                return [
                    'status' => $day,
                    'numbers' => count($collection->sortBy('status')->toArray()),
                ];
            })
            ->values();

        return $dataDB->sortByDesc('numbers')->first()['status'];
    }

    function locationWithHumans($characters)
    {
        $dataDB = $characters->filter(function ($data) {
            return str($data['species'])->contains("Human");
        })
            ->groupBy('location.name')
            ->map(
                function (Collection $collection, $name) {
                    return
                        [
                            'count' => count($collection->toArray()),
                        ];
                }
            );

        foreach ($dataDB->sortBy('count')->reverse() as $key => $value) {
            return [
                'name' => $key,
                'counts' => $value['count'],
            ];
        }

        return [];
    }

    function mostMale($characters)
    {
        $dataDB = $characters->filter(function ($data) {
            return str($data['gender'])->contains("Male");
        })
            ->groupBy('species')
            ->map(
                function (Collection $collection) {
                    return
                        [
                            'count' => count($collection->toArray()),
                        ];
                }
            );

        foreach ($dataDB->sortBy('count')->reverse() as $key => $value) {
            return [
                'name' => $key,
                'counts' => $value['count'],
            ];
        }

        return [];
    }

    function originList($characters)
    {
        $dataDB = $characters->sortBy('origin.name')->groupBy('origin.name');

        $result = [];
        $dataMine = [];
        $totalUniqueOrigin = count($dataDB);

        foreach ($dataDB as $key => $value) {
            array_push($dataMine, [
                'name' => $key,
                'species' => $value->groupBy('species')
                    ->map(
                        function (Collection $collection) {
                            return count($collection->toArray());
                        }
                    ),
            ]);
        }

        foreach ($dataMine as $key => $value) {
            array_push($result, [
                'name' => $value['name'],
                'speciesCount' => count($value['species']),
                'species' => $this->getSpecies($value['species']),
            ]);
        }
        return $result;
    }

    function getSpecies($vals)
    {
        $valRet = [];
        foreach ($vals as $key => $value) {
            array_push($valRet, [
                'name' => $key,
                'count' => $value
            ]);
        }

        return $valRet;
    }
}
