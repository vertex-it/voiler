<?php

namespace VertexIT\Voiler\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use VertexIT\Voiler\ViewModels\Form\ProfileFormViewModel;

class ProfileController extends BaseController
{
    public function edit($model)
    {
        $model = $this->resource['model']::findByRouteKeyName($model)->first();

        $this->authorize('update', $model);

        return view(
            'voiler::admin.profile.form',
            new ProfileFormViewModel($model)
        );
    }

    public function update(Request $request, $model): RedirectResponse
    {
        $this->authorize('update', $this->resource['model']::findByRouteKeyName($model)->first());

        [$request, $model] = $this->bindModelAndValidateRequest($request, $model);

        $model->updateWithRelations($request);

        flashSuccessMessage('update', $model);

        return back();
    }
}