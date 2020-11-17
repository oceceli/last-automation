
<div {{ $attributes->merge(['class' => 'field']) }} wire:ignore>
    <label>{{ __($label) }}</label>
    <div class="ui calendar" id="{{ $dId }}">
        <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input type="datetime" placeholder="{{ __($placeholder) }}">
            {{-- wire:model="{{ $model }}" --}}
        </div>
    </div>
    @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
    @enderror
</div>



<script>
    $('#{{ $dId }}')
        .calendar({
            monthFirst: false,
            type: '{{ $type }}',
            today: true,
            touchReadonly: false,
            @if($initialDate)
                initialDate: new Date('{{ $initialDate }}'),
            @endif
            @if($disabledDays)
                disabledDaysOfWeek: [{{ $disabledDays }}],
            @endif
            // initialDate: null,
            startMode: 'day',
            // inline: true,
            ampm: false,
            // disabledDaysOfWeek: [5, 6],
            onSelect: function(date, mode) {
                console.log(new Date(date + 'z'));
                @this.set('{{ $model }}', new Date(date + 'z')); // 'z' timezone olayları ile ilgili
                // .toLocaleDateString("tr-TR")
            },
            formatter: {
                date: function (date, settings) {
                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return day + '.' + month + '.' + year;
                },
            },
            text: {
                days: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Pzr'],
                months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                monthsShort: ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Ekim', 'Kas', 'Ara'],
                today: 'Bugün',
                now: 'Şimdi',
                am: 'AM',
                pm: 'PM'
            },
        });
</script>