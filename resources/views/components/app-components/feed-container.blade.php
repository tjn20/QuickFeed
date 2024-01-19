
 <div class="feeds d-flex flex-column align-items-center gap-4">
    @foreach ($feeds as $feed)
    <livewire:feed :feed="$feed" />
    @endforeach
 </div>
