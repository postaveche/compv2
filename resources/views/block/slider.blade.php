@php
    $sliders = \App\Http\Controllers\SliderController::getSliders($sliderPosition ?? 'home', $categoryId ?? null);
@endphp

@foreach($sliders as $slider)
    @if($slider->activeItems->count() > 0)
        <div class="slider-container mb-4" style="max-height: 500px; overflow: hidden;">
            <div id="slider-{{ $slider->id }}" class="carousel slide" data-ride="carousel" data-interval="5000">
                <!-- Indicators -->
                @if($slider->activeItems->count() > 1)
                    <ol class="carousel-indicators">
                        @foreach($slider->activeItems as $index => $item)
                            <li data-target="#slider-{{ $slider->id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                @endif

                <!-- Slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach($slider->activeItems as $index => $item)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            @if($item->link)
                                <a href="{{ $item->link }}" class="slider-link" data-item-id="{{ $item->id }}">
                            @endif
                                <img src="{{ asset('storage/sliders/' . $item->image) }}"
                                     class="d-block w-100" 
                                     alt="{{ $item->title ?? $slider->name }}"
                                     data-item-id="{{ $item->id }}"
                                     style="max-height: 500px; object-fit: cover; object-position: center;">
                                @if($item->title || $item->description)
                                    <div class="carousel-caption d-none d-md-block">
                                        @php
                                            $locale = app()->getLocale();
                                            $title = $locale == 'ru' ? ($item->title_ru ?? $item->title) : $item->title;
                                            $desc = $locale == 'ru' ? ($item->description_ru ?? $item->description) : $item->description;
                                        @endphp
                                        @if($title)<h5>{{ $title }}</h5>@endif
                                        @if($desc)<p>{{ $desc }}</p>@endif
                                    </div>
                                @endif
                            @if($item->link)
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Controls -->
                @if($slider->activeItems->count() > 1)
                    <a class="carousel-control-prev" href="#slider-{{ $slider->id }}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#slider-{{ $slider->id }}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Tracking script -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Track views
            var itemIds = @json($slider->activeItems->pluck('id'));
            fetch('{{ route("slider.track.view") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: itemIds })
            });

            // Track clicks
            document.querySelectorAll('#slider-{{ $slider->id }} .slider-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    var itemId = this.dataset.itemId;
                    navigator.sendBeacon('{{ url("slider/track-click") }}/' + itemId, 
                        new URLSearchParams({ '_token': '{{ csrf_token() }}' }));
                });
            });
        });
        </script>
    @endif
@endforeach
