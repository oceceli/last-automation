
<div {{ $attributes }}>
    <label>{{ __($label) }}</label>
    <div class="ui calendar" id="calendar">
        <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input type="text"  wire:model="{{ $model }}" placeholder="{{ __($placeholder) }}">
        </div>
    </div>
    asdf
    @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
    @enderror
</div>



<script>
    $('#calendar')
        .calendar({
            monthFirst: false,
            type: 'date',
            ampm: false,
            // initialDate: new Date(),
            // disabledDaysOfWeek: [5, 6],
            onSelect: function(date, mode) {
                @this.set('datetime', date.toLocaleDateString("tr-TR"));
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
                monthsShort: ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Ek', 'Kas', 'Ara'],
                today: 'Bugün\'Bgn',
                now: 'Şu an',
                am: 'AM',
                pm: 'PM'
            },
        });
</script>