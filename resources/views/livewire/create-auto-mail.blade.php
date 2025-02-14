<div>
    <form wire:submit="create" >
        {{ $this->form }}


        <div class="text-right pt-4">
            <x-filament::button form="create" type="submit" color="success" size="xl">
                Email Planla
            </x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals/>
</div>
