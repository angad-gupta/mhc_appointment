<?php


namespace App\Traits;


use App\Models\Assistant;
use Illuminate\Http\Request;

trait AssistantFilter
{
    /**
     * Filter assistant
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filteredAssistant(Request $request)
    {
        $assistant = Assistant::query();

        if($request->query('query') != null){
            $assistant->where('full_name','like','%'.$request->query('query').'%');
        }

        if($request->query('order') != null){
            $orderType = $request->query('order') == 'asc' ? 'asc' : 'desc';
            $assistant->orderBy('id',$orderType);
        }

        return $assistant;
    }
}