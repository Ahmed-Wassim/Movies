<?php

namespace App\Http\Controllers\Admin;

use App\Models\Actor;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActorController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $actors = Actor::select('name', 'image')->filter(request(['search']))->withCount('movies')->get();
        return $this->successResponse($actors);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return $this->successResponse($actor);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->actor_ids;
        Actor::whereIn('id', $ids)->delete();
        return $this->successResponse("Actors Deleted successfully");
    }
}
