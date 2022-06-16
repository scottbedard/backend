<form
    action="{{ route('backend.resources.action', ['id' => $resource::$id]) }}"
    method="POST">
    @csrf
    
    <input type="hidden" name="_action" value="{{ $action }}" />

    <input type="hidden" name="_modelId" value="{{ $model->{$resource::$modelKey} }}" />

    <div class="gap-6 grid grid-cols-12">
        @foreach ($fields as $field)
            @if (!$field->context || $field->context === $context)
                <div @class([
                    'col-span-12' => true,
                    
                    'sm:col-span-1' => $field->span['sm'] === 1,
                    'sm:col-span-2' => $field->span['sm'] === 2,
                    'sm:col-span-3' => $field->span['sm'] === 3,
                    'sm:col-span-4' => $field->span['sm'] === 4,
                    'sm:col-span-5' => $field->span['sm'] === 5,
                    'sm:col-span-6' => $field->span['sm'] === 6,
                    'sm:col-span-7' => $field->span['sm'] === 7,
                    'sm:col-span-8' => $field->span['sm'] === 8,
                    'sm:col-span-9' => $field->span['sm'] === 9,
                    'sm:col-span-10' => $field->span['sm'] === 10,
                    'sm:col-span-11' => $field->span['sm'] === 11,
                    'sm:col-span-12' => $field->span['sm'] === 12,

                    'md:col-span-1' => $field->span['md'] === 1,
                    'md:col-span-2' => $field->span['md'] === 2,
                    'md:col-span-3' => $field->span['md'] === 3,
                    'md:col-span-4' => $field->span['md'] === 4,
                    'md:col-span-5' => $field->span['md'] === 5,
                    'md:col-span-6' => $field->span['md'] === 6,
                    'md:col-span-7' => $field->span['md'] === 7,
                    'md:col-span-8' => $field->span['md'] === 8,
                    'md:col-span-9' => $field->span['md'] === 9,
                    'md:col-span-10' => $field->span['md'] === 10,
                    'md:col-span-11' => $field->span['md'] === 11,
                    'md:col-span-12' => $field->span['md'] === 12,

                    'lg:col-span-1' => $field->span['lg'] === 1,
                    'lg:col-span-2' => $field->span['lg'] === 2,
                    'lg:col-span-3' => $field->span['lg'] === 3,
                    'lg:col-span-4' => $field->span['lg'] === 4,
                    'lg:col-span-5' => $field->span['lg'] === 5,
                    'lg:col-span-6' => $field->span['lg'] === 6,
                    'lg:col-span-7' => $field->span['lg'] === 7,
                    'lg:col-span-8' => $field->span['lg'] === 8,
                    'lg:col-span-9' => $field->span['lg'] === 9,
                    'lg:col-span-10' => $field->span['lg'] === 10,
                    'lg:col-span-11' => $field->span['lg'] === 11,
                    'lg:col-span-12' => $field->span['lg'] === 12,

                    'xl:col-span-1' => $field->span['xl'] === 1,
                    'xl:col-span-2' => $field->span['xl'] === 2,
                    'xl:col-span-3' => $field->span['xl'] === 3,
                    'xl:col-span-4' => $field->span['xl'] === 4,
                    'xl:col-span-5' => $field->span['xl'] === 5,
                    'xl:col-span-6' => $field->span['xl'] === 6,
                    'xl:col-span-7' => $field->span['xl'] === 7,
                    'xl:col-span-8' => $field->span['xl'] === 8,
                    'xl:col-span-9' => $field->span['xl'] === 9,
                    'xl:col-span-10' => $field->span['xl'] === 10,
                    'xl:col-span-11' => $field->span['xl'] === 11,
                    'xl:col-span-12' => $field->span['xl'] === 12,

                    '2xl:col-span-1' => $field->span['2xl'] === 1,
                    '2xl:col-span-2' => $field->span['2xl'] === 2,
                    '2xl:col-span-3' => $field->span['2xl'] === 3,
                    '2xl:col-span-4' => $field->span['2xl'] === 4,
                    '2xl:col-span-5' => $field->span['2xl'] === 5,
                    '2xl:col-span-6' => $field->span['2xl'] === 6,
                    '2xl:col-span-7' => $field->span['2xl'] === 7,
                    '2xl:col-span-8' => $field->span['2xl'] === 8,
                    '2xl:col-span-9' => $field->span['2xl'] === 9,
                    '2xl:col-span-10' => $field->span['2xl'] === 10,
                    '2xl:col-span-11' => $field->span['2xl'] === 11,
                    '2xl:col-span-12' => $field->span['2xl'] === 12,
                ])>
                    <x-backend::renderable
                        :content="$field->render()"
                        :data="$model" />
                </div>
            @endif
        @endforeach
    </div>
</form>
