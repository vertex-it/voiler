<style>
    .uploaded-container {
        height: 120px;
    }
    
    .uploaded-container > img, .uploaded-container > a > img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
    
    .droppable-trash {
        padding: 0.4em 0.9em 0.9em;
    }
    
    .droppable-trash img {
        opacity: .2;
    }
</style>
<div class="form-group w-full @error($name) has-error has-danger @enderror">
    @include('voiler::components.inputs.includes.label')

    <div>
        <button
            class="btn btn-gray btn-has-icon {{ is_array(old($name, $value)) ? 'mb-1' : '' }}"
            id="uppy-modal-{{ $key }}"
            title="{{ __('voiler::components.add_more') }}"
             type="button"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('voiler::components.add_more') }}
        </button>
    </div>
    @include('voiler::components.inputs.includes.comment')

    <div class="uppy-{{ $key }}">
        <div id="drag-drop-area-{{ $key }}"></div>
    </div>

    <input name="{{ $name . ($single ? '' : '[]')}}" type="hidden" value="">

    <div class="flex flex-wrap justify-start items-center" id="uppy-uploaded-{{ $key }}">
        @foreach(old($name, is_array($value) ? $value : [$value]) ?? [] as $url)
            @if($url)
                <div class="uploaded-container cursor-move mt-2 mr-2">
                    @if(in_array(pathinfo($url, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                            <img class="rounded" src="{{ $url }}"  alt="{{ $url }}" title="{{ $url }}"/>
                        </a>
                    @else
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                            <img class="rounded" src="https://play-lh.googleusercontent.com/3tLaTWjP9kz56OwkbnbAnZoNp4HL28zcDMt5DEjt-kfuVhraWJBYC5XQRuMBf084JQ" alt="{{ $url }}" title="{{ $url }}">
                        </a>
                    @endif
                    <input name="{{ $name . ($single ? '' : '[]')}}" type="hidden" value="{{ $url }}">
                </div>
            @endif
        @endforeach
    </div>
    <div class="mb-2"></div>

    <div
        class="flex droppable-trash mt-4 border-dashed border-2 border-gray-300 hidden"
        id="uppy-removed-{{ $key }}"
        style="{{ is_array(old($name, $value)) ? '' : 'display: none;' }}"
    >
    </div>

    @include('voiler::components.inputs.includes.error')
</div>

@push('master-scripts')
    <script>
        {{--if ($('uppy-uploaded-{{ $key }}').children().length < 1) {--}}
        {{--    $('#uppy-removed-{{ $key }}').css({'display': 'none'})--}}
        {{--}--}}

        let uploaded{{ $key }} = document.getElementById("uppy-uploaded-{{ $key }}")
        let sortableUploaded{{ $key }} = Sortable.create(uploaded{{ $key }}, {
            animation: 150,
            group: '{{ $key }}',
            onAdd: function (event) {
                let item = event.item;
                $(item).find('input').attr('name', '{{ $name }}[]');
            }
        });

        let removed{{ $key }} = document.getElementById("uppy-removed-{{ $key }}");
        let sortableRemoved{{ $key }} = Sortable.create(removed{{ $key }}, {
            animation: 150,
            group: '{{ $key }}',
            onAdd: function (event) {
                let item = event.item;
                $(item).find('input').attr('name', '');
            }
        });

        // TODO: Hide/Show uppy button
    </script>
    <script>
        var single = {{ Js::from($single) }}

        toggleTrash()

        $(document).on('click', '#uppy-modal-{{ $key }}', function (e) {
            e.preventDefault();
        });

        const uppy{{ $key }} = new Uppy({
            restrictions: {
                maxFileSize: {{ 1024 * 1024 * $maxFileSize }}, // number	maximum file size in bytes for each individual file
                // minFileSize: 0,	        // number	minimum file size in bytes for each individual file
                // maxTotalFileSize: 0,	// number	maximum file size in bytes for all the files that can be selected for upload
                maxNumberOfFiles: {{ $single ? 1 : 'null' }},	// number	total number of files that can be selected
                // minNumberOfFiles: 0,	// number	minimum number of files that must be selected before the upload
                // allowedFileTypes: [],	// Array	wildcards image/*, or exact mime types image/jpeg, or file extensions .jpg: ['image/*', '.jpg', '.jpeg', '.png', '.gif']
            },
        }).use(Dashboard, {
            target: '#drag-drop-area-{{ $key }}',
            trigger: '#uppy-modal-{{ $key }}',
            showProgressDetails: true,
            proudlyDisplayPoweredByUppy: false,
            note: '{{ $getLabel() }}',
            closeModalOnClickOutside: true,
            disablePageScrollWhenModalOpen: true,
            showRemoveButtonAfterComplete: true,
        })
        .use(XHRUpload, {
            // TODO: Uppy will be used for all file types, not only images...
            endpoint: '{{ $route ?? route("voiler.files") }}',
            method: 'POST',
            formData: true,
            fieldName: 'file',
            bundle: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            getResponseError (responseText, response) {
                return new Error(response.statusText);
            }
        })
        .use(Compressor)

        var imageTypes = ['png', 'tif', 'tiff', 'wbmp', 'ico', 'jng', 'bmp', 'svg', 'webp', 'jpg', 'jpeg'];
        function isImage(url) {
            let extension = url.split('.').pop();

            return imageTypes.includes(extension);
        }

        function fileName(url) {
            let name = url.split('/').pop();
            let extension = url.split('.').pop();

            if (name.length > 25) {
                name = name.substring(0, 25) + '...' + extension;
            } else {
                name = name + '.' + extension;
            }

            return name;
        }

        uppy{{ $key }}.on('upload-success', (file, response) => {
            let uploadedContainer = $('#uppy-uploaded-{{ $key }}')
            toggleTrash()

            $('#uppy-modal-{{ $key }}').addClass('mb-1');
            
            let display
            if (isImage(response.body)) {
                display = '<img class="rounded" src="' + response.body + '" alt="" style="width: inherit;" />';
            } else {
                display = '<a href="' + response.body + '" target="_blank" title="' + file.name + '" rel="noopener noreferrer">' +
                    '<img class="rounded" src="https://play-lh.googleusercontent.com/3tLaTWjP9kz56OwkbnbAnZoNp4HL28zcDMt5DEjt-kfuVhraWJBYC5XQRuMBf084JQ" alt="' + file.name + '" style="width: inherit;" />' +
                '</a>';
            }
            
            if (single) {
                uploadedContainer.html('')
            }

            uploadedContainer.append(
                '<div class="uploaded-container cursor-move mt-2 mr-2">' +
                    display +
                    '<input name="{{ $name . ($single ? '' : '[]')}}" type="hidden" value="' + response.body + '">' +
                '</div>'
            );
        });

        function toggleTrash() {
            if ($('#uppy-uploaded-{{ $key }}').children().length > 0 && ! single) {
                $('#uppy-removed-{{ $key }}').removeClass('hidden')
            } else {
                $('#uppy-removed-{{ $key }}').addClass('hidden')
            }
        }
    </script>
@endpush
