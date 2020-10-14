<div>
    <div class="p-2 pb-5">
        <h3 class="ui horizontal left aligned divider header">
            <i class="project diagram icon"></i>
            <div class="content">
              {{ __('sections/workorders.header') }}
              <div class="sub header">{{ __('sections/workorders.subheader') }}</div>
            </div>
        </h3>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <form class="ui form p-2" wire:submit.prevent="submit">
            <div class="fields equal width">
                <div class="required field" wire:ignore>
                    <label>{{ __('sections/products.name') }}</label>
                    <x-dropdown.search model="recipe_id" :collection="$this->products" value="recipe->id" text="name,code" class="ui search selection dropdown" />
                    @error('recipe_id')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <div class="required field">
                    <label>{{ __('sections/workorders.lot_no') }}</label>
                    <input wire:model.lazy="lot_no" type="text" placeholder="{{ __('sections/workorders.lot_no') }}">
                    @error('lot_no')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <div class="required field">
                    <label>{{ __('sections/workorders.amount') }}</label>
                    <input wire:model.lazy="amount" type="text" placeholder="{{ __('sections/workorders.amount') }}">
                    @error('amount')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
            </div>
            <div class="equal width fields">
                <div class="required field">
                    <label>{{ __('sections/workorders.code') }}</label>
                    <input wire:model.lazy="code" type="text" placeholder="{{ __('sections/workorders.code') }}">
                    @error('code')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <div class="required field">
                    <label>{{ __('sections/workorders.queue') }}</label>
                    <input wire:model.lazy="queue" type="text" placeholder="{{ __('sections/workorders.queue') }}">
                    @error('queue')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
            </div>    
            <div class="equal width fields">
                <div class="required field">
                    <label for="date">{{ __('sections/workorders.datetime') }}</label>
                    <input type="date" wire:model.lazy="datetime">
                    @error('datetime')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
            </div>
            <div class="fields py-4">
                <div class="field">
                    <div class="ui toggle checkbox">
                        <input wire:model.lazy="is_active" type="checkbox">
                        <label>Aktif</label>
                    </div>
                </div>
            </div>  
    
    
    
            <div>
                @if ($success)
                    <div class="ui positive icon message">
                        <i class="checkmark  icon"></i>
                        <div class="content">
                            <div class="header">
                                <p>{{ __('common.saved_successfully') }}</p>
                            </div>
                            <p>{{ __('common.saved_successfully') }}</p>
                        </div>
                    </div>
                @endif
                <hr>
            </div>

            <x-form-buttons />
    
        </form>
    
    </div>
</div>

<script>
    $(document).ready(function () {
        let select = $('#recipe_id_select');
        select.dropdown();
        $('body').on('mousemove', function() {
                select.dropdown();
            });
    });
</script>




            {{-- $table->unsignedBigInteger('recipe_id');
            $table->string('lot_no');
            $table->integer('amount');
            $table->dateTime('datetime');
            $table->string('code');
            $table->integer('queue');
            $table->boolean('is_active');
            $table->boolean('is_completed')->default(false);
            $table->boolean('in_progress');
            $table->string('note')->nullable(); --}}