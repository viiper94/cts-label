<p>Имя</p>
<p style="font-weight: bold">{{ $data['name'] }}</p>

<hr>

@if(isset($data['tel']))
    <p>Телефон</p>
    <p style="font-weight: bold">{{ $data['tel'] }}</p>
@endif
