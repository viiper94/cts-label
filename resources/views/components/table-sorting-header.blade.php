@props(['headers' => null, 'route_name' => null, 'trans' => null])

@foreach($headers as $key)
    <th>
        <a href="{{ route($route_name, [
                'sort' => $key,
                'dir' => (Request::input('dir') === 'up' ? 'down' : 'up'),
                'q' => Request::input('q'),
            ]) }}" class="text-light text-nowrap fw-bold">
            @lang($trans.'.'.$key)
        </a>
        @if(Request::input('sort') === $key)
            <i @class([
                'fa-solid text-warning',
                'fa-arrow-down-a-z' => (Request::input('dir') === 'up'),
                'fa-arrow-down-z-a' => (Request::input('dir') === 'down'),
            ])></i>
        @endif
    </th>
@endforeach
