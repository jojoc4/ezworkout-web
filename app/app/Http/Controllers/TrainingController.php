<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingPlan;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $a = TrainingPlan::where('user_id', $request->user()->id)->with('trainings')->get();
        $final  = [];
        $ids = [];

        foreach ($a as $tp) {
            foreach($tp['trainings'] as $current)
            if (!in_array($current->id, $ids)) {
                $final[] = $current;
                $ids[] = $current->id;
            }
        }


        return response()->json($final);
    }

    /**
     * Return trainings that are part of a training plan
     * 
     * @param int $id
     * @return Response
     */
    public function getFromTrainingPlan(int $id)
    {
        return response()->json(TrainingPlan::find($id)->trainings()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string',
            'trainingPlan' => 'integer|min:0'
        ]);
        $t = new Training();
        $t->name = $data['name'];
        if ($data['trainingPlan'] == 0) {
            $t->save();
        } else {
            $p = TrainingPlan::find($data['trainingPlan']);
            $p->trainings()->save($t);
        }
        return response()->json($t);
    }

    /**
     * attach a training to a trainingPlan
     */
    public function attach(Request $request, int $id)
    {
        $data = $request->validate([
            'trainingPlan' => 'integer|min:1'
        ]);
        $p = TrainingPlan::find($data['trainingPlan']);
        $p->trainings()->attach($id);
    }

    /**
     * detach a training from a trainingPlan
     */
    public function detach(Request $request, int $id)
    {
        $data = $request->validate([
            'trainingPlan' => 'integer|min:1'
        ]);
        $p = TrainingPlan::find($data['trainingPlan']);
        $p->trainings()->detach($id);
    }

    /**
     * detach a training from all trainingPlans
     */
    public function detachAll(int $id)
    {
        $t = Training::find($id);
        $t->training_plans()->detach();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->json(Training::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'string'
        ]);
        $t = Training::find($id);
        $t->name = $data['name'];
        $t->save();
        return response()->json($t);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Training::destroy($id);
        return response()->json(['delete' => 'ok']);
    }
}
