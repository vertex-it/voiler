<?php

namespace VertexIT\Voiler\Http\Controllers;

use VertexIT\Voiler\Models\Activity;

class ActivityController extends BaseController
{
    public function show(Activity $activity)
    {
        if (isset($activity['properties']['old'])) {
            $changedValues = array_diff_assoc(
                array_map('serialize', $activity->properties['attributes']),
                array_map('serialize', $activity->properties['old']),
            );

            $oldValues = array_intersect_key($activity['properties']['old'], array_map('unserialize', $changedValues));
            $newValues = array_intersect_key($activity['properties']['attributes'], array_map('unserialize', $changedValues));

            $activity['properties'] = [
                'attributes' => $newValues,
                'old' => $oldValues,
            ];
        }

        return view('voiler::admin.activity.show', [
            'activity' => $activity['properties'],
        ]);
    }
}
