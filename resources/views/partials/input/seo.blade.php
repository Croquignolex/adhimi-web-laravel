@props(['model' => null])

<div class="divider divider-primary col-12">
    <div class="divider-text font-weight-bold">SEO</div>
</div>
<div class="row">
    @if($model)
        <div class="col-12 col-sm-6">
            @include('partials.input.text', [
                'label' => __('field.seo_title'),
                'field' => 'seo_title',
                'value' => $model->seo_title,
            ])
        </div>
        <div class="col-12 col-sm-6">
            @include('partials.input.text', [
                'label' => __('field.seo_description'),
                'field' => 'seo_description',
                'value' => $model->seo_description,
            ])
        </div>
    @else
        <div class="col-12 col-sm-6">
            @include('partials.input.text', [
                'label' => __('field.seo_title'),
                'field' => 'seo_title'
            ])
        </div>
        <div class="col-12 col-sm-6">
            @include('partials.input.text', [
                'label' => __('field.seo_description'),
                'field' => 'seo_description'
            ])
        </div>
    @endif
</div>