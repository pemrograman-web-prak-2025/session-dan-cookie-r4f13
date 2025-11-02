<li>
    <input type="checkbox" id="toggle-{{ $unit['id'] }}" class="toggle" {{ !empty($unit["children"]) ? "" : "disabled" }}>
    <div class="item">
        <label for="toggle-{{ $unit['id'] }}" class="dropdown-toggle"></label>
        <!-- Checkbox + Label toggle -->

        <img src="{{!empty($unit['image_url'])?$unit['image_url']:'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg'}}" alt="{{ $unit['name'] }}">

        <div class="nama">{{ $unit['name'] }}</div>

        <div class="komandan">
            <i class="fa-solid fa-person-military-pointing"></i>
            {{!empty($unit['leader'])?$unit['leader']:"-"}}
        </div>
            
        <div class="deskripsi">
            <i class="fa-solid fa-person-rifle"></i>
            {{!empty($unit['description'])?$unit['description']:"-"}}
        </div>

        <div class="posisi">
            <i class="fa-solid fa-map-location-dot"></i>
            {{!empty($unit['location'])?$unit['location']:"-"}}
        </div>

        <div class="actions" data-id="{{$unit['id']}}" data-name="{{$unit['name']}}" data-leader="{{$unit['leader']??''}}"
        data-location="{{$unit['location']??''}}" data-image="{{$unit['image_url']??''}}" data-description="{{$unit['description']??''}}"
        >
            <button class="edit">
                <i class="fa-regular fa-pen-to-square"></i>Edit
            </button>
            <a class="delete" href="delete/{{$unit['id']}}">
                <i class="fa-solid fa-trash-can"></i>Hapus
            </a>
            <button class="add">
                <i class="fa-solid fa-plus"></i>Baru
            </button>
        </div>
    </div>

    @if (!empty($unit['children']))
        <ul>
            @foreach ($unit['children'] as $child)
                @include('units.list', ['unit' => $child])
            @endforeach
        </ul>
    @endif
</li>
