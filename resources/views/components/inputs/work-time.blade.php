@include('voiler::components.inputs.includes.inlinable-top')
@include('voiler::components.inputs.includes.label')

<div id="{{ $name }}" class="mb-4">
    <x-inputs.work-time-day
        name="{{ $name }}[monday]"
        :value="$preparedValue['monday']"
        workDay="{{ __('voiler::components.monday') }}"
    >
        <button
            id="apply_to_all_{{ $name }}"
            class="btn btn-gray btn-has-icon mb-6"
            title="Primjenite na sve dane"
            type="button"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Primjenite na sve dane
        </button>
    </x-inputs.work-time-day>

    <x-inputs.work-time-day
        name="{{ $name }}[tuesday]"
        :value="$preparedValue['tuesday']"
        workDay="{{ __('voiler::components.tuesday') }}"
    />
    <x-inputs.work-time-day
        name="{{ $name }}[wednesday]"
        :value="$preparedValue['wednesday']"
        workDay="{{ __('voiler::components.wednesday') }}"
    />
    <x-inputs.work-time-day
        name="{{ $name }}[thursday]"
        :value="$preparedValue['thursday']"
        workDay="{{ __('voiler::components.thursday') }}"
    />
    <x-inputs.work-time-day
        name="{{ $name }}[friday]"
        :value="$preparedValue['friday']"
        workDay="{{ __('voiler::components.friday') }}"
    />
    <x-inputs.work-time-day
        name="{{ $name }}[saturday]"
        :value="$preparedValue['saturday']"
        workDay="{{ __('voiler::components.saturday') }}"
    />
    <x-inputs.work-time-day
        name="{{ $name }}[sunday]"
        :value="$preparedValue['sunday']"
        workDay="{{ __('voiler::components.sunday') }}"
    />
</div>

@include('voiler::components.inputs.includes.comment')
@include('voiler::components.inputs.includes.error')
@include('voiler::components.inputs.includes.inlinable-bottom')

@push('master-scripts')
    <script>
        $(document).on('click', '#apply_to_all_{{ $name }}', function() {
            let applyDay = $(this).parents('#row_work_time');

            let fromInputSelector = 'input[name$="[from][]"]';
            let toInputSelector = 'input[name$="[to][]"]';

            let dayData = {
                from: applyDay.find(fromInputSelector).map(function (id, input) {
                    return $(input).val();
                }).get(),
                to: applyDay.find(toInputSelector).map(function (id, input) {
                    return $(input).val();
                }).get(),
                count: applyDay.find(fromInputSelector).length
            }

            $(this).parents('#{{ $name }}')
                .children('#row_work_time')
                .each(function (i, day) {
                    $(day).find('.row.bc-multiple').each(function (i, row) {
                        if (i != 0) {
                            row.remove();
                        }
                    });

                    for (let index = 1; index < dayData.count; index++) {
                        $(day).find('.bc-btn-add').click();
                    }

                    $(day).find(fromInputSelector)
                        .each(function(i, input) {
                            $(input).val(dayData.from[i]);
                        });

                    $(day).find(toInputSelector)
                        .each(function(i, input) {
                            $(input).val(dayData.to[i]);
                        });
                });
        });
    </script>
@endpush
