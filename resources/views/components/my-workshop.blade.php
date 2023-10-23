<ul>
    @foreach($rows as $row)
        <li><a href="/workshop/rollcall/{{$row->id}}">{{$row->name}}</a></li>
    @endforeach
</ul>
